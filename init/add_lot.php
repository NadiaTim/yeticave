<?php 
require 'functions.php';
//содержит функцию для расчета оставшегося времени лота 
//и форматирования суммы
require 'helpers.php'; 
//содержит функцию для построения страницы из шаблонов
require 'data.php'; 
//подключает: список категорий, авторизацию
require 'connect.php';
//содержит подключение к БД


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//список существующих категорий
	$categories_ids = array_column($categories, 'category_id');
	
	//пустой массив для ошибок валидации
	$errors = [];
	//список правил для полей
	$rules = [
		'category' => function ($value) use ($categories_ids) {
			return exist_in_array($value, $categories_ids);
		},
		'lot-rate' => function ($value) {
			return input_integer($value);
		},
		'lot-step' => function ($value) {
			return input_integer($value);
		},
		'lot-date' => function ($value) {
			return input_date($value);
		}
	];

	//получаем в массив нового лота поля из отправленной формы
	//при отсутствии поля зачение переменной NULL
	$new_lot = filter_input_array(INPUT_POST, [
		'lot-name'=>FILTER_DEFAULT,
		'category'=>FILTER_DEFAULT,
		'message' =>FILTER_DEFAULT,
		'lot-rate' =>FILTER_DEFAULT,
		'lot-step' =>FILTER_DEFAULT,
		'lot-date' =>FILTER_DEFAULT], true);

	//применение правил валидации к полям формы
	foreach ($new_lot as $key => $value) {
		//проверяем каждое поле нового лота на соответствие его правилу
		if (isset($rules[$key])) {
			$rule = $rules[$key];
			$errors[$key] = $rule($value);
		}
		//проверяем поля нового лота на заполненность
		if (empty($value)) {
			$errors[$key] = "Это обязательное поле";
		}
	}

	//очищаем массив ошибок от пустых значений
	$errors = array_filter($errors);
	//проверка файла
	if ($_FILES['lot-img']['size']>0) {
		//временное имя
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$tmp_name = $_FILES['lot-img']['tmp_name'];
		//$new_lot['img_name'] = $_FILES['lot-img']['name'];

		//размер файла
		$filesize = $_FILES['lot-img']['size'];

		//опредляем MIME-тип файла
		$file_type = finfo_file($finfo, $tmp_name);
		$allow_types = ['image/jpg', 'image/jpeg', 'image/png'];

		if (!in_array($file_type, $allow_types)) {
			$errors['file'] = "Загрузите картинку в формате jpg, jpeg или png";
		} else {
			$type = mb_substr(strstr($file_type, '/'),1);
			$file_name = uniqid('img').'.'.$type;
			//присваиваем новый url
			//$tmp_name = $_FILES['lot-img']['tmp_name'];
			//$name = basename($_FILES["lot-img"]["name"]);
        	//move_uploaded_file($tmp_name, "uploads/$name");
			//$new_lot['url'] = '/uploads/'.$file_name;
			//move_uploaded_file($tmp_name, '/uploads/'.$file_name);
		}
	} else {
		$errors['file'] = 'Вы не загрузили файл';
	}


	//проверяем наличе ошибок
	if (count($errors)) {
		$add_lot = include_template ('add_lot.php', [
			'categories_temp' => $categories_temp,
			'categories'      => $categories,
			'new_lot'         => $new_lot,
			'errors'          => $errors
		]);
	} else {

		//переносим файл из временного хранилища
		//Назначаем уникальное имя
		$type = mb_substr(strstr($file_type, '/'),1);
		$file_name = uniqid('img').'.'.$type;
		//присваиваем новый url
		$new_lot['url'] = '/uploads/'.$file_name;
		$name = basename($file_name);
        move_uploaded_file($tmp_name, "uploads/$name");
		//move_uploaded_file($tmp_name, '/uploads/'.$file_name);


		//формирование запроса на вставку и если запрос удачный, вставка и переход на созданный лот
		$sql = "INSERT INTO lots ( creator_id,  name, category_id, discription, start_price, bet_stage, finsh_date, image) 
			VALUES (1,?,?,?,?,?,?,?)";
		$stmt = db_get_prepare_stmt($con, $sql, $new_lot);
		$res = mysqli_stmt_execute($stmt);

		if ($res) {
            $new_lot_id = mysqli_insert_id($con);
            header("Location: lot.php?lot_id=" . $new_lot_id);
        }
	}
	
} else {
	//вывод отображения страницы без отправки формы
	$add_lot = include_template ('add_lot.php', [
		'categories_temp' => $categories_temp,
		'categories' => $categories
	]);
}

$layout = include_template('layout.php', $data = [
		'title'           => "Создание лота",
		'categories_temp' => $categories_temp,
		'is_auth'         => $is_auth,
		'main'            => $add_lot
 ]);
print($layout);
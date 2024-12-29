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
	$new_lot = filter_input_arry(INTUT_POST, [
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



	//проверяем наличе ошибок
	if (count($errors)) {
		$add_lot_ = include_template ('add_lot.php', [
			'categories_temp' => $categories_temp,
			'categories'      => $categories,
			'new_lot'         => $new_lot,
			'errors'          => $errors
		]);
	} else {
		//формирование запроса на вставку и если запрос удачный, вставка и переход на созданный лот

		if ($res) {
            $gif_id = mysqli_insert_id($link);
            header("Location: gif.php?id=" . $gif_id);
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
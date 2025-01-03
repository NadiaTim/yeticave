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

	//получаем в массив нового пользователя поля из отправленной формы
	//при отсутствии поля зачение переменной NULL
	$new_user = filter_input_array(INPUT_POST, [
		'email'    =>FILTER_DEFAULT,
		'password' =>FILTER_DEFAULT,
		'name'     =>FILTER_DEFAULT,
		'message'  =>FILTER_DEFAULT], true);

	if (!$con) {
	    $errors['sql'] ="Ошибка подключения: ".mysqli_connect_error();
	} else {
	    $sql = "SELECT email FROM users;";
	    $result = mysqli_query($con, $sql);
	    if ($result) {
	        $emails = mysqli_fetch_all($result, MYSQLI_ASSOC);//полученные email из БД
	    } else {
	        $errors['sql'] ="Ошибка запроса: ".mysqli_error($con);
	    }
	}
	

	$emails = array_column($emails, 'email');
	//пустой массив для ошибок валидации
	$errors = [];
	$rules = [
		//проверка уникальности email
		'email' => function ($value) use ($emails) {
			return valid_email($value, $emails);
		}
	];

	//применение правил валидации к полям формы
	foreach ($new_user as $key => $value) {
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
	$errors = array_filter($errors);
	$new_user['password'] = password_hash($new_user['password'], PASSWORD_DEFAULT);

	if (count($errors)) {
		$sign_up = include_template('sign_up.php', [
			'categories_temp' => $categories_temp,
			'errors'          => $errors,
			'new_user'        => $new_user
        ]);
	} else {
		$sql = "INSERT INTO users (email, password, name, contact) VALUES (?,?,?,?);";
		$stmt = db_get_prepare_stmt($con, $sql,$new_user);
		$res = mysqli_stmt_execute($stmt);
		if ($res) {
			header("Location: login.php");
		}
		
	}
	

} else {
	//вывод отображения основного содержания страницы (блок регистрации)
	$sign_up = include_template('sign_up.php', [
		'categories_temp' => $categories_temp,
		'errors'          => []
    ]);
}

//вывод отображения всей страницы
$layout = include_template('layout.php', $data = [
		'title'           => "Регистрация нового аккаунта",
		'categories_temp' => $categories_temp,
		'is_auth'         => $is_auth,
		'main'            => $sign_up
 ]);
print($layout);

?>


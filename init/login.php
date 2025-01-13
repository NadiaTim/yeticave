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


if ($_SERVER['REQUEST_METHOD']=='POST') {

	//получаем и фильтруем данные из формы
	$user = filter_input_array(INPUT_POST,[
		'email'    => FILTER_DEFAULT,
		'password' => FILTER_DEFAULT], true);


	//создаем пустой массив ошибок
	$errors=[];

	//проверяем поля на заполненность
	foreach ($user as $key => $value) {
		if (empty($value)) {
			$errors[$key] = "Это необходимо заполнить";
		}
	}
	

	if (!count($errors)){
		//проверка на существование пользователя с введеным email
		$sql = "SELECT * FROM users WHERE email = ?";
		$stmt = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($stmt,'s', $user['email']);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		//получаем данные пользователя из БД
		$user_sql = $res?mysqli_fetch_array($res,MYSQLI_ASSOC):NULL;

		if ($user_sql) {
		//если пользователь есть проверяем корректность его пароля
			if (password_verify($user['password'], $user_sql['password'])) {
				//начинаем сессию, переходим на главную страницу
				$_SESSION['user'] = $user_sql;
				//подумать как перенаправить на страницу откуда пользователь пришел
				header("Location: /index.php");
				exit();
			} else {
				$errors['password'] = "Введен некорректный пароль";
			}
		} else {
			$errors['email'] = "Данный пользователь не существует";
		}
	}
	$login = include_template('login.php', [
		'categories_temp' => $categories_temp,
		'errors'          => $errors,
		'email'			  => $user['email']
	]);
} else {
	//Стартовое состояние без отправки формы
	$login = include_template('login.php', [
		'categories_temp' => $categories_temp,
		'errors'          =>[]
	]);
}

//вывод отображения всей страницы
$layout = include_template('layout.php', $data = [
		'title'           => "Вход в аккаунт",
		'categories_temp' => $categories_temp,
		'main'            => $login
 ]);
print($layout);
print_r($errors);



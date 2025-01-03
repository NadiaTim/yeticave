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

	//проверка на существование пользователя с введеным email

	//если пользователь есть проверяем корректность его пароля
	$passwordHash //хэш пароля из БД
	if (!password_verify('bad-password', $passwordHash)) {
		$errors['password'] = "Некорректный пароль";
	}

	if (count($errors)) {
		$login = include_template('login.php', [
			'categories_temp' => $categories_temp,
			'errors'          => $errors,
			'email'			  => $user['email']
		]);
	} else {
		//начинаем сессию, переходим на главную страницу
		$_SESSION['user'] = $user;
		//подумать как перенаправить на страницу откуда пользователь пришел
		header("Location: /index.php");
		exit();
	}
	


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
		'is_auth'         => $is_auth,
		'main'            => $login
 ]);
print($layout);



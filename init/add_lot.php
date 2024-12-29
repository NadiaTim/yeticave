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

//вывод отображения страницы
$add_lot = include_template ('add_lot.php',[
	'categories_temp' => $categories_temp,
	'categories' => $categories
]);

$layout = include_template('layout.php', $data = [
        'title'      => "Создание лота",
        'categories_temp' => $categories_temp,
        'is_auth'    => $is_auth,
        'main'       => $add_lot
 ]);
print($layout);
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


if ($_SERVER['REQUEST_METHOD']=='GET') {
	//получение значения кода текущей категории из параметра запроса
	$get_search = filter_input(INPUT_GET, 'search');






}




//получаем список лотов по запросу


$lots_temp = include_template('search.php', [
	'categories_temp' => $categories_temp,
	'lots' => $lots
]);


$layout = include_template('layout.php', $data = [
    'title'      => "Результаты поиска: ".$get_search,
    'categories_temp' => $categories_temp,
    'is_auth'    =>$is_auth,
    'main'       => $lots_temp
 ]);
print($layout);

?>
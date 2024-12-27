<?php
require 'helpers.php'; 
//содержит функцию для построения страницы из шаблонов
require 'data.php'; 
//подключает: список категорий, авторизацию
require 'connect.php';
//содержит подключение к БД


//шаблон для отображения категорий
$categories_temp = include_template('categories.php', [
            'categories' => $categories
        ]);

//шаблон для отображения основного содержимого
$error_temp = include_template('error.php', [
	'categories_temp' => $categories_temp]);


//вывод отображения страницы
$layout = include_template('layout.php', $data = [
        'title'      => "Ошибка 404",
        'categories_temp' => $categories_temp,
        'is_auth'    => $is_auth,
        'main'       => $error_temp
 ]);
print($layout);
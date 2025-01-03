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




//вывод отображения основного содержания страницы (блок регистрации)
$sign_in = include_template('sign_in.php', [
            'categories_temp' => $categories_temp
        ]);

//вывод отображения всей страницы
$layout = include_template('layout.php', $data = [
        'title'      => "Регистрация нового аккаунта",
        'categories_temp' => $categories_temp,
        'is_auth'    => $is_auth,
        'main'       => $sign_in
 ]);
print($layout);

?>


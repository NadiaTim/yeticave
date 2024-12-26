<?php
require 'functions.php';
require 'helpers.php';
require 'data.php';

//подключение к БД
$con = mysqli_connect("MySQL-5.7","root","","yeticave");
if ($con == false) {
    print("Ошибка подключения: ". mysqli_connect_error());
}
//установка кодировки
mysqli_set_charset($con, "utf8");
//получение массива категорий
$sql = "SELECT name, code FROM categories;";
$result = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);//полученные категории из БД



$layout = include_template('layout.php', $data = [
        'title'      => 'Главная страница',
        'categories' => $categories,
        'is_auth'    =>$is_auth,
        'main'       => include_template('main.php', [
            'categories' => $categories,
            'lots'       => $lots
        ])
 ]);
print($layout);

?>

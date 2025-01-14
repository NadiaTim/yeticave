<?php

require 'connect.php';
//получение массива категорий
if (!$con) {
    print("Ошибка подключения: ". mysqli_connect_error());
    $error =mysqli_connect_error();
} else {
    $sql = "SELECT category_id, name, code FROM categories;";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);//полученные категории из БД// 
    } else {
        $error = mysqli_error($con);
        print("Ошибка запроса: ".$error);
    }
}

//вызов шаблона блока категорий
$categories_temp = include_template('categories.php', [
            'categories' => $categories
        ]);
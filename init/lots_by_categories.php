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



//получение значения кода текущей категории из параметра запроса
$get_category = filter_input(INPUT_GET, 'category_code');


//получение массива лотов
if (!$con) {
    //$error = mysqli_connect_error();
    header("Location: https://yeticave.local/error.php");
    die();
} else {
    $sql = "SELECT l.lot_id, l.name, l.start_price, l.image, COALESCE(p.price,l.start_price) fin_price, c.name category, l.finsh_date finish_date
            FROM lots l
            JOIN (SELECT * FROM categories WHERE code = '$get_category') c 
            ON l.category_id = c.category_id
            LEFT JOIN ( SELECT lot_id, max(price) price
                FROM bets
                GROUP BY lot_id) p 
            ON l.lot_id = p.lot_id
            WHERE l.finsh_date>now()
            ORDER BY l.create_date DESC;";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        //$error = mysqli_error($con);
        header("Location: https://yeticave.local/error.php");
    	die();
    }
}


//вывод отображения страницы
$categories_temp = include_template('categories.php', [
    'categories' => $categories
]);

$lots_temp = include_template('lots_by_categories.php', [
	'categories_temp' => $categories_temp,
	'lots' => $lots
]);


$layout = include_template('layout.php', $data = [
    'title'      => $lots[0]['category'],
    'categories_temp' => $categories_temp,
    'is_auth'    =>$is_auth,
    'main'       => $lots_temp
 ]);
print($layout);

?>
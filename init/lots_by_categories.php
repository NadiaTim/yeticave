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

$exist = 0;//счетчик существования
foreach ($categories as $category) {
    if ($category['code']==$get_category) {
        $category_title = $category['name'];
        $exist = $exist + 1;
    }
}
if ($exist<>1) {
    header("Location: https://yeticave.local/error.php?error=404");
    die();
}

//получение массива лотов
if (!$con) {
    $error = mysqli_connect_error();
    header("Location: https://yeticave.local/error.php?error=500");
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
    if (mysqli_num_rows($result)>=1) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $lots = [];  
    }
}


//вывод отображения страницы

$lots_temp = include_template('lots_by_categories.php', [
	'categories_temp' => $categories_temp,
	'lots' => $lots,
    'category_title' => $category_title
]);


$layout = include_template('layout.php', $data = [
    'title'      => $category_title,
    'categories_temp' => $categories_temp,
    'is_auth'    =>$is_auth,
    'main'       => $lots_temp
 ]);
print($layout);

?>
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

//Определяем количество элементов на странице
$page_items = 6;

//определяем текущую страницу
$cur_page = $_GET['page']??1;
//проверяем текущую страницу на допустимость диапазона(min)
$cur_page = $cur_page<1?1:$cur_page;

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
    $res = mysqli_query($con, $sql);
    $lots = mysqli_num_rows($res)>=1?mysqli_fetch_all($res, MYSQLI_ASSOC):[];

    //определяем общее количество лотов
    $items_count = mysqli_num_rows($res);
    //определяем полученное количество страниц
    $page_count = ceil($items_count/$page_items);
    //проверяем текущую страницу на допустимость диапазона(max)
    $cur_page = $cur_page>$page_count?$page_count:$cur_page;
    //определяем с какой записи необходимо отображать содержание
    $offset = ($cur_page-1)*$page_items;
    $lots = array_slice($lots, $offset, $page_items);
    
}



//отображение шаблона пагинации
$pagination = include_template('pagination.php', [
    'cur_page'   => $cur_page,
    'page_count' => $page_count ]);


//вывод отображения страницы

$lots_temp = include_template('lots_by_categories.php', [
    'categories_temp' => $categories_temp,
    'lots'            => $lots,
    'category_title'  => $category_title,
    'pagination'      => $pagination
]);


$layout = include_template('layout.php', $data = [
    'title'           => $category_title,
    'categories_temp' => $categories_temp,
    'main'            => $lots_temp
 ]);
print($layout);

?>
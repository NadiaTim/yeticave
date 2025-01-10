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

//Определяем количество элементов на странице
$page_items = 3;

//определяем текущую страницу
$cur_page = $_GET['page']??1;
$cur_page = $cur_page<1?1:$cur_page;

//текст запроса для получения всех необходимых данных
$sql = "SELECT l.lot_id, l.name, l.start_price, l.image, COALESCE(p.price,l.start_price) fin_price, c.name category, l.finsh_date finish_date
    FROM lots l
    JOIN categories c 
    ON l.category_id = c.category_id
    LEFT JOIN ( SELECT lot_id, max(price) price
        FROM bets
        GROUP BY lot_id) p 
    ON l.lot_id = p.lot_id
    WHERE l.finsh_date>now()
    ORDER BY l.create_date DESC";
$res = mysqli_query($con, $sql);

if ($res) {

    //определяем общее количество 
    $items_count = mysqli_num_rows($res);
    $page_count = ceil($items_count/$page_items);

    //проверяем текущую страницу на допустимость диапазона
    $cur_page = $cur_page>$page_count?$page_count:$cur_page;

    //определяем с какой записи необходимо отображать содержание
    $offset = ($cur_page-1)*$page_items;

    //формируем новый sql-запрос с ограничением записей по странице
    $sql = $sql . " LIMIT " . $page_items . " OFFSET " . $offset;
    $res = mysqli_query($con, $sql);
    $lots = $res?mysqli_fetch_all($res, MYSQLI_ASSOC):header("Location: error.php?error=503");


} else {
    header("Location: error.php?error=503");
}


/*
//получение массива лотов
if (!$con) {
    print("Ошибка подключения: ". mysqli_connect_error());
    $error = mysqli_connect_error();
} else {
    $sql = "SELECT l.lot_id, l.name, l.start_price, l.image, COALESCE(p.price,l.start_price) fin_price, c.name category, l.finsh_date finish_date
            FROM lots l
            JOIN categories c 
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
        $error = mysqli_error($con);
        print("Ошибка запроса: ".$error);
    }
}
*/



//вывод отображения страницы
$categories_temp = include_template('categories.php', [
        'categories' => $categories ]);

//отображение шаблона пагинации
$pagination = include_template('pagination.php', [
    'cur_page'   => $cur_page,
    'page_count' => $page_count ]);

$layout = include_template('layout.php', $data = [
    'title'           => 'Главная страница',
    'categories_temp' => $categories_temp,
    'main'            => include_template('main.php', [
        'categories' => $categories,
        'lots'       => $lots,
        'pagination' => $pagination
    ])
 ]);
print($layout);

?>

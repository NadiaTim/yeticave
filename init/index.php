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
if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);//полученные категории из БД// 
} else {
    $error = mysqli_error($con);
    print("Ошибка запроса: ".$error);
}


//получение массива лота
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



//вывод отображения страницы

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

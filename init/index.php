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


//вывод отображения страницы
$categories_temp = include_template('categories.php', [
            'categories' => $categories
        ]);

$layout = include_template('layout.php', $data = [
        'title'      => 'Главная страница',
        'categories_temp' => $categories_temp,
        'is_auth'    =>$is_auth,
        'main'       => include_template('main.php', [
            'categories' => $categories,
            'lots'       => $lots
        ])
 ]);
print($layout);

?>

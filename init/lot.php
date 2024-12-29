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


//получение значения текущего лота из параметра запроса
$get_lot_id = filter_input(INPUT_GET, 'lot_id');

//получение лота
if (!$con) {
    //вывод ошибки подключения
    //$error = mysqli_connect_error();
    header("Location: https://yeticave.local/error.php");
    die();
} else {
    $sql = "SELECT l.lot_id, l.name name, l.image, COALESCE(p.price,l.start_price) fin_price, c.name category, l.finsh_date finish_date, l.discription, l.bet_stage
			FROM (SELECT * from lots WHERE lot_id = '$get_lot_id;') l
			JOIN categories c 
			ON l.category_id = c.category_id
			LEFT JOIN ( SELECT lot_id, max(price) price
				FROM bets
				GROUP BY lot_id) p 
			ON l.lot_id = p.lot_id;";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result)>=1) {
        $lot = mysqli_fetch_assoc($result);
    } else {
        //вывод ошибки запроса
        //$error = mysqli_error($con);
        header("Location: https://yeticave.local/error.php");
        die();
    }
}

$lot_temp = include_template('lot.php', [
            'categories_temp' => $categories_temp,
            'lot'       => $lot
        ]);

//вывод отображения страницы
$layout = include_template('layout.php', $data = [
        'title'      => $lot["name"],
        'categories_temp' => $categories_temp,
        'is_auth'    => $is_auth,
        'main'       => $lot_temp
 ]);
print($layout);

?>
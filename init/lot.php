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
$get_lot_id = (int) filter_input(INPUT_GET, 'lot_id');

//получение лота
if (!$con) {
    //вывод ошибки подключения
    //$error = mysqli_connect_error();
    header("Location: https://yeticave.local/error.php?error=500");
    die();
} else {
    //получаем информацию по лоту
    $sql = "SELECT l.lot_id, l.name name, l.image, COALESCE(p.price,l.start_price) fin_price, c.name category, l.finsh_date finish_date, l.discription, l.bet_stage
		FROM (SELECT * from lots WHERE lot_id = ?) l
		JOIN categories c 
		ON l.category_id = c.category_id
		LEFT JOIN ( SELECT lot_id, max(price) price
			FROM bets
			GROUP BY lot_id) p 
		ON l.lot_id = p.lot_id;";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,'i', $get_lot_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($res)>=1) {
        $lot = mysqli_fetch_assoc($res);
    } else {
        //вывод ошибки запроса, если строк не найдено
        //$error = mysqli_error($con);
        header("Location: https://yeticave.local/error.php");
        die();
    }

    //получаем историю ставок по лоту
    $sql = "SELECT price, bet_date, u.name
        FROM bets b
        JOIN users u ON b.user_id=u.user_id
        WHERE lot_id=?
        ORDER BY bet_date DESC;";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,'i', $get_lot_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $bets = (mysqli_num_rows($res)>=1 && $res)?mysqli_fetch_all($res, MYSQLI_ASSOC):NULL;

}

if ($_SERVER['REQUEST_METHOD']=='POST') {
    // code...
}

$lot_temp = include_template('lot.php', [
            'categories_temp' => $categories_temp,
            'lot'             => $lot,
            'bets'            => $bets
        ]);

//вывод отображения страницы
$layout = include_template('layout.php', $data = [
        'title'           => $lot["name"],
        'categories_temp' => $categories_temp,
        'is_auth'         => $is_auth,
        'main'            => $lot_temp
 ]);
print($layout);

?>
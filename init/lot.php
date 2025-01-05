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
}

    //получаем информацию по лоту
$sql = "SELECT l.lot_id, l.name name, l.image, COALESCE(p.price,l.start_price) fin_price, c.name category, l.finsh_date finish_date, l.discription, l.bet_stage, l.creator_id
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
    $lot = mysqli_fetch_assoc($res)??NULL;
    $lot['min_bet'] = $lot['fin_price'] + $lot['bet_stage'];
} else {
    //вывод ошибки запроса, если строк не найдено
    //$error = mysqli_error($con);
    header("Location: https://yeticave.local/error.php");
    die();
}


if ($_SERVER['REQUEST_METHOD']=='POST' && isset($lot)) {
    //Получаем введенное пользователем значение ставки
    $new_bet['cost'] = filter_input(INPUT_POST, 'cost')??NULL;

    if ($new_bet['cost']>=$lot['min_bet']) {
        $new_bet['user_id'] = $_SESSION['user']['user_id'];
        $new_bet['lot_id'] = $lot['lot_id'];

        //начинаем транзакцию
        mysqli_query($con, "START TRANSACTION");

        //выполняем первый запрос
        $sql_1 = "INSERT INTO bets (price, user_id, lot_id) VALUES (?,?,?)";
        $stmt = db_get_prepare_stmt($con, $sql_1, [$new_bet['cost'],$new_bet['user_id'],$new_bet['lot_id'] ]);
        $res1 = mysqli_stmt_execute($stmt);

        //выполняем второй запрос
        $sql_2 = "UPDATE lots SET winner_id=? WHERE lot_id=?";
        $stmt = db_get_prepare_stmt($con, $sql_2, [$new_bet['user_id'], $new_bet['lot_id']]);
        $res2 = mysqli_stmt_execute($stmt);

        //завершаем транзакцию
        if ($res1 && $res2) {
            mysqli_query($con, "COMMIT");
        } else {
            mysqli_query($con, "ROLLBACK");
            $new_bet['error'] = "Ставка не учтена";
        }
    } else {
        $new_bet['error'] = "Ставка должна быть больше минимальной";
    }
} else {
    $new_bet= null;
}

//получаем историю ставок по лоту
$sql = "SELECT price, bet_date, u.name, u.user_id
    FROM bets b
    JOIN users u ON b.user_id=u.user_id
    WHERE lot_id=?
    ORDER BY bet_date DESC;";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt,'i', $get_lot_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$bets = (mysqli_num_rows($res)>=1 && $res)?mysqli_fetch_all($res, MYSQLI_ASSOC):NULL;

//проверяем наличия авторизации пользователя для добавления новой ставки
if (isset($_SESSION['user'])) {
    $new_bet['notallowed'] = NULL;
    
    if(isset($bets[0]['user_id'])){
        $new_bet['notallowed'] = $_SESSION['user']['user_id'] == $bets[0]['user_id']?"Ваша ставка была последней":$new_bet['notallowed'];
    }
    $new_bet['notallowed'] = $_SESSION['user']['user_id'] == $lot['creator_id']? "Вы - владелец лота":$new_bet['notallowed'];
    $rest_time = rest_time($lot['finish_date']);
    $new_bet['notallowed'] = ($rest_time[0]==0 && $rest_time[1]==0 && $rest_time[2]==0)?"Время вышло. Ставки больше не принимаются":$new_bet['notallowed'];

} else {
    $new_bet['notallowed'] = "Авторизируйтесь, чтобы сделать ставку";
}


$lot_temp = include_template('lot.php', [
    'categories_temp' => $categories_temp,
    'lot'             => $lot,
    'bets'            => $bets,
    'new_bet'         => $new_bet
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
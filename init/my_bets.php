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

if (isset($_SESSION['user'])) {
	$sql = "SELECT b.bet_date, b.price, l.name, l.image, l.winner_id, l.finsh_date, u.contact, c.name
		FROM bets b
		JOIN lots l ON b.lot_id=l.lot_id
		JOIN users u ON l.creator_id=u.user_id
		JOIN categories c ON l.category_id=c.category_id
		WHERE b.user_id = $_SESSION['user']['user_id']; ";
	$res = mysqli_query($con, $sql);
	$bets = $res?mysqli_fetch_all($result, MYSQLI_ASSOC):header("Location: error.php");
	if (count($bets)>0) {
		foreach ($bets as $bet) {
			// code...
		}
	} else {
		$bets = NULL;
	}

} else {
	header("Location: error.php?error=403");
}


$my_bets = include_template('lot.php', [
    'categories_temp' => $categories_temp,
    'bets'            => $bets
]);

//вывод отображения страницы
$layout = include_template('layout.php', $data = [
        'title'           => $lot["name"],
        'categories_temp' => $categories_temp,
        'is_auth'         => $is_auth,
        'main'            => $my_bets
 ]);
print($layout);

?>
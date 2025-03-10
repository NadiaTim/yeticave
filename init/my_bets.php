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

	$sql = 	"SELECT b.bet_date, b.price, l.name lot_name, l.image, l.finsh_date, u.contact, c.name cat_name, l.lot_id, win.winner
		FROM bets b
		JOIN lots l ON b.lot_id=l.lot_id
		JOIN users u ON l.creator_id=u.user_id
		JOIN categories c ON l.category_id=c.category_id
        left JOIN ( SELECT  bet_id, 1 as winner FROM 
                (SELECT *, IF(@prev != lot_id, @rn:=1, @rn:=@rn+1) as rank, @prev:=lot_id
                FROM bets, (SELECT @rn:=0, @prev:=NULL) as vars
                ORDER BY lot_id, price DESC) t1
			WHERE rank=1) win ON b.bet_id=win.bet_id
		WHERE b.user_id = ".$_SESSION['user']['user_id'].
		" ORDER BY b.bet_date DESC";
	$res = mysqli_query($con, $sql);
	$bets = $res?mysqli_fetch_all($res, MYSQLI_ASSOC):header("Location: error.php?error=503");
	if (isset($bets)) {
		foreach ($bets as $key => $bet) {
			$n_bets[$key] = $bet;
			$n_bets[$key]['time_ago'] = time_ago_text($bet['bet_date']);
			$rest_time = rest_time($bet['finsh_date']);
			if ($rest_time[0]==0 && $rest_time[1]==0 && $rest_time[2]==0) {
				if ($bet['winner']==1) {
					$n_bets[$key]['status_id'] = "win";
					$n_bets[$key]['status'] = "Ставка выйграла";
				} else {
					$n_bets[$key]['status_id'] = "end";
					$n_bets[$key]['status'] = "Торги окончены";
				}
			} else {
				if ($rest_time[0]==0 && $rest_time[1]<=1) {
					$n_bets[$key]['status_id'] = "finishing";
					$n_bets[$key]['status'] = "$rest_time[1]:$rest_time[2]";
				} else {
					$n_bets[$key]['status_id'] = "activ";
					$n_bets[$key]['status'] = "$rest_time[0]"."д ". "$rest_time[1]:$rest_time[2]";
				}
				
			}
			
		}
	} else {
		$n_bets = NULL;
	}

} else {
	header("Location: error.php?error=401");
}


$my_bets = include_template('my_bets.php', [
    'categories_temp' => $categories_temp,
    'bets'            => $n_bets
]);

//вывод отображения страницы
$layout = include_template('layout.php', $data = [
        'title'           => "Совершенные ставки",
        'categories_temp' => $categories_temp,
        'main'            => $my_bets
 ]);
print($layout);

?>
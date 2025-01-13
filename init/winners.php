<?php
//подключаем файл с соединением к БД
require 'connect.php';

//определяем массив выйгравших
$sql="SELECT l.lot_id, l.name, win.price, u.email, u.user_id
	FROM lots l
	LEFT join (SELECT *, IF(@prev != lot_id, @rn:=1, @rn:=@rn+1) as rank, @prev:=lot_id
		FROM bets, (SELECT @rn:=0, @prev:=NULL) as vars
		ORDER BY lot_id, price DESC) win ON l.lot_id = win.lot_id
	JOIN users u ON win.user_id= u.user_id
	WHERE finsh_date<now()
	AND rank=1
	ORDER BY PRICE DESC, name DESC;";
$res = mysqli_query($con, $sql);
$winners = $res?mysqli_fetch_all($res, MYSQLI_ASSOC):header("Location: error.php?error=503");

//каждый из завершенных лотов отдельно обрабатываем
foreach ($winners as $winner) {
	//вносим информацию о выйгрыше в бд
	$sql = "UPDATE lots 
		SET winner_id = ".$winner['user_id'].
		" WHERE lot_id = ".$winner['lot_id'];
	$res = mysqli_query($con, $sql);
	print("Лот ".$winner["name"]." выйграл ".$winner["email"]." - ".$winner["user_id"]."<br />");
}

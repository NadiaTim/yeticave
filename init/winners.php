<?php
//подключаем файл с соединением к БД
require 'connect.php';
//подсключаем файл со вспомогательными функциями, для формирования шаблона
require_once 'helpers.php';

//подключаем библиотеку symfony/mailer для формирования и отправки письма-уведомления о победе
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
//подключение автозагрузки от composer
require_once '../vendor/autoload.php';



//определяем массив выйгравших
$sql="SELECT l.lot_id, l.name, win.price, u.email, u.user_id, u.name user_name
	FROM lots l
	LEFT join (SELECT *, IF(@prev != lot_id, @rn:=1, @rn:=@rn+1) as rank, @prev:=lot_id
		FROM bets, (SELECT @rn:=0, @prev:=NULL) as vars
		ORDER BY lot_id, price DESC) win ON l.lot_id = win.lot_id
	JOIN users u ON win.user_id= u.user_id
	WHERE finsh_date<now()
	AND rank=1
	AND l.winner_id IS NULL
	ORDER BY PRICE DESC, name DESC;";
$res = mysqli_query($con, $sql);
$winners = $res?mysqli_fetch_all($res, MYSQLI_ASSOC):header("Location: error.php?error=503");

if (count($winners)>0) {
	//определение SMTP password:opitmzptufuruzqm
	$dsn = 'smtp://ko-te-nok2000wampir:opitmzptufuruzqm@smtp.yandex.ru:465';
	$transport = Transport::fromDsn($dsn);
	//каждый из завершенных лотов отдельно обрабатываем
	foreach ($winners as $winner) {
		//вносим информацию о выйгрыше в бд
		$sql = "UPDATE lots 
			SET winner_id = ".$winner['user_id'].
			" WHERE lot_id = ".$winner['lot_id'];
		$res = mysqli_query($con, $sql);

		//Формируем письмо победителю(человеку с наибольшей ставкой по лоту)

		//создаем объект библиотеки Symfony Mailer, ответственный за отправку сообщений
		$mailer = new Mailer($transport);
		//устанавливаем параметры сообщения: тема, отправитель и получателя
		$message = (new Email())
			->subject("Ваша ставка победила")
			->from('ko-te-nok2000wampir@yandex.ru')
			->to($winner["email"]);
		$msg_content = include_template('email.php', ['winner' => $winner]);
		//устанавливаем параметр сообщения - текст содержания
		$message->html($msg_content);
		//Отправляем подготовленное сообщение
		$mailer->send($message);
	}
	
}



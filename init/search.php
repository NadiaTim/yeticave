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


if ($_SERVER['REQUEST_METHOD']=='GET') {
	//получение значения кода текущей категории из параметра запроса
	$get_search = filter_input(INPUT_GET, 'search')??NULL;
	$get_search = trim($get_search);


	if ($get_search) {
		//получчаем список лотов
		$sql = "SELECT l.lot_id, l.name, l.start_price, l.image, COALESCE(p.price,l.start_price) fin_price, c.name category, l.finsh_date finish_date
            FROM lots l
            JOIN categories c 
            ON l.category_id = c.category_id
            LEFT JOIN ( SELECT lot_id, max(price) price
                FROM bets
                GROUP BY lot_id) p 
            ON l.lot_id = p.lot_id
            WHERE l.finsh_date>now() 
            AND MATCH(l.name, discription) AGAINST(?)
            ORDER BY l.create_date DESC;";

            $stmt = mysqli_prepare($con, $sql);
			mysqli_stmt_bind_param($stmt,'s', $get_search);
			mysqli_stmt_execute($stmt);
			$res = mysqli_stmt_get_result($stmt);
			$lots =$res?mysqli_fetch_all($res, MYSQLI_ASSOC):NULL;
			$lots =count($lots)>0?$lots:NULL;
	} else {
		// выводим ошибку если запрос пустой
		header("Location: error.php?error=400");
		exit();
	}
} else {
	//переходим на главную страницу если форма не была отправлена
	header("Location: index.php");
	exit();
}

$search_tmp = include_template('search.php', [
	'categories_temp' => $categories_temp,
	'lots'            => $lots,
	'search'          => $get_search
]);


$layout = include_template('layout.php', $data = [
	'title'           => "Результаты поиска: ".$get_search,
	'categories_temp' => $categories_temp,
	'is_auth'         =>$is_auth,
	'main'            => $search_tmp
 ]);
print($layout);


?>
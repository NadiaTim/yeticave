<?php
session_start();
//подключение к БД
$con = mysqli_connect("MySQL-5.7","root","","yeticave");
mysqli_set_charset($con, "utf8");
if (!$con) {
	header("Location: error.php?error=500");
}
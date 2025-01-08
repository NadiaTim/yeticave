<?php
require 'helpers.php'; 
//содержит функцию для построения страницы из шаблонов
require 'data.php'; 
//подключает: список категорий, авторизацию
require 'connect.php';
//содержит подключение к БД



$error_id = (int) filter_input(INPUT_GET, 'error');
switch ($error_id) {
        case '400':
                $error['id'] = 400;
                $error['name'] = "400 Неправильный запрос";
                $error['discription'] = "Обязательный параметр запроса не был указан для этого запроса";
                break;
        case '401':
                $error['id'] = 401;
                $error['name'] = "401 Ошибка авторизации";
                $error['discription'] = "Для доступа к странице пройдите зарегистрируйтесь или войдите в систему";
                break;
        case '403':
                $error['id'] = 403;
                $error['name'] = "403 Запрещено";
                $error['discription'] = "Для данного пользователя заблокирован доступ к странице";
                break;
        case '404':
                $error['id'] = 404;
                $error['name'] = "404 Страница не найдена";
                $error['discription'] = "Данной страницы не существует на сайте.";
                break;
        case '500':
                $error['id'] = 500;
                $error['name'] = "500 Ошибка сервера";
                $error['discription'] = "Нет доступа к серверу. Попробуйте повторить операцию позже";
                break;
        case '506':
                $error['id'] = 503;
                $error['name'] = "503 Ошибка запроса";
                $error['discription'] = "Серверу не удается получить запросы. Повторите запрос.";
                break;
        default:
                $error['id'] = 0;
                $error['name'] = "Ошибка не определена";
                $error['discription'] = "Данная ошибка не записана в реесте.";
                break;
}

//шаблон для отображения основного содержимого
$error_temp = include_template('error.php', [
        'categories_temp' => $categories_temp,
        'error'           => $error]);

//вывод отображения страницы
$layout = include_template('layout.php', $data = [
        'title'      => "Ошибка ". $error['id'],
        'categories_temp' => $categories_temp,
        'is_auth'    => $is_auth,
        'main'       => $error_temp
 ]);
print($layout);
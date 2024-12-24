<?php
//индикатор авторизации
$is_auth = rand(0, 1);
//имя пользователя
$user_name = '';
//массив категорий
$categories = [
    'boards'     => 'Доски и лыжи',
    'attachment' => 'Крепления',
    'boots'      => 'Ботинки',
    'clothing'   => 'Одежда',
    'tools'      => 'Инструменты',
    'other'      => 'Разное'
];
//массив лотов/товаров
$lots = [
    [
        'lot'      => '2014 Rossignol District Snowboard',
        'category' => 'boards',
        'price'    => '10999',
        'url'      => 'img/lot-1.jpg'
    ],
    [
        'lot'      => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'boards',
        'price'    => '159999',
        'url'      => 'img/lot-2.jpg'
    ],
    [
        'lot'      => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'attachment',
        'price'    => '8000',
        'url'      => 'img/lot-3.jpg'
    ],
    [
        'lot'      => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'boots',
        'price'    => '10999',
        'url'      => 'img/lot-4.jpg'
    ],
    [
        'lot'      => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'clothing',
        'price'    => '7500',
        'url'      => 'img/lot-5.jpg'
    ],
    [
        'lot'      => 'Маска Oakley Canopy',
        'category' => 'other',
        'price'    => '5400',
        'url'      => 'img/lot-6.jpg'
    ],
];
<?php
require 'functions.php';
require 'helpers.php';
require 'data.php';

$layout = include_template('layout.php', $data = [
        'title'      => 'Главная страница',
        'categories' => $categories,
        'is_auth'    =>$is_auth,
        'main'       => include_template('main.php', [
            'categories' => $categories,
            'lots'       => $lots
        ])
 ]);
print($layout);

?>

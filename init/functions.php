<?php
/**
 * Форматирует сумму и добавляет к ней знак рубля
 *
 * Примеры использования:
 * price_format('124'); // 124 ₽
 * price_format('14876'); // 14 876 ₽
 * price_format('1234567'); // 1 234 567 ₽

 *
 * @param int $price целое число цены
 *
 * @return string отформатированная сумма с делением на разряды и знака рубля в конце 
 */
function price_format(int $price) : string {
    $price = ceil($price);
    $price = number_format($price, 0,"."," ");
    $price = $price." "."₽";
    return $price;    
};

/**
 * Рассчитывает оставшееся количество часов и минут от введенной даты до текущей
 * Примеры использования (текущая дата 2024-12-25 0:34):
 * rest_time('2024-12-26'); //
 * 
 * 
 * на вход функция принимает дату в формате ГГГГ-ММ-ДД;
 * возвращает массив, где первый элемент — целое количество часов до даты, а второй — остаток в минутах.
 * 
 * 
 */
function rest_time($dateFin) {
    $dateFin = strtotime($dateFin);
    $dateNow = strtotime("now");
    $diff    = $dateFin - $dateNow;
    $days    = floor($diff/86400);
    $hours   = floor($diff/3600) - $days*24;
    $minutes = floor($diff/60) - $hours*60 - $days*24*60;

    
    $hours   = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
    $arrRez[] = $days;
    $arrRez[] = $hours;
    $arrRez[] = $minutes;

    return $arrRez;
};
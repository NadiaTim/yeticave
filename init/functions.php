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
}
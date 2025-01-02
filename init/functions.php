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
    if ($diff>0) {
        $days    = floor($diff/86400);
        $hours   = floor($diff/3600) - $days*24;
        $minutes = floor($diff/60) - $hours*60 - $days*24*60;
    } else {
        $days    = 0;
        $hours   = 0;
        $minutes = 0;
    }
    
    
    $hours   = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
    $arrRez[] = $days;
    $arrRez[] = $hours;
    $arrRez[] = $minutes;

    return $arrRez;
};



///ФУНКЦИИ ВАЛИДАЦИИ
/**
 * Проверяет наличие категории в массиве допустимых элементов
 * 
 * 
 * 
 *
 * */
function exist_in_array($id, $allowed_list){
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
};

/**
 * Проверяет полеченное значение на числовой формат, целочисленность и положительность
 * 
 * 
 * 
 * */
function input_integer($value){
    if (!is_numeric($value)) {
        return "Данные должны быть в числовом формате";  
    } else {
        if (($value%1)!=0) {
            return "Данные должны быть целым числом";
        }
    }  
};

/**
 * Проверяет полученное значение на соответствие формату гггг-мм-дд или гггг-мм-дд чч:мм
 * Полученное значение больше текущей минимум на 1 день
 * 
 * 
 * 
 * */
function input_date($date){
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);
    if ($dateTimeObj !== false && array_sum(date_get_last_errors()) === 0){
        $dateFin = strtotime($date);
        $dateNow = strtotime("now");
        $diff_d    = ($dateFin - $dateNow)/3600;
        if ($diff_d >=1) {
            return;
        }
        return "Дата должна быть больше текущей даты, хотя бы на один день";
    }
    return "Дата должна быть фориата гггг-мм-дд чч:мм";
}
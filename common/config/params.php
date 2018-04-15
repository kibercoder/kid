<?php

//Даты для ограничения даты рождения в форме
$date = new DateTime();
$date->modify('-18 year');
$startDate = $date->format('Y-m-d');

$date2 = new DateTime();
$date2->modify('-7 year');
$endDate = $date2->format('Y-m-d');

return [
    'adminEmail' => 'tisafarov@gmail.com',
    'supportEmail' => 'tisafarov@gmail.com',
    'user.passwordResetTokenExpire' => 3600,
    'fullPathAvatar' => $_SERVER['DOCUMENT_ROOT'].'/frontend/web/avatars/165x165/',
    'path_frontend' => $_SERVER['DOCUMENT_ROOT'].'/frontend/web/',
    //Максимальный размер загружаемого файла в байтах (в данном случае(1048576) он равен 1 Мб).
    'max_filesize_img' => 10485760,
    'start_date' => $startDate,
    'end_date' => $endDate
];

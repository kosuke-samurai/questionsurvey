<?php

$random_number = rand(1, 5);

if($random_number == 1){
$result = "🍺";
} else if($random_number == 2){
$result = "中吉";
} else if($random_number == 3){
$result = "小吉";
} else if($random_number == 4){
$result = "凶";
} else if($random_number == 5){
$result = "大凶";
}

//画面にデータを表示する
//echo $result;

$array = ["大吉","中吉","小吉","凶","大凶"];

//検証するときは、var_dump();exit();
//var_dump($array);
//exit();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        
    </style>
    <title>Document</title>
</head>
<body>
    <h1>今日の運勢は<?=$result?>です！</h1>
</body>
</html>
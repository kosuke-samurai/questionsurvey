<?php

$random_number = rand(1, 5);

if($random_number == 1){
$result = "ðº";
} else if($random_number == 2){
$result = "ä¸­å";
} else if($random_number == 3){
$result = "å°å";
} else if($random_number == 4){
$result = "å¶";
} else if($random_number == 5){
$result = "å¤§å¶";
}

//ç»é¢ã«ãã¼ã¿ãè¡¨ç¤ºãã
//echo $result;

$array = ["å¤§å","ä¸­å","å°å","å¶","å¤§å¶"];

//æ¤è¨¼ããã¨ãã¯ãvar_dump();exit();
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
    <h1>ä»æ¥ã®éå¢ã¯<?=$result?>ã§ãï¼</h1>
</body>
</html>
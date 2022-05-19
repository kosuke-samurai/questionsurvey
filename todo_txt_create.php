<?php
//var_dump($_POST);
//exit();

$todo = $_POST["todo"];
$deadline = $_POST["deadline"];

//（変数をスペースでつなげて最後に改行をいれる）
$write_data = "{$deadline} {$todo}\n";

//書き込み先のファイルを開く
$file = fopen("data/todo.txt","a");
//他の人が書き込まないようファイルをロックする
flock($file, LOCK_EX);

//ファイルに書き込む
fwrite($file, $write_data);

//ロックを解除する
flock($file, LOCK_UN);
//ファイルを閉じる
fclose($file);

//表示はtodo_txt_input.phpの状態に
header("Location:todo_txt_input.php");
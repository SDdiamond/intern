<html>
<head>
<meta charset="utf-8">
<title>登録画面</title>
</head>
<body>

<?php
$mail = $_POST["mail"];
$approve = mt_rand(0, 99999);

//五桁の数にする
$num = mb_strlen($approve);
if($num != 5){
	for($i=0; $i<5-$num; $i++){
		$approve = "0".$approve;
	}
} 

//echo $approve."<br>";

mb_language("Japanese");
mb_internal_encoding("UTF-8");

include("./mission_3-1.php");

//送信情報
$to = $mail;
$subject = "TEST MAIL";
$message = "Hello!\r\nThis is TEST MAIL\r\n認証番号「".$approve."」\r\n".date("Y年m月d日H時i分s秒");
$from = "From: yukkuri1997@gmail.com\r\n";
$from .= "Return-Path: yukkuri1997@gmail.com";

$sql="CREATE TABLE IF NOT EXISTS toregister"
	."("
	."id INT,"
	."mail char(32),"
	."pass char(32),"
	."time char(32),"
	."parmit char(32)"
	.");";
$stmt=$pdo->query($sql);

$sql="SELECT * FROM toregister ORDER BY id;";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$count=$stmt->rowCount();

//メール送信済みか
$bool = 0;

foreach ($stmt as $row){
	if($mail == $row['mail']){
		$bool = 1;
	}
	$count = $row['id'];
}


if($mail != null and $bool == 0){
	//メール送信
	$send = mb_send_mail($to, $subject, $message, $from);

	$sql = $pdo -> prepare("INSERT INTO toregister (id, mail, pass, time, parmit) VALUES (:id, :mail, :pass, :time, :parmit)");
	$sql -> bindParam(':id', $id, PDO::PARAM_INT);
	$sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$sql -> bindParam(':time', $time, PDO::PARAM_STR);
	$sql -> bindParam(':parmit', $parmit, PDO::PARAM_STR);

	$id = $count+1;
	$mail = $mail;
	$pass = $approve;
	$time = date("YmdHis");
	$parmit = "No";

	$sql -> execute();
}

//送信確認用
if($send){
	echo $mail."へ送信しました。<br>";
	//echo $message."<br>";
}else{
	if($bool == 1){
		echo "このメールにはすでに送信済みです。<br>";
	}else{
		echo "送信に失敗しました。<br>もう一度やり直してください。<br>";
	}
}

//確認用
/*$sql="SELECT * FROM toregister ORDER BY id;";
$result=$pdo->prepare($sql);
$result->execute();

foreach ($result as $row){
	echo $row['id'].',  ';
	echo $row['mail'].',  ';
	echo $row['pass'].',  ';
	echo $row['time'].',  ';
	echo $row['parmit'].'<br>';
}
*/

?>
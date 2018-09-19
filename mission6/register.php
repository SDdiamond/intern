<html>
<head>
<meta charset="utf-8">
</head>
<?php
include("./mission_3-1.php");

$approve = $_POST["approve"];
$pass1 = $_POST["pass1"];
$pass2 = $_POST["pass2"];

//現在時刻
$time1 = date("YmdHis");
//メール送信時刻
$time2 = 0;

//echo $time1."<br>";

$sql="SELECT * FROM toregister ORDER BY id;";
$stmt=$pdo->prepare($sql);
$stmt->execute();
foreach($stmt as $line){
	if($approve == $line['pass']){
		$mail = $line['mail'];
		$time2 = $line['time'];
		$parmit = $line['parmit'];
		break;
	}
	//echo "aaa<br>";
} 

//echo $time1 - $time2."<br>";
//echo $mail."<br>".$time2."<br>";

//1時間以内か
if($time1 - $time2 < 100000 && $parmit != "Yes"){
	//echo "bbb<br>";
	if($pass1 == $pass2){
		$pdo->beginTransaction();
		$stmt=$pdo->prepare("UPDATE toregister SET pass='$pass1', parmit='Yes' where mail='$mail';");		
		$stmt->execute();
		$pdo->commit();
		echo "登録完了";
	}
}else{
	echo "期限が切れているか、すでに登録済みです。<br>";
}

//期限切れを削除
foreach($stmt as $line){
	//メール送信時刻が1時間以上で認証されてないもの
	if($line['time'] - $time1 > 100000 && $line['parmit'] != "Yes"){
		$id = $line['id'];
		$sql="DELETE FROM toregister WHERE id = $id ;";
		$result=$pdo->prepare($sql);
		$result->execute();
	}
}


?>

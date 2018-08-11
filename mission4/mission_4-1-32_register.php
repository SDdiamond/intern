<html>
<head>
<meta charset="utf-8">
<title>register</title>
</head>
<body>

<?php
$name = $_POST["name"];
$pass = $_POST["pass"];
//$filename = "mission_4-1-3.txt";

//include("./mission_4-1-3login.html");
include("./mission_3-1.php");

$sql="CREATE TABLE IF NOT EXISTS register"
	."("
	."id INT,"
	."name char(32),"
	."pass char(32)"
	.");";
$stmt=$pdo->query($sql);

$sql = 'SELECT * FROM register';
$results = $pdo -> query($sql);
$bool = 0;
$id = 0;
foreach ($results as $row){
	if($name == $row['name']){
		$bool = 1;
		echo "登録済みです。";
	}
	$id = $row['id'];
}

if($bool == 0){
	$sql = $pdo -> prepare("INSERT INTO register (id, name, pass) VALUES (:id, :name, :pass)");
	$sql -> bindParam(':id', $id, PDO::PARAM_INT);
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$id++;
	//$name = $name;
	//$pass = $pass; 
	$sql -> execute();
	//echo $name.$pass."登録しました。";
}

?>

<!-- <a href="./mission_4-1-32.html">入力フォーム</a><br> -->
<a href="./mission_4-1-32login.html">もどる</a><br>
</body>
</html>


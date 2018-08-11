<html>
<head>
<meta charset="utf-8">
<title>入力フォｰム 4-1-32</title>
</head>
<body>

<?php
$name = $_POST["name"];
$pass = $_POST["hpass"];
$hpass = $pass;

include("./mission_3-1.php");

$bool = 0;
$sql = 'SELECT * FROM register';
$results = $pdo -> query($sql);
foreach ($results as $row){
	if($name == $row['name'] && $pass == $row['pass']){
		$bool = 1;
		//echo "ログイン成功。";
		include("./mission_4-1-32_write.php");
		break;
	}
}
if($bool == 0){
	echo "ログイン失敗<br>";
	echo "<a href=\"./mission_4-1-32login.html\">もどる</a><br>";
}
?>

</body>
</html>


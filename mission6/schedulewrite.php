<html>
<head>
<meta charset="utf-8">
<title>スケジュール入力</title>
</head>
<body>

<?php

//引数を受け取る
if($_GET['bool'] != 1){
	$event = $_POST["event"];
	$id = $_POST["id"];
	$month = $_POST["month"];
	$day = $_POST["day"];
	$time1 = $_POST["time1"];
	$time2 = $_POST["time2"];
}else{
	$month = $_GET["month"];
	$day = $_GET["day"];
	$id = $_GET["id"];
}
echo "<h2>".$month."月".$day."日の予定</h2>";
?>

<form action="./schedulewrite.php" method="post">
<input type="text" name="event" placeholder="予定を入力">
<input type="text" name="time1" placeholder="時">
<input type="text" name="time2" placeholder="分">
<?php

echo "<input type=\"hidden\" name=\"id\" value=".$id.">\n";
echo "<input type=\"hidden\" name=\"month\" value=".$month.">\n";
echo "<input type=\"hidden\" name=\"day\" value=".$day.">\n";
?>
<input type="submit" value="送信">
</form>

<?php
//書き込み

//sql準備
include("./mission_3-1.php");

//idからmailアドレスを受け取る
$sql = "SELECT mail FROM toregister WHERE id=$id;";
$result = $pdo -> query($sql);
if($result != null){
	foreach ($result as $row){
		$mail = $row['mail'];
	}
}

//確認用
/*
echo "e=".$event;
echo "m=".$id;
echo "mo=".$month;
echo "d=".$day;
*/

//テーブルがなければ作る
$sql="CREATE TABLE IF NOT EXISTS schedule"
."("
."id INT,"
."month INT,"
."day INT,"
."mail TEXT,"
."event TEXT,"
."time1 INT,"
."time2 INT"
.");";
$stmt=$pdo->query($sql);

//id順にしてresultへいれて数を数える
$sql="SELECT * FROM schedule ORDER BY id;";
$result=$pdo->prepare($sql);
$result->execute();

//idの最後の値を受け取る
if($result != null){
	foreach ($result as $row){
		$count = $row['id'];
	}
}else{
	$count = 0;
}

//テーブルに値を入れる
if($event != null){
	$sql = $pdo -> prepare("INSERT INTO schedule (id, month, day, mail, event, time1, time2) VALUES (:id, :month, :day, :mail, :event, :time1, :time2)");
	$sql -> bindParam(':id', $count, PDO::PARAM_INT);
	$sql -> bindParam(':month', $month, PDO::PARAM_INT);
	$sql -> bindParam(':day', $day, PDO::PARAM_INT);
	$sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
	$sql -> bindParam(':event', $event, PDO::PARAM_STR);
	$sql -> bindParam(':time1', $time1, PDO::PARAM_INT);
	$sql -> bindParam(':time2', $time2, PDO::PARAM_INT);

	$count = $count+1;
	$month = $month;
	$day = $day;
	$mail = $mail;
	$event = $event;
	$time1 = $time1;
	$time2 = $time2;
	$sql -> execute();
}

?>

<?php
//削除
$del = $_POST['del'];

if($del != null){
	$sql = "DELETE FROM schedule WHERE id = \"$del\";" ;
	$result=$pdo->prepare($sql);
	$result->execute();
}

?>

<?php
//編集
$edit = $_POST['edit'];
$m = $_POST['m'];
$d = $_POST['d'];
$e = $_POST['e'];
$t1 = $_POST['t1'];
$t2 = $_POST['t2'];

//編集用のテキストボックス表示
if($edit != null && $m == null && $d == null && $e == null){

	//編集部分のデータ取得
	$sql = "SELECT * FROM schedule WHERE id=$edit;";
	$result = $pdo -> query($sql);
	foreach($result as $row){
		$mo = $row["month"];
		$da = $row["day"];
		$ev = $row["event"];
		$ti1 = $row["time1"];
		$ti2 = $row["time2"];
	}

	//ボックス表示
	echo "<form action=\"\" method=\"post\">";
	echo "<input type=\"number\" name=\"m\" placeholder=\"月\" value=\"$mo\">";
	echo "<input type=\"number\" name=\"d\" placeholder=\"日\" value=\"$da\">";
	echo "<input type=\"text\" name=\"e\" placeholder=\"予定\" value=\"$ev\">";
	echo "<input type=\"number\" name=\"t1\" placeholder=\"時\" value=\"$ti1\">";
	echo "<input type=\"number\" name=\"t2\" placeholder=\"分\" value=\"$ti2\">";
	
	echo "<input type=\"hidden\" name=\"id\" value=".$id.">\n";
	echo "<input type=\"hidden\" name=\"month\" value=".$month.">\n";
	echo "<input type=\"hidden\" name=\"day\" value=".$day.">\n";
	echo "<button type=\"submit\" name=\"edit\" value=\"$edit\">編集</button><br>\n";
	echo "</form>\n";
}

//DB更新
if($m != null && $d != null && $e != null ){
	$sql = "UPDATE schedule SET month=\"$m\", day=\"$d\", event=\"$e\", time1=\"$t1\", time2=\"$t2\" WHERE id=\"$edit\";";
	$result = $pdo->query($sql);
}

?>

<!-- html表示部分 -->
<?php
//echo "<h2>".$month."月".$day."日の予定</h2>";

$sql = "SELECT * FROM schedule ORDER BY time1, time2;";
$result = $pdo -> query($sql);

echo "<form action=\"./schedulewrite.php\" method=\"post\">\n";
?>

<table border="1">
	<tr>
		<th>予定</th>
		<th>時間</th>
		<th>削除</th>
		<th>編集</th>
	</tr>

<?php
echo "<tr>";
foreach ($result as $row){
	//月日とユーザの一致するものだけ表示する
	if($month == $row['month'] && $day == $row['day'] && $mail == $row['mail']){
		//echo $row['id'].'番,';
		//echo $row['month'].'月,';
		//echo $row['day'].'日,';
		//echo $row['mail'].',';
		echo "<td>".$row['event']."</td>";
		$zero = "";
		if($row['time2'] < 10){
			//桁あわせ用
			$zero = 0;
		}
		echo "<td>".$row['time1'].":".$zero.$row['time2']."</td>";
		echo "<td>\n<button type=\"submit\" name=\"del\" value=\"".$row['id']."\">削除</button></td>\n";
		echo "<td><button type=\"submit\" name=\"edit\" value=\"".$row['id']."\">編集</button></td><br>\n";
		echo "</tr><tr>";
	}
}
echo "</tr>\n</table>";
echo "<input type=\"hidden\" name=\"id\" value=".$id.">\n";
echo "<input type=\"hidden\" name=\"month\" value=".$month.">\n";
echo "<input type=\"hidden\" name=\"day\" value=".$day.">\n";
echo "</form>\n";

echo "<a href=\"./calendar.php?id=$id\">もどる</a>";

?>

</body>
</html>
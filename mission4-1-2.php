<?php require "header.php"; /*ヘッダーファイル読み込み*/?>

<form action="mission4-1.php"method="post">
<input type="text"name="name"value='名前'><br>
<input type="text"name="comment"value='コメント'><br>
<input type="text"name="pass">パスワードを入力してください<br>
<input type="submit"value="投稿">
</form>

<form action="mission4-1.php"method="post">
編集する番号を入力してください<br>
<input type="text"name="edit">編集対象番号<br>
<input type="text"name="editname"value='名前'><br>
<input type="text"name="editcomment"value='コメント'><br>
<input type="text"name="pass">パスワードを入力してください<br>
<input type="submit"value="投稿">
</form>


<form action="mission4-1.php"method="post">
<input type="text"name="num">削除対象番号<br>
<input type="text"name="pass">パスワードを入力してください<br>
<input type="submit"value="投稿">
</form>


<?php
/*プログラム本体*/
//タイムゾーン設定
date_default_timezone_set('Japan');
/*データベース接続*/
$dsn = 'mysql:dbname=データベース名;host=ホスト名'; 
$user = 'ユーザー名'; 
$password = 'パスワード'; 
$pdo = new PDO($dsn,$user,$password);

//テーブル作成
$sqlcr= "CREATE TABLE tbtb" 
." (" 
. "id INT AUTO_INCREMENT PRIMARY KEY," 
. "name char(32)," 
. "comment TEXT," 
. "date datetime,"
. "pass TEXT" 
.");"; 
$stmt = $pdo->query($sqlcr);
//テーブル作成完了
//編集・削除フォームからの入力値取得
 $number=$_REQUEST['num'];
 $editnumber=$_REQUEST['edit'];
 $name=$_REQUEST['editname'];
 $comment=$_REQUEST['editcomment'];
 $pass=$_REQUEST['pass'];
//削除編集フォームからの入力がなければ新規投稿をする

//削除機能の実装
if(!empty($number)){
	//データベースからテーブル読み込み
	$sqlse='SELECT * FROM tbtb';
	//クエリ実行
	$resultse=$pdo->query($sqlse);
 //パスワード比較
 foreach($resultse as $row){
 if($row['id'] == $number){
 if($row['pass']==$pass){
 $sql="delete from tbtb where id=$number";
 $result = $pdo->query($sql);
 }
 }/*else{
 echo　'パスワードが違います';
 }*/
}
}
//編集機能の実装
else if(!empty($editnumber)){

	//データベースからテーブル読み込み
	$sqlse='SELECT * FROM tbtb';
	//クエリ実行
	$resultse=$pdo->query($sqlse);
 //パスワード比較
 foreach($resultse as $row){
 if($row['id'] == $editnumber){
 if($row['pass']==$pass){
 $sql="update tbtb set name='$name',comment='$comment' where id=$editnumber";
 $result=$pdo->query($sql);
 }
 }/*else{
 echo　'パスワードが違います<br>';
}*/
}
}

else{
 //データ新規書き込み
 $sqlw = $pdo->prepare("INSERT INTO tbtb(id,name,comment,date,pass)VALUES(:id, :name, :comment, :date, :pass) ");
 $sqlw -> bindParam(':id', $id, PDO::PARAM_STR);
 $sqlw -> bindParam(':name', $name, PDO::PARAM_STR);
 $sqlw -> bindParam(':comment', $comment, PDO::PARAM_STR);
 $sqlw -> bindParam(':date', $date, PDO::PARAM_STR);
 $sqlw -> bindParam(':pass', $pass, PDO::PARAM_STR);
 //フォームからデータ受け取り
 $id=NULL;
 $name=$_REQUEST['name'];
 $comment=$_REQUEST['comment'];
 $date=date('y/m/d/ h:i:s');
 $pass=$_REQUEST['pass'];
 //クエリ実行
 $sqlw -> execute();
}




//データベースからテーブル読み込み
$sqlse='SELECT * FROM tbtb ORDER BY id ASC';
//クエリ実行
$resultse=$pdo->query($sqlse);
//データ表示
 foreach($resultse as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].',';
	echo $row['pass'].'<br>';

 }


?>

<?php require "footer.php"; /*フッターファイル読み込み*/?>
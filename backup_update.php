<?php
// $id    = $_GET['id'];

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//1. POSTデータ取得
$name   = $_POST['name'];
// $bust  = $_POST['bust'];
// $waist    = $_POST['waist'];
// $hip = $_POST['hip'];
// // $id = $_POST['id'];
// $id    = $_POST['id'];

$bust  = intval($_POST['bust']);
$waist = intval($_POST['waist']);
$hip   = intval($_POST['hip']);
$id    = intval($_POST['id']);
// var_dump($id);
//2. DB接続します
//*** function化する！  *****************

// require_once('funcs.php');
// $pdo = db_conn();

// try {
//     $db_name = '3size_db'; //データベース名
//     $db_id   = 'root'; //アカウント名
//     $db_pw   = ''; //パスワード：MAMPは'root'
//     $db_host = 'localhost'; //DBホスト
//     $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//     exit('DB Connection Error:' . $e->getMessage());
// }
try {
    $db_name = 'junbo3631_3size_db';    //データベース名
    $db_id   = 'junbo3631_3size_db';      //アカウント名
    $db_pw   = 'junko3631';      //パスワード：MAMPは'root'
    $db_host = 'mysql3104.db.sakura.ne.jp'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

// DB接続情報
// $host = 'mysql3104.db.sakura.ne.jp';
// $dbname = 'junbo3631_3size_db';
// $username = 'junbo3631_3size_db';
// $password = 'junko3631';


// データベース接続
// $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//３．データ登録SQL作成
$stmt = $pdo->prepare('UPDATE 
`3size_table` 
SET 
name = :name,
bust = :bust,
waist = :waist,
hip = :hip,
indate = NOW()
WHERE 
 id =:id;
 ');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':bust', $bust, PDO::PARAM_INT);
$stmt->bindValue(':waist', $waist, PDO::PARAM_INT); //PARAM_INTなので注意
$stmt->bindValue(':hip', $hip, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//実行

//４．データ登録処理後
// if ($status === false) {
//     //*** function化する！******\
//     $error = $stmt->errorInfo();
//     exit('SQLError:' . print_r($error, true));
// } else {
//     //*** function化する！*****************
//     header('Location: select.php');
//     exit();
// }
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLエラー:' . print_r($error, true));
} else {
    header('Location: select.php');
    exit();
}

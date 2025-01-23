<?php
session_start();  
require_once('funcs.php');
$pdo = db_conn();

// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

$name  = $_POST['name'];
$bust  = intval($_POST['bust']);
$waist = intval($_POST['waist']);
$hip   = intval($_POST['hip']);
$id    = intval($_POST['id']);

// SQL作成
$stmt = $pdo->prepare('UPDATE 
`3size_table` 
SET 
name = :name,
bust = :bust,
waist = :waist,
hip = :hip

WHERE 
id = :id;
');

$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':bust', $bust, PDO::PARAM_INT);
$stmt->bindValue(':waist', $waist, PDO::PARAM_INT);
$stmt->bindValue(':hip', $hip, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

// 処理後
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLエラー:' . print_r($error, true));
} else {
    header('Location: select.php');
    exit();
}

<?php
// session_start();

// //POST値
// $lid = $_POST['lid'];
// $lpw = $_POST['lpw'];

// require_once('funcs.php');
// loginCheck();
// $pdo = db_conn();

// $stmt = $pdo->prepare('SELECT * FROM 3size_user_table WHERE lid = :lid AND lpw=:lpw');
// $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
// $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* Hash化する場合はコメントする
// $status = $stmt->execute();

// //3. SQL実行時にエラーがある場合STOP
// if ($status === false) {
//     sql_error($stmt);
// }

// //4. 抽出データ数を取得
// $val = $stmt->fetch();

// //if(password_verify($lpw, $val['lpw'])){ //* PasswordがHash化の場合はこっちのIFを使う
// if ($val['id'] != '' && password_verify($lpw, $val['lpw'])) {
//     //Login成功時 該当レコードがあればSESSIONに値を代入

//     $_SESSION['chk_ssid'] = session_id();
//     // $_SESSION['kanri_flg'] = $val['kanri_flg'];
//     header('Location: select.php');
// } else {
//     //Login失敗時(Logout経由)
//     header('Location: login.php');
// }

// exit();

// ?php

//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値を受け取る
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

//1.  DB接続します
try {
require_once('funcs.php');
$pdo = db_conn();

//2. データ登録SQL作成
// gs_user_tableに、IDとWPがあるか確認する。
// $stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE lid = :lid AND lpw = :lpw');
$stmt = $pdo->prepare('SELECT * FROM 3size_user_table WHERE lid = :lid;');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
// $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP

if($status === false){
    sql_error($stmt);
}
//ここから下はtrueの場合のコマンド（ifを書く必要なし）

//4. 抽出データ数を取得
$val = $stmt->fetch(); //データを一行取ってくる

//if(password_verify($lpw, $val['lpw'])){ //* PasswordがHash化の場合はこっちのIFを使う
if( $val['id'] != '' && password_verify($lpw, $val['lpw']) ){
    //Login成功時 該当レコードがあればSESSIONに値を代入
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['kanri_flg'] = $val['kanri_flg']; //管理者なら1、それ以外は0が入る
        header('Location: select.php');
}else{
    //Login失敗時(Logout経由)
    header('Location: login.php');
}

exit();

} catch (PDOException $e) {
    // エラーメッセージを返す
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

//5. 該当レコードがあればSESSIONに値を代入
// //* if(password_verify($lpw, $val['lpw'])){
// if ($val['id'] != '') {

//     // サーバーとクライアントで共有しているSessionIDをchk_ssidに記録しておく。
//     $_SESSION['chk_ssid']  = session_id();

//     //権限判断したい場合は、kanri_flgをsessionに入れておく。
//     // $_SESSION['kanri_flg'] = $val['kanri_flg']; 
//     redirect('select.php');
// } else {
//     //Login失敗時(Logout経由)
//     redirect('login.php');
// }
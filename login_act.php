<?php
session_start();

$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

require_once('funcs.php');
$pdo = db_conn();


// SQL実行
$stmt = $pdo->prepare("SELECT * FROM `3size_user_table` WHERE lid = :lid AND lpw = :lpw");
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$stmt->execute();

// 結果確認
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
    // ユーザーが存在する場合
    // ユーザー名をセッションに保存
    $_SESSION['username'] = $user['name']; // ユーザー名のカラム名を調整してください

    header("Location: select.php");
    exit();
} else {
    echo "ログイン失敗";
}

// <?php

// session_start();

// $lid = $_POST['lid'];
// $lpw = $_POST['lpw'];

// require_once('funcs.php');
// $pdo = db_conn();

// // SQL実行
// $stmt = $pdo->prepare("SELECT * FROM `3size_user_table` WHERE lid = :lid AND lpw = :lpw");
// $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
// $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
// $stmt->execute();

// // 結果確認
// $user = $stmt->fetch(PDO::FETCH_ASSOC);
// if ($user) {
//     // ユーザーが存在する場合
//     header("Location: select.php");
//     exit();
// } else {
//     echo "ログイン失敗";
// }

// $val = $stmt->fetch();

// if( $val['id'] != '' && password_verify($lpw, $val['lpw']) ){
//     $_SESSION['chk_ssid'] = session_id();
//     $_SESSION['kanri_flg'] = $val['kanri_flg']; 
//         header('Location: select.php');
// }else{
//     header('Location: login.php');
// }

exit();
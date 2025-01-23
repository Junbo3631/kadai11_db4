<?php
//XSS対応（ echoする場所で使用！）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//DB接続関数：db_conn() 
//※関数を作成し、内容をreturnさせる。
//※ DBname等、今回の授業に合わせる。
// function db_conn()
// {
//     try {
//         $db_name = '3size_db'; //データベース名
//         $db_id   = 'root'; //アカウント名
//         $db_pw   = ''; //パスワード：MAMPは'root'
//         $db_host = 'localhost'; //DBホスト
//         $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
//         return $pdo;
//     } catch (PDOException $e) {
//         exit('DB Connection Error:' . $e->getMessage());
//     }
// }
function db_conn()
{
  try {
    $db_name = 'junbo3631_3size_db';    //データベース名
    $db_id   = 'junbo3631_3size_db';      //アカウント名
    $db_pw   = 'junko3631';      //パスワード：MAMPは'root'
    $db_host = 'mysql3104.db.sakura.ne.jp'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
    return $pdo;
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}
}

// 

//ログインチェック
// function loginCheck()
// {
//     if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] != session_id()) {
//         exit('LOGIN ERROR');
//     } else {
//         session_regenerate_id(true);
//         $_SESSION['chk_ssid'] = session_id();
//     }
// }

//SQLエラー
function sql_error($stmt)
{
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('SQLError:' . $error[2]);
}

//リダイレクト
function redirect($file_name)
{
    header('Location: ' . $file_name);
    exit();
}

function loginCheck()
{
    if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] != session_id()) {
        exit('LOGIN ERROR');
    }

    session_regenerate_id(true);
    $_SESSION['chk_ssid'] = session_id();
}
<?php


//SESSIONスタート
session_start();


require_once('funcs.php');
$pdo = db_conn();

// セッションからユーザー名を取得
$username = $_SESSION['username'];

//ログインチェック
// loginCheck();
//以下ログインユーザーのみ
// ログイン処理の時に代入した$_SESSION['chk_ssid']を持っているか？
// もしくはサーバーのSESSION IDと一緒か？
// if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] != session_id()) {
//     exit('LOGIN ERROR');
// }

// session_regenerate_id(true);
// $_SESSION['chk_ssid'] = session_id();

//以下ログインユーザーのみ処理が行われる。
// (以下略)
//【重要】
/**
 * DB接続のための関数をfuncs.phpに用意
 * require_onceでfuncs.phpを取得
 * 関数を使えるようにする。
 */



//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM `3size_table`;');
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //GETデータ送信リンク作成
        // <a>で囲う。
        $view .= '<p>';
        $view .= '<a href="detail.php?id=' . $result['id'] .  '">';
        $view .= $result['id']  . ' : ' . $result['name'] . ' : ' . $result['bust'] . ' : ' . $result['waist'] . ' : ' . $result['hip'] . ' : ' . $result['indate'];
        $view .= '</a>';
        $view .= '<a href="delete.php?id=' . $result['id'] .  '">';
        $view .= '[削除]';
        $view .= '</a>';

        $view .= '</p>';
    }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>３サイズ</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">データ登録</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->

    <p><?php echo $username; ?>さん、３サイズは変わりましたか？↑データ登録へ！</p>
    <div>
        <div class="container jumbotron">
            <a href="detail.php"></a>
            <?= $view ?>
        </div>
    </div>
    <!-- Main[End] -->

</body>

</html>
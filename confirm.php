<?php

require_once('funcs.php');
$pdo = db_conn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $bust = isset($_POST['bust']) ? (int)$_POST['bust'] : null;
    $waist = isset($_POST['waist']) ? (int)$_POST['waist'] : null;
    $hip = isset($_POST['hip']) ? (int)$_POST['hip'] : null;

    // 入力チェック
    if ($name === null || $bust === null || $waist === null || $hip === null) {
        echo "全ての項目を入力してください。";
        exit;
    }

    // バストの妥当性チェック
    if ($bust >= $waist * 1.3) {
        echo "ダウト！本当にそのサイズですか？";
        exit;
    }

   
       
    // データベース接続
 try {
        $pdo = new PDO('mysql:dbname=3size_db;charset=utf8;host=localhost', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // データ挿入
        $stmt = $pdo->prepare("INSERT INTO 3size_table (name, bust, waist, hip) VALUES (:name, :bust, :waist, :hip)");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':bust', $bust, PDO::PARAM_INT);
        $stmt->bindValue(':waist', $waist, PDO::PARAM_INT);
        $stmt->bindValue(':hip', $hip, PDO::PARAM_INT);

        $stmt->execute();

        // 完了メッセージ
        echo "アンケートの回答をありがとうございました！<br>";
        echo "<a href=\"index.html\">戻る</a>";
    } catch (PDOException $e) {
        echo "データベースエラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        exit;
    }
} else {
    echo "無効なリクエストです。";
}
?>
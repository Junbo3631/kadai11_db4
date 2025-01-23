
<?php
// try {
//     // データベース接続
    // $pdo = new PDO('mysql:dbname=3size_db;charset=utf8;host=localhost', 'root', '');
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// DB接続情報
$host = 'mysql3104.db.sakura.ne.jp';
$dbname = 'junbo3631_3size_db';
$username = 'junbo3631_3size_db';
$password = 'junko3631';

// $host = 'localhost';
// $dbname = '3size_db';
// $username = 'root';
// $password = '';

    try {
        // データベース接続
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

// 検索クエリを取得
// $search = isset($_GET['search']) ? trim($_GET['search']) : '';

// SQLクエリの準備
$stmt = $pdo->prepare('SELECT * FROM 3size_table;');
$status = $stmt->execute();

    // if ($search !== '') {
    //     $stmt = $pdo->prepare("SELECT name, bust, waist, hip, indate FROM 3size_table WHERE name LIKE :search");
    //     $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    //     $stmt->execute();
    // } else {
    //     $stmt = $pdo->query("SELECT name, bust, waist, hip, indate FROM 3size_table");
    // }

    // 結果を取得
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //GETデータ送信リンク作成
        // <a>で囲う。
        $view .= '<p>';
        $view .= '<a href="detail.php?id=' .$result['id'].  '">';
        $view .= $result['id']  . ' : ' . $result['name'] . ' : ' . $result['bust'] . ' : ' . $result['waist'] . ' : ' . $result['hip']. ' : ' . $result['indate'];
        $view .= '</a>';
        $view .= '<a href="delete.php?id=' . $result['id'] .  '">';
        $view .= '[削除]';
        $view .= '</a>';

        $view .= '</p>';
    }
}
    // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 結果をJSONエンコードしてindex.htmlに渡す
//     header('Location: search.php?data=' . urlencode(json_encode($results)));
// } catch (PDOException $e) {
//     // エラー時の処理
//     header('Location: search.php?data=' . urlencode(json_encode([])));
// }
?>
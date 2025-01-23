<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スリーサイズデータ検索</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        form {
            margin: 20px 0;
        }

        input[type="text"],
        button {
            padding: 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>スリーサイズデータ検索</h1>

        <!-- 検索フォーム -->
        <form action="index.php" method="GET">
            <input type="text" name="search" placeholder="名前で検索" value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8') ?>" />
            <button type="submit">検索</button>
        </form>

        <!-- データ一覧 -->
        <div>
            <table>
                <thead>
                    <tr>
                        <th>名前</th>
                        <th>バスト</th>
                        <th>ウエスト</th>
                        <th>ヒップ</th>
                                           </tr>
                </thead>
                <tbody>
                    <?php

                    session_start();
                    require_once('funcs.php');
                    $pdo = db_conn();

                    try {
                        // データベース接続
                        $pdo = new PDO('mysql:dbname=3size_db;charset=utf8;host=localhost', 'root', '');
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // 検索クエリを処理
                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                        // SQL クエリの準備
                        if ($search !== '') {
                            // 名前で検索
                            $stmt = $pdo->prepare("SELECT name, bust, waist, hip FROM 3size_table WHERE name LIKE :search");
                            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                            $stmt->execute();
                        } else {
                            // 全データ取得
                            $stmt = $pdo->query("SELECT name, bust, waist, hip FROM 3size_table");
                        }

                        // データを表示
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if ($results) {
                            foreach ($results as $row) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>";
                                echo "<td>" . htmlspecialchars($row['bust'], ENT_QUOTES, 'UTF-8') . " cm</td>";
                                echo "<td>" . htmlspecialchars($row['waist'], ENT_QUOTES, 'UTF-8') . " cm</td>";
                                echo "<td>" . htmlspecialchars($row['hip'], ENT_QUOTES, 'UTF-8') . " cm</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>データが見つかりません。</td></tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='4'>データベースエラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
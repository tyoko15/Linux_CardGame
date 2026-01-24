<?php
// データベースにログインする
$host = 'mysql';
$username = 'cardGame';
$password = 'card';
$database = 'card_game';
$table_select_name = ['users', 'user_cards', 'user_decks', 'cards'];
$tablename;

    session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ガチャ結果</title>
    </head>
     <style>
        /* CSSで初期状態では全てのテーブルを非表示にします */
        .table-display {
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 10px;
            display: none; /* 初期状態では非表示 */
        }
        .active {
            display: block; /* activeクラスが付いたら表示 */
        }
        /* ここに後述のCSSコードを記述します */
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
<body>
    <h1>ガチャ結果</h1>
    <?php
    if (isset($_SESSION['data'][0])) 
    {
        // PDOでMySQLに接続
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // User取得
        $users_name = $_SESSION['users_name'];
        $users_id = $_SESSION['users_id'];
        $count = $_GET['count'];
        $count = max(1, min(11, intval($count ?? 11)));
        $flag = $_SESSION['gacha'];
        // id だけ
        $results = $pdo->prepare("SELECT * FROM cards ORDER BY RAND() LIMIT $count");
        $results->execute();
        $gacha_results = $results->fetchAll(PDO::FETCH_ASSOC);
        $data = $gacha_results;
        if (count($data) > 0)
        {
            echo "<table>";
            echo "<thead><tr>";
            // ヘッダー表示
            echo "<th>カード名</th>";
            echo "<th>種類</th>";
            echo "<th>レベル</th>";
            echo "</tr></thead>";
            echo "<tbody>";
            foreach($data as $row)
            {
                echo "<tr>";
                foreach($row as $key => $value)
                {
                    if ($key != 'id')
                    {
                        echo "<td>" . htmlspecialchars($value) . "</td>"; 
                    }
                }
                echo "</tr>"; 
            }
            echo "</tbody>";
	        echo "</table>";
        }
        $data = $gacha_results;
        if (count($data) > 0)
        {
            foreach($data as $row)
            {
                foreach($row as $key => $value)
                {
                    if ($key == 'id')
                    {
                        $stmt_max_id = $pdo->prepare("SELECT MAX(id) AS last_id FROM user_cards");
                        $stmt_max_id->execute();
                        $last_id = $stmt_max_id->fetchColumn(0);
                        $last_id += 1; 
                        $stmt_results = $pdo->prepare("INSERT INTO user_cards (id, user_id, card_id) VALUES (:id, :user_id, :card_id)");
                        $stmt_results->bindParam(':id', $last_id);
                        $stmt_results->bindParam(':user_id', $users_id);
                        $stmt_results->bindParam(':card_id', $value);
                        $stmt_results->execute();
                    }
                }
            }
        }
    }
        
    ?>
</body>
</html>

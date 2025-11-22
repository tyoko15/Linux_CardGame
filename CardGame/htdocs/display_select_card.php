<?php
// データベースにログインする
$host = 'mysql';
$username = 'cardGame';
$password = 'card';
$database = 'card_game';
$table_select_name = ['users', 'user_cards', 'user_decks', 'cards'];
$tablename;

    session_start();

    if (isset($_GET['name'])) {
    $_SESSION['select_user'] = $_GET['name'];
    echo "選ばれたユーザー名は：" . htmlspecialchars($_SESSION['select_user']);
    } else {
        echo "ユーザー名が指定されていません。";
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>カード合成</title>
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
    <h1>合成するカードを選んでね！</h1>
    <?php
        echo "<p>a</p>";
        echo $_SESSION['pdo'];

        if (isset($_SESSION['data'][1])) 
        {
                // PDOでMySQLに接続
                $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // データの取得
                $sql = "SELECT id FROM users WHERE name = 'Shimada'";
                $stmts = $pdo->query($sql);
                $results2 = $stmts->fetchAll(PDO::FETCH_ASSOC);
            if ($results2) 
            {
                $data = $results2;
        
                // ... (テーブル表示ロジックはそのまま) ...
                if (count($data) > 0) 
                {
                    echo "<table>";
                    echo "<thead><tr>";
                    // ヘッダー表示
                    foreach (array_keys($data[0]) as $column) 
                    {
                        echo "<th>" . htmlspecialchars($column) . "</th>";
                    }
                    echo "</tr></thead>";
                    echo "<tbody>";
                    // データ行表示
                    foreach ($data as $row) 
                    {
                        echo "<tr>";
                        foreach ($row as $key => $value) 
                        {
                            if ($key == 'name')
                            {
                                $name = htmlspecialchars($value);                        
                                echo "<th><a href='display_select_card.php?name=" . urlencode($name) . "'>$name</a></th>";
                            }
                            else
                            {
                                echo "<th>" . htmlspecialchars($value) . "</th>";
                            }
                        }
                            echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } 
                else 
                {
                    echo "<p>no data1</p>";
                }
                echo '<a href="get_card.php">更新</a></p>';
            }
        }
    ?>
</body>
</html>

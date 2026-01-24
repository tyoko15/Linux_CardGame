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
    <title>合成素材選択</title>
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
        if (isset($_SESSION['data'][1])) 
        {
            // PDOでMySQLに接続
            $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // データの取得
            $name = $_GET['name'];
            $stmt_user = $pdo->prepare("SELECT id FROM users WHERE name = :name");
            $stmt_user->bindParam(':name', $name);
            $stmt_user->execute();
            $id = $stmt_user->fetchColumn(0);

            $_SESSION['users_id'] = $id;
            $_SESSION['users_name'] = $name;
            $users_name = $_SESSION['users_name'];
            $users_id = $_SESSION['users_id'];

            $twice = false;
            if (isset($_GET['select_card_id_1'])) 
            {
                $twice = true;
                $_SESSION['select_card_id_1'] = $_GET['select_card_id_1'];
                $select_card_id_1 = $_GET['select_card_id_1'];
            }
            else 
            {
                $twice = false;
            }

            if ($twice)
            {
                // user_cardsテーブルのcard_idを取得
                $stmt_user_cards_card_id = $pdo->prepare("SELECT card_id FROM user_cards where user_id = :user_id AND id = :id");
                $stmt_user_cards_card_id->bindParam(':user_id', $users_id);
                $stmt_user_cards_card_id->bindParam(':id', $select_card_id_1);
                $stmt_user_cards_card_id->execute();
                $card_id = $stmt_user_cards_card_id->fetchColumn(0);
                // cardsテーブルのnameを取得
                $stmt_name = $pdo->prepare("SELECT name FROM cards WHERE id = :id");
                $stmt_name->bindParam(':id', $card_id);
                $stmt_name->execute();
                $cards_name = $stmt_name->fetchColumn(0);

                $card_id = $_GET['select_card_id_1'];
                echo "$card_id</p>";

                // 選択中のカードをリストから除外する
                $stmt_user_cards = $pdo->prepare("SELECT card_id FROM user_cards where card_id != :card_id AND user_id = :user_id");
                $stmt_user_cards->bindParam(':card_id', $select_card_id_1);
                $stmt_user_cards->bindParam(':user_id', $users_id);
                $stmt_user_cards->execute();
                $result = $stmt_user_cards->fetchAll(PDO::FETCH_ASSOC);
                $data = $result;
            }
            else 
            {
                $stmt_user_cards = $pdo->prepare("SELECT card_id FROM user_cards WHERE user_id = :user_id");
                $stmt_user_cards->bindParam(':user_id', $users_id);
                $stmt_user_cards->execute();
                $result = $stmt_user_cards->fetchAll(PDO::FETCH_ASSOC);
                $data = $result;
            }
            if ($result) 
            {
                if (isset($users_name)) {
                echo "ユーザー名：" . htmlspecialchars($users_name);
                } else {
                    echo "ユーザー名が指定されていません。";
                }                
                // ... (テーブル表示ロジックはそのまま) ...
                if (count($data) > 0) 
                {
                    echo "<table>";
                    echo "<thead><tr>";
                    // ヘッダー表示
                    echo "<th>カード名</th>";
                    echo "<th>合成</th>";
                    echo "</tr></thead>";
                    echo "<tbody>";
                    // データ行表示
                    foreach ($data as $row) 
                    {
                    echo "<tr>";
                    foreach ($row as $key => $value) 
                    {
                        if ($key == "card_id")
                        {
                            $stmt_cards_name = $pdo->prepare("SELECT name FROM cards WHERE id = :id");
                            $stmt_cards_name->bindParam(':id', $value);
                            $stmt_cards_name->execute();
                            $cards_name = $stmt_cards_name->fetchColumn(0);
                            echo "<td>" . htmlspecialchars($cards_name) . "</td>";
                        }
                        // 合成のアンカータグ
                        if (($key == "card_id"))
                        {
                            $stmt_user_cards_id = $pdo->prepare("SELECT id FROM user_cards WHERE user_id = :user_id AND card_id = :card_id");
                            $stmt_user_cards_id->bindParam(':user_id', $users_id);
                            $stmt_user_cards_id->bindParam(':card_id', $value);
                            $stmt_user_cards_id->execute();
                            $select_user_cards_id = $stmt_user_cards_id->fetchColumn(0);
                            if (!$twice)
                            {
                                echo "<td>";
                                echo "<a href='display_select_card.php?name=". urlencode($users_name) ."&select_card_id_1=" . urlencode($value) ."'>選択</a></p>";
                                echo "</td>";
                            }
                            else 
                            {
                                echo "<td>";
                                echo "<a href='display_synthesis.php?name=". urlencode($users_name) ."&select_card_id_1=" . urlencode($select_card_id_1) ."&select_card_id_2=". urlencode($value) ."'>選択</a></p>";
                                echo "</td>";
                            }                    
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
                if ($twice) 
                {
                    echo "<a href='display_select_card.php?name=". urlencode($users_name) ."'>選びなおす</a></p>";    
                }
                echo '<a href="get_card.php">ユーザー選択へ</a></p>';
            }
            else 
            {
                echo "no</p>";
            }
        }
    ?>
</body>
</html>

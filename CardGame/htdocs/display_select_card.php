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
        echo $_SESSION['pdo'];

        if (isset($_SESSION['data'][1])) 
        {
            // PDOでMySQLに接続
            $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // データの取得
            $selected_user = $_SESSION['select_user'];
            $stmt_user = $pdo->prepare("SELECT * FROM users WHERE name = :name");
            $stmt_user->bindParam(':name', $selected_user);
            $stmt_user->execute();
            $id = $stmt_user->fetchColumn(0);
            $stmt_user_cards = $pdo->prepare("SELECT id,user_id,card_id FROM user_cards WHERE user_id = :user_id");
            $stmt_user_cards->bindParam(':user_id', $id);
            $stmt_user_cards->execute();
            $result = $stmt_user_cards->fetchAll(PDO::FETCH_ASSOC);
            if ($result) 
            {
                $data = $result;
                // ... (テーブル表示ロジックはそのまま) ...
                if (count($data) > 0) 
                {
                    echo "<table>";
                    echo "<thead><tr>";
                    // ヘッダー表示
                    foreach (array_keys($data[0]) as $column) 
                    {
                        if ($column != 'user_id') echo "<th>" . htmlspecialchars($column) . "</th>";
                    }
                    echo "<th>合成</th>";
                    echo "</tr></thead>";
                    echo "<tbody>";
                    // データ行表示
                    foreach ($data as $row) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if (isset($_GET['select_card_id_1'])) 
                        {
                            $select_card = $_GET['select_card_id_1'];
                        }
                        if (($key == "id" || $key == "card_id" )&& $value == $select_card)
                        {

                        }
                        else if ($key == "card_id")
                        {
                            $stmt_name = $pdo->prepare("SELECT * FROM cards WHERE id = :id");
                            $stmt_name->bindParam(':id', $value);
                            $stmt_name->execute();
                            $name = $stmt_name->fetchColumn(1);
                            echo "<td>" . htmlspecialchars($name) . "</td>";
                        }
                        else if ($key != "user_id") echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    // 合成のアンカータグ
                    if (($key == "card_id" )&& $value != $select_card)
                    {
                        echo "<td>";
                        $card_id = htmlspecialchars($value);                        
                        if (empty($_GET['select_card_id_1'])) echo "<a href='display_select_card.php?name=". urlencode($_SESSION['select_user']) ."&select_card_id_1=" . urlencode($card_id) . "'>選択</a>";
                        else 
                        {                        
                            echo "<a href='display_synthesis.php?name=". urlencode($_SESSION['select_user']) ."&select_card_id_1=" . urlencode($select_card) . "&select_card_id_2=" . urlencode($card_id) . "'>選択</a>";                    
                        }
                        echo "</td>";
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
                if (isset($_GET['select_card_id_1'])) 
                {
                    echo '<a href="display_select_card.php">選びなおす</a></p>';
                }
                echo '<a href="get_card.php">ユーザー選択へ</a></p>';
            }
        }
    ?>
</body>
</html>

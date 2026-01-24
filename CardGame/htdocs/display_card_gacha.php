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
    <title>ガチャメニュー選択</title>
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
    <h1>ガチャメニュー</h1>
    <?php
    if (isset($_SESSION['data'][0])) 
        {
            // PDOでMySQLに接続
            $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $_SESSION['users_name'] = $_GET['name'];
            $name = $_SESSION['users_name'];
            $stmt_user = $pdo->prepare("SELECT id FROM users WHERE name = :name");
            $stmt_user->bindParam(':name', $name);
            $stmt_user->execute();
            $id = $stmt_user->fetchColumn(0);
            $_SESSION['users_id'] = $id;

            $users_name = $_SESSION['users_name'];
            $users_id = $_SESSION['users_id'];
            echo "$users_name</p>";
            echo "$users_id</p>";
            $_SESSION['gacha'] = false;
            echo '<a href="display_gacha_results.php?count=1">1連ガチャを回す。</a></p>';
            echo '<a href="display_gacha_results.php?count=11">10連ガチャを回す。</a></p>';
        }
    ?>
</body>
</html>

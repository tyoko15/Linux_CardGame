<?php
// データベースにログインする
$host = 'mysql';
$username = 'cardGame';
$password = 'card';
$database = 'card_game';
$table_select_name = ['users', 'user_cards', 'cards'];
$tablename;

try{
    // PDOでMySQLに接続
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 取得したデータをセッションに保存
    session_start();
    // データの取得
    $_SESSION['data'] = [];
    $stmt = [];
    foreach ($table_select_name as $i => $name)
    {
        $sql = "SELECT * FROM " . $name;
        $stmts[$i] = $pdo->query($sql);
        $results = $stmts[$i]->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['data'][$i] = $results;
    }
    $_SESSION['table_name'] = $table_select_name;

    // リダイレクト
    header("Location: display_select_user.php");
    exit();
} catch (PDOException $e) {
    // エラー処理
    echo "データベースエラー: " . $e->getMessage();
}

// 合成するカードを選択する
?>
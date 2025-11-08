<?php
// データベースにログインする
$host = 'mysql';
$username = 'root';
$password = 'password';
$database = 'card_game';
$table_select_name = ['users', 'cards'];
$tablename;

try{
    // PDOでMySQLに接続
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 取得したデータをセッションに保存
    session_start();

    // データの取得
    $stmt = $pdo->query("SELECT * FROM $tablename");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['data'] = $results;
    $_SESSION['table_name'] = $tablename;

    // リダイレクト
    header("Location: display_select_card.php");
    exit();
} catch (PDOException $e) {
    // エラー処理
    echo "データベースエラー: " . $e->getMessage();
}

// 合成するカードを選択する
?>
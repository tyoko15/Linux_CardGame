<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>合成完成</title>
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
    <h1>合成</h1>
    <?php
        echo '<a href="get_card.php">ユーザー選択へ</a></p>';
        echo '<a href="get_card.php">素材選択へ</a></p>';
    ?>
</body>
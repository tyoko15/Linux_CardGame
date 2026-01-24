<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー選択</title>
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
    <h2>ユーザーを選んでね！</h2>
    <?php
        if (isset($_SESSION['data'][0])) {
            $data = $_SESSION['data'][0];
            
            // ... (テーブル表示ロジックはそのまま) ...
            if (count($data) > 0) {
                echo "<table>";
                echo "<thead><tr>";
                // ヘッダー表示
                foreach (array_keys($data[0]) as $column) {
                    echo "<th>" . htmlspecialchars($column) . "</th>";
                }
                echo "</tr></thead>";
                echo "<tbody>";
                // データ行表示
                foreach ($data as $row) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if ($key == 'name')
                        {
                            $name = htmlspecialchars($value);                        
                            echo "<th><a href='display_select_menu.php?name=$name'>$name</a></th>";
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
            } else {
                echo "<p>no data1</p>";
            }
            
            // **注意:** データが表示されるたびにセッションから削除するのは非推奨です。
            // 必要に応じて削除してください。
            // unset($_SESSION['data'][$i]); 
            
        } else {
            echo "<p>no data2 (インデックス: $i にデータがありません)</p>";
        }
        echo '<a href="get_card.php">更新</a></p>';
        echo '<a href="Initialization.php">データベース初期化</a></p>';
    ?>
</body>
</html>
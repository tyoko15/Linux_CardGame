<?php
    session_start();
    $i = 2;
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>display_data</title>
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
    <h1><?php 
        // 存在チェックを追加し、安全に表示
        if (isset($_SESSION['table_name'][$i])) {
            echo htmlspecialchars($_SESSION['table_name'][$i]);
        } else {
            echo "不明なテーブル";
        }
    ?>_list</h1>
    
    <?php
        if (isset($_SESSION['data'][$i])) {
            $data = $_SESSION['data'][$i];
            
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
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>no data1</p>";
            }
        } else {
            echo "<p>no data2 (インデックス: $i にデータがありません)</p>";
        }
        echo '<a href="get_table.php">更新</a></p>';
    ?>
</body>
</html>
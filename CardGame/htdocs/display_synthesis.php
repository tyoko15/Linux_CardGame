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
        // PDOでMySQLに接続
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $selected_user = $_SESSION['select_user'];
        $selected_card_id_1 = $_SESSION['select_card_id_1'];
        $selected_card_id_2 = $_SESSION['select_card_id_2'];

        $stmt_user = $pdo->prepare("SELECT * FROM users WHERE name = :name");
        $stmt_user->bindParam(':name', $selected_user);
        $stmt_user->execute();
        $id = $stmt_user->fetchColumn(0);

        $stmt_user_cards_cardid = $pdo->prepare("SELECT card_id FROM user_cards WHERE user_id = :user_id AND id = :id");
        $stmt_user_cards_cardid->bindParam(':user_id', $id);
        $stmt_user_cards_cardid->bindParam(':id', $selected_card_id_1);
        $stmt_user_cards_cardid->execute();
        $selected_1_cards_id = $stmt_user_cards_cardid->fetchColumn(0);
        $stmt_name = $pdo->prepare("SELECT * FROM cards WHERE id = :id");
        $stmt_name->bindParam(':id', $selected_1_cards_id);
        $stmt_name->execute();
        $name1 = $stmt_name->fetchColumn(1);

        $stmt_user_cards_cardid = $pdo->prepare("SELECT card_id FROM user_cards WHERE user_id = :user_id AND id = :id");
        $stmt_user_cards_cardid->bindParam(':user_id', $id);
        $stmt_user_cards_cardid->bindParam(':id', $selected_card_id_2);
        $stmt_user_cards_cardid->execute();
        $selected_2_cards_id = $stmt_user_cards_cardid->fetchColumn(0);
        $stmt_name = $pdo->prepare("SELECT * FROM cards WHERE id = :id");
        $stmt_name->bindParam(':id', $selected_2_cards_id);
        $stmt_name->execute();
        $name2 = $stmt_name->fetchColumn(1);

        echo "<p>ユーザー名 : $selected_user</p>";
        echo "<p>選択させたカード名 : $name1</p>";
        echo "<p>選択させたカード名 : $name2</p>";
        // 今持っている情報
        /*
            $id = 選択させたuserテーブルのid
            $selected_user = 選択させたusersテーブルのname
            $selected_card_id_1 = 選択させた1つ目のuser_cardsテーブルのid
            $selected_card_id_2 = 選択させた2つ目のuser_cardsテーブルのid
            $selected_1_cards_id = 選択させた1つ目のcardsテーブルのid
            $selected_2_cards_id = 選択させた2つ目のcardsテーブルのid
            $name1 = 選択させた1つ目のcardsテーブルのname
            $name2 = 選択させた2つ目のcardsテーブルのname

            現在の目標 : これを使って合成の処理を実装する。
            手順
            1. 選択させたcardのkindを比較して分岐する
            分岐内容
            比較内容は、kindとlevel
            levelが同じでkindが異なる場合、levelは、変更させないで残ったkindのcardを合成結果にする。
            levelが同じでkindが同じ場合、一つlevelを上げて、kindは同じになる。
            levelが異なってkindが異なる場合、高い方のlevelを引き継ぎ、残ったkindのcardを合成結果にする。
            levelが異なってkindが同じ場合、一つlevelを上げて、kindは同じになる。
        */
        // 追加で必要な情報
        /*   
            選択させた1つ目のcardsテーブルのkind_id
            選択させた2つ目のcardsテーブルのkind_id
            選択させた1つ目のcardsテーブルのlevel
            選択させた2つ目のcardsテーブルのlevel
        */
        // cardsテーブルのkindとlevelの取得
        // 1つ目のkind
        $stmt_selected_card_1_kind_id = $pdo->prepare("SELECT kind_id FROM cards WHERE id = :id");
        $stmt_selected_card_1_kind_id->bindParam(':id', $selected_1_cards_id);
        $stmt_selected_card_1_kind_id->execute();
        $selected_card_1_kind_id = $stmt_selected_card_1_kind_id->fetchColumn(0);
        // 1つ目のlevel
        $stmt_selected_card_1_kind_id = $pdo->prepare("SELECT level FROM cards WHERE id = :id");
        $stmt_selected_card_1_kind_id->bindParam(':id', $selected_1_cards_id);
        $stmt_selected_card_1_kind_id->execute();
        $selected_card_1_level = $stmt_selected_card_1_kind_id->fetchColumn(0);
        // 2つ目のkind
        $stmt_selected_card_2_kind_id = $pdo->prepare("SELECT kind_id FROM cards WHERE id = :id");
        $stmt_selected_card_2_kind_id->bindParam(':id', $selected_2_cards_id);
        $stmt_selected_card_2_kind_id->execute();
        $selected_card_2_kind_id = $stmt_selected_card_2_kind_id->fetchColumn(0);
        // 2つ目のlevel
        $stmt_selected_card_2_kind_id = $pdo->prepare("SELECT level FROM cards WHERE id = :id");
        $stmt_selected_card_2_kind_id->bindParam(':id', $selected_2_cards_id);
        $stmt_selected_card_2_kind_id->execute();
        $selected_card_2_level = $stmt_selected_card_2_kind_id->fetchColumn(0);
        
        echo "一つ目の種類$selected_card_1_kind_id, レベル$selected_card_1_level</p>";
        echo "二つ目の種類$selected_card_2_kind_id, レベル$selected_card_2_level</p>";
        /* 比較 */
        // level比較
        if ($selected_card_1_level == $selected_card_2_level)           // 同じ場合
        {
            $synthesisCard_level = $selected_card_1_level+ 1;
            if ($selected_card_1_kind_id == $selected_card_2_kind_id)           // 種類が同じ場合
            {
                $synthesisCard_kind = $selected_card_1_kind_id;
            }
            else if ($selected_card_1_kind_id != $selected_card_2_kind_id)      // 種類が異なる場合
            {
                if (($selected_card_1_kind_id == 1 || $selected_card_2_kind_id == 1) && ($selected_card_1_kind_id == 2 || $selected_card_2_kind_id == 2)) $synthesisCard_kind = 3;
                else if (($selected_card_1_kind_id == 1 || $selected_card_2_kind_id == 1) && ($selected_card_1_kind_id == 3 || $selected_card_2_kind_id == 3)) $synthesisCard_kind = 2;
                else if (($selected_card_1_kind_id == 2 || $selected_card_2_kind_id == 2) && ($selected_card_1_kind_id == 3 || $selected_card_2_kind_id == 3)) $synthesisCard_kind = 1;
            }
        }
        else if ($selected_card_1_level != $selected_card_2_level)      // 異なる場合
        {
            $synthesisCard_level = ($selected_card_1_level > $selected_card_2_level) ? $selected_card_1_level : $selected_card_2_level;
            if ($selected_card_1_kind_id == $selected_card_2_kind_id)           // 種類が同じ場合
            {
                $synthesisCard_kind = $selected_card_1_kind_id;
            }
            else if ($selected_card_1_kind_id != $selected_card_2_kind_id)      // 種類が異なる場合
            {
                if (($selected_card_1_kind_id == 1 || $selected_card_2_kind_id == 1) && ($selected_card_1_kind_id == 2 || $selected_card_2_kind_id == 2)) $synthesisCard_kind = 3;
                else if (($selected_card_1_kind_id == 1 || $selected_card_2_kind_id == 1) && ($selected_card_1_kind_id == 3 || $selected_card_2_kind_id == 3)) $synthesisCard_kind = 2;
                else if (($selected_card_1_kind_id == 2 || $selected_card_2_kind_id == 2) && ($selected_card_1_kind_id == 3 || $selected_card_2_kind_id == 3)) $synthesisCard_kind = 1;
            }
        }
        // cardsテーブルのidを取得
        $stmt_synthesisCard_id = $pdo->prepare("SELECT id FROM cards WHERE kind_id = :kind_id AND level = :level");
        $stmt_synthesisCard_id->bindParam(':kind_id', $synthesisCard_kind);
        $stmt_synthesisCard_id->bindParam(':level', $synthesisCard_level);
        $stmt_synthesisCard_id->execute();
        $synthesisCard_id = $stmt_synthesisCard_id->fetchColumn(0);
        // cardsテーブルのnameを取得
        $stmt_synthesisCard_id = $pdo->prepare("SELECT name FROM cards WHERE kind_id = :kind_id AND level = :level");
        $stmt_synthesisCard_id->bindParam(':kind_id', $synthesisCard_kind);
        $stmt_synthesisCard_id->bindParam(':level', $synthesisCard_level);
        $stmt_synthesisCard_id->execute();
        $synthesisCard_name = $stmt_synthesisCard_id->fetchColumn(0);
        echo "合成結果</p>";
        echo "ID: $synthesisCard_id</p>";
        echo "Name: $synthesisCard_name</p>";
        echo "種類 : $synthesisCard_kind</p>";
        echo "レベル : $synthesisCard_level</p>";

        echo '<a href="display_select_user.php">ユーザー選択へ</a></p>';
        echo "<a href='display_select_card.php?name=" . urlencode($selected_user) . "'>素材選択へ</a>";
    ?>
</body>
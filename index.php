<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Social meet UP</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        First name: <input type="text" name="first_name"><br>
        Last name: <input type="text" name="last_name"><br>
        Sex: <input type="radio" name="sex" value="male"> Male
        <input type="radio" name="sex" value="female"> Female <br>
        In relationship: <input type="checkbox" name="is_in_relationship" value="yes"><br>
        <input type="submit" value="submit"><br>
    </form>
<?php

    // Соединяемся, выбираем базу данных
    $link = mysql_connect('localhost', 'root', '1fear1') or die('Не удалось соединиться: ' . mysql_error());
    echo 'Соединение успешно установлено';
    mysql_select_db('social_db') or die('Не удалось выбрать базу данных');

    // Выполняем SQL-запрос
    $query = 'SELECT first_name, last_name, sex, is_in_relationship FROM users WHERE id = '.(isset($_GET['id']) ? (int)$_GET['id'] : 10 ).' ORDER BY id DESC';
    $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

// Выводим результаты в html
    echo "<table border='1'>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Sex</th>
                <th>In relationship</th>
            </tr>";
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        echo "\t<tr>\n";
        foreach ($line as $key=>$col_value) {
            echo "\t\t<td>" . $key ." : " . $col_value . "</td>\n";
        }
        echo "\t</tr>\n";
    }
    echo "</table>\n";

// !empty($_POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name =  mysql_real_escape_string(htmlspecialchars($_POST['first_name']));
    $last_name = $_POST['last_name'];
    $sex = $_POST['sex'];



    // $relationship_db = !empty($_POST['is_in_relationship']) ? 1 : 0;
    // !!$_POST['is_in_relationship'];

    $is_in_relationship = $_POST['is_in_relationship'];

    $relationship_db = 0;
    if ($is_in_relationship == 'yes')
        $relationship_db = 1;


    var_dump($is_in_relationship);
    var_dump($relationship_db);

    $insert_query = "INSERT INTO users (first_name, last_name, sex, is_in_relationship) VALUES ('$first_name', '$last_name', '$sex', '$relationship_db')";
    $insert_result = mysql_query($insert_query) or die(' INSERT Запрос не удался: ' . mysql_error());


}
    // Освобождаем память от результата
    mysql_free_result($result);

    // Закрываем соединение
    mysql_close($link);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //header("Location: http://www.example.com/");
    //die();

    echo ("<script>window.location.href='/';</script>");
}
?>
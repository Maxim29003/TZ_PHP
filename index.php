<?php
session_start();
if ($_SESSION['auth'] != 1){
    header("Location: form_r.html");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница </title>
</head>
<body>
    <b>Текущие данные пользователей</b><br>
    <?php
    echo "Name: ". $_SESSION['name']. "<br>";
    echo "Phone_number: ".$_SESSION['phone_number']. "<br>";
    echo "Email: ". $_SESSION['email']. "<br>";
    ?>
    <b>Изменение данных пользователей</b>
    <form name="main_page" action="main_page.php" method="post">
        <p>Имя: </p><input type="text" name="name"> <br>
        <p><input type="submit" name="submit_1" value="Изменить"></p>
    </form>
    <form name="main_page" action="main_page.php" method="post">
        <p>Номер телефона (без + ) : </p><input type="text" name="phone_number"><br>
        <p><input type="submit" name="submit_2"value="Изменить"></p>
    </form>

    <form name="main_page" action="main_page.php" method="post">
        <p>Email: </p><input type="email" name="email"><br>
        <p><input type="submit" name="submit_3"value="Изменить"></p>
    </form>

    <form name="main_page" action="main_page.php" method="post">
        <p>Пароль: </p><input type="password" name="password"><br>
        <p>Повтор пароля: </p><input type="password" name="password_1"> <br>
        <p><input type="submit" name="submit_4"value="Изменить"></p>
    </form>

    

</body>
</html>
<?php
session_start();
$array_key = array("name", "phone_number", "email", "password", "password_1");
$link = mysqli_connect("localhost","root", "", "php_db");

function checking_for_emptiness($key_name){
    if (isset($_POST[$key_name])){
        $res = $_POST[$key_name];
        if ($res == ''){
            unset($res);
        }
    }
    if (empty($res)){
        exit(" НЕ правильно введен  ($key_name) <br>  <a href='form_r.html'>Страница регистации</a>");
    } else {
        return $res;
    }
}

function check_name_email($element, $link, $type){
    if ($type == 'name'){
        $sql = "SELECT id FROM person WHERE  name = '$element'";
    } else if ($type == 'email'){
        $sql = "SELECT id FROM person WHERE  email = '$element'";
    }
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    if (!empty($row)){
        exit("Пользователь с таким ". $type . " уже существует <br>  <a href='form_r.html'>Страница регистации</a>");
    } else {
        return 0;
    }
}

$name = checking_for_emptiness($array_key[0]);
$phone_number = checking_for_emptiness($array_key[1]);
$email = checking_for_emptiness($array_key[2]);
$password = checking_for_emptiness($array_key[3]);
$password_1 = checking_for_emptiness($array_key[4]);




$password = md5($password);
$password_1= md5($password_1);

if ($password == $password_1) {
    if (check_name_email($name, $link,'name') == 0 and check_name_email($email, $link,'email') == 0){
        $sql = "INSERT INTO person (name,phone_number,email, password, password_1) VALUES('$name','$phone_number','$email','$password', '$password_1')";
        $result2 = mysqli_query($link, $sql);
        if ($result2 == "TRUE"){
            $_SESSION['name'] = $name;
            $_SESSION['phone_number'] = $phone_number;
            $_SESSION['email'] = $email;
            header("Location: form_a.html");
        }
        else {
            echo "Ошибка! Вы не зарегистрированы.";
        }
    }
} else {
    exit("Пароли не совпадают <br>  <a href='form_r.html'>Страница регистации</a>");
}



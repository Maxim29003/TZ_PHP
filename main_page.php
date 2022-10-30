<?php

session_start();
if ($_SESSION['auth'] != 1){
    header("Location: form_r.html");
}

$link = mysqli_connect("localhost","root", "", "php_db");
$page = "<br>  <a href='index.php'>Главная</a>";

function get_id($link){
    $start_name = $_SESSION['name'];
    $sql = "SELECT id FROM person WHERE name='$start_name'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    $id = $row['id'];
    return $id;
}

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


$id = get_id($link);

if ( ! empty($_POST)) {
    if (isset($_POST['submit_1'])) {
        $name = checking_for_emptiness('name');
        $sql_check = "SELECT id FROM person WHERE  name = '$name'";
        $result_1 = mysqli_query($link, $sql_check);
        $row = mysqli_fetch_array($result_1);
        if (!empty($row)){
            exit("Пользователь с таким ".$name. " уже существует <br>  <a href='index.php'>Главная</a>");
        } else {
            $sql_name = "UPDATE person SET name='$name' WHERE id='$id'";
            $result_name = mysqli_query($link, $sql_name);
            if ($result_name == "TRUE"){
                $_SESSION['name']=$name;
                exit("Изменения произошли ". $page);
            }else {
                exit("Ошибка ". $page );
            }
        }
    } else if (isset($_POST['submit_2'])) {
        $phone_number = checking_for_emptiness('phone_number');
        $sql_phone = "UPDATE person SET phone_number = '$phone_number' WHERE id='$id'";
            $result_phone = mysqli_query($link, $sql_phone);
            if ($result_phone == "TRUE"){
                $_SESSION['phone_number']=$phone_number;
                exit("Изменения произошли ". $page);
            }else {
                exit("Ошибка ". $page );
            }
               
    } else if (isset($_POST['submit_3'])) {
        $email = checking_for_emptiness('email');
        $sql_check_1 = "SELECT id FROM person WHERE  email = '$email'";
        $result_2 = mysqli_query($link, $sql_check_1);
        $row_1 = mysqli_fetch_array($result_2);
        if (!empty($row_1)){
            exit("Пользователь с таким ".$email. " уже существует <br>  <a href='index.php'>Главная</a>");
        } else {
            $sql_email = "UPDATE person SET email='$email' WHERE id='$id'";
            $result_email = mysqli_query($link, $sql_email);
            if ($result_email == "TRUE"){
                $_SESSION['email']=$email;
                exit("Изменения произошли ". $page);
            }else {
                exit("Ошибка ". $page );
            }
        }
    } else if (isset($_POST['submit_4'])) {
        $password = checking_for_emptiness('password');
        $password_1 = checking_for_emptiness('password_1');
        $password = md5($password);
        $password_1 = md5($password_1);
        if ($password_1 == $password){
            $sql_password = "UPDATE person SET password='$password' WHERE id='$id' ";
            $result_password = mysqli_query($link, $sql_password);
            $sql_password_1 = "UPDATE person SET password_1='$password_1' WHERE id='$id' ";
            $result_password_1 = mysqli_query($link, $sql_password_1);
            if ($result_password == "TRUE" and $result_password_1 == "TRUE"){
                exit("Пароль изменён ". $page);
            }else {
                exit("Ошибка ". $page );
            }
        }else{
            exit("Ошибка, пароли не совпадают ". $page );
        }
    } else {
        echo 'Ошибка';
    }
}
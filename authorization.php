<?php
session_start();
function checking_for_emptiness($key_name){
    if (isset($_POST[$key_name])){
        $res = $_POST[$key_name];
        if ($res == ''){
            unset($res);
        }
    }
    if (empty($res)){
        exit(" НЕ правильно введен  ($key_name) <br>  <a href='form_a.html'>Страница авторизации</a>");
    } else {
        return $res;
    }
}

function check_email_phone($email_phone){
    $res= ['email' => '', 'phone' => ''];
    if (filter_var($email_phone, FILTER_VALIDATE_EMAIL) !== false)
    {
        $res['email'] = $email_phone;
    }else{
            if (is_numeric($email_phone)){
                $res['phone'] = $email_phone;
            }else{
                exit(" НЕ правильно введен  email или phonenumber <br>  <a href='form_a.html'>Страница авторизации</a>");
            }
    }
    return $res;
}

$link = mysqli_connect("localhost","root", "", "php_db");
$email_phone = checking_for_emptiness("email_phone");
$password = checking_for_emptiness("password");

$password = md5($password);

$result = check_email_phone($email_phone);
if ($result['email']!=''){
    $email = $result['email'];
    $sql = "SELECT password FROM person WHERE email  = '$email'";
}else if ($result['phone']!=''){
    $phone = $result['phone'];
    $sql = "SELECT password FROM person WHERE phone_number  = '$phone'";
} else {
    exit(" НЕ правильно введен  email или телефон <br>  <a href='form_a.html'>Страница авторизации</a>");
}
$result_sql = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result_sql);
if ($row['password'] == $password){
    $_SESSION['auth'] = 1;
    header("Location: index.php");
}else {
    $_SESSION['auth'] = 0;
    header("Location: form_a.html");
}
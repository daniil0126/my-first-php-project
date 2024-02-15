<?php
session_start();
require('app/app.php');
require('app/data/db.php');
$host = 'localhost';
$dbname = 'new_web_app';
$username = 'root';
$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!preg_match("/^[a-zA-Z0-9_]+$/", $_POST['login'])) {
    // echo "Логин может содержать только буквы, цифры и подчеркивания.";
    exit;
  }
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // echo "Неверный формат электронной почты.";
    exit;
  }
  if (!preg_match("/^[0-9]+$/", $_POST['phone'])) {
    // echo "Номер телефона может содержать только цифры.";
    exit;
  }
  if (!preg_match("/^[0-9]+$/", $_POST['apartment'])) {
    // echo "Номер квартиры может содержать только цифры.";
    exit;
  }
  if (!preg_match("/^[0-9]+$/", $_POST['floor'])) {
    // echo "Этаж может содержать только цифры.";
    exit;
  }

  $login = filter_var(htmlspecialchars(trim($_POST['login'])));
  $email = filter_var(htmlspecialchars(trim($_POST['email'])));
  $pass = filter_var(htmlspecialchars(trim($_POST['pass'])));
  $phone = filter_var(htmlspecialchars(trim($_POST['phone'])));
  $apartment = filter_var(htmlspecialchars(trim($_POST['apartment'])));
  $floor = filter_var(htmlspecialchars(trim($_POST['floor'])));
  $pass = password_hash($pass, PASSWORD_DEFAULT);

  $mysql = new mysqli('localhost', 'root', '', 'new_web_app');
  $check_login = $mysql->prepare('SELECT login FROM users WHERE login = ?');
  $check_login->bind_param('s', $login);
  $check_login->execute();
  $check_login_result = $check_login->get_result();
  if (mysqli_num_rows($check_login_result) > 0) {
    $_SESSION['error'] = "Пользователь с таким логином уже существует. Пожалуйста, выберите другой логин.";
    header("Location: registration.php");
    exit;
  }

  $check_email = $mysql->prepare('SELECT email FROM users WHERE email = ?');
  $check_email->bind_param('s', $email);
  $check_email->execute();
  $check_email_result = $check_email->get_result();
  if (mysqli_num_rows($check_email_result) > 0) {
    $_SESSION['error'] = "Пользователь с такой электронной почтой уже существует. Пожалуйста, выберите другую электронную почту.";
    header("Location: registration.php");
    exit;
  }
  $stmt = $mysql->prepare('INSERT INTO users (login, email, pass, phone, apartment, floor) VALUES (?, ?, ?, ?, ?, ?)');
  $stmt->bind_param('ssssss', $login, $email, $pass, $phone, $apartment, $floor);
  $stmt->execute();
  if ($mysql->affected_rows > 0) {
    $_SESSION['user'] = $login;
    header("Location: login.php");
    exit;
  } else {
    $_SESSION['error'] = "Произошла ошибка при регистрации. Пожалуйста, попробуйте еще раз.";
    exit;
  }
  // $mysql->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Мой сайт на PHP</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="/assets/css/myproject.css" rel="stylesheet" />
  <meta charset="utf-8">
</head>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Fira+Sans&family=Imbue:opsz@10..100&family=Oswald&display=swap');
</style>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
      </div>
    </div>
    <div class="form">
      <h3>Регистрация</h1>
        <hr>
        <form action="registration.php" method="post">
          <input type="text" name="login" placeholder="Ваш логин">
          <input type="email" name="email" placeholder="E-mail">
          <input type="password" name="pass" placeholder="Пароль">
          <input type="tel" name="phone" placeholder="Номер телефона">
          <input type="number" name="apartment" placeholder="Номер квартиры">
          <input type="number" name="floor" placeholder="Этаж">
          <button type="submit">Зарегистрироваться</button>
        </form>
        <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
        <?php
        if (isset($_SESSION['error'])) {
          echo '<p style="color: rgb(210, 0, 0);">' . $_SESSION['error'] . '</p>';
          unset($_SESSION['error']);
        }
        ?>
    </div>
  </div>
</body>

</html>
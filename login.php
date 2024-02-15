<?php
session_start();
require('app/app.php');
require('app/data/db.php');
$host = 'localhost';
$dbname = 'new_web_app';
$username = 'root';
$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = filter_var(htmlspecialchars(trim($_POST['login'])));
  $pass = filter_var(htmlspecialchars(trim($_POST['pass'])));
  $mysql = new mysqli('localhost', 'root', '', 'new_web_app');
  $stmt = $mysql->prepare('SELECT * FROM users WHERE login = ?');
  $stmt->bind_param('s', $login);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($pass, $user['pass'])) {
      $_SESSION['user'] = $login;
      header('Location: index.php');
      exit;
    } else {
      $_SESSION['error'] = "Неверный пароль. Пожалуйста, поробуйте еще раз";
      header('Location: login.php');
      exit;
    }
  } else {
    $_SESSION['error'] = "Пользователь с таким логином не был найден. Пожалуйста, поробуйте еще раз";
    header('Location: login.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <title>Мой сайт на PHP</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/css/myproject.css">
  <meta charset="utf-8">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Fira+Sans&family=Imbue:opsz@10..100&family=Oswald&display=swap');
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
      </div>
    </div>
    <div class="form">
      <h3>Войти</h1>
        <hr>
        <form action="login.php" method="POST">
          <input type="text" name="login" placeholder="Ваш логин" required>
          <input type="password" name="pass" placeholder="Пароль" required>
          <a href="index.php"><button type="submit">Войти</button></a>
        </form>
        <?php 
        if (isset($_SESSION['error'])) {
          echo '<p style="color: rgb(210, 0, 0);">'.$_SESSION['error'].'</p>';
          unset($_SESSION['error']);
        }
        ?>
    </div>
  </div>
</body>

</html>
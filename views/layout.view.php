<!DOCTYPE html>
<html>

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
  <header>
    <div class="navigation">
      <nav class="navbar">
        <ul class="ul">
          <li class="li"><a class="link" href="#first">Главная</a></li>
          <li class="li"><a class="link" href="#second">Услуги</a></li>
          <li class="li"><a class="link" href="#third">О сервисе</a></li>
          <li class="li"><a class="link" href="#fourth">Контакты</a></li>
          <?php
          ?>
          <li class="li"> <a href="registration.php">Зарегистрироваться</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <?php require("$name.view.php"); ?>
</body>
</html>
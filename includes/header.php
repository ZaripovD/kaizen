<?php require ('includes/logo.php') ?>
<nav class="navbar navbar-inverse ">
<div class="container">
      <div class="navbar-header col-md-2 hidden-xs">
        <span class="navbar-brand">
          <img src="img/uploads/<?php echo $logo['file'].'.'.$logo['extension'] ?>" alt="логотип" id="logo">
        </span>
      </div>
      <div class="col-md-10">
        <ul class="nav navbar-nav">
          <li><a href="index.php"><?php echo $name['name'] ?></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
          <li><a href="authorization.php"><span class="glyphicon glyphicon-log-in"></span> Авторизация</a></li>
        </ul>
      </div>
    </div>
</div>
</nav>

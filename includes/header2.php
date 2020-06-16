<?php require ('includes/logo.php') ?>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
         <span class="navbar-brand">
           <img src="img/uploads/<?php echo $logo['file'].'.'.$logo['extension'] ?>" alt="" id="logo">
         </span>
       </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php"><?php echo $name['name'] ?></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="adminpanel.php"><span class="glyphicon glyphicon-stats"></span>Админ Панель</a></li>
      <li><a href="persarea.php"><span class="glyphicon glyphicon-user"></span>Личный кабинет</a></li>
      <li><a href="php/logout.php"><span class="glyphicon glyphicon-log-in"></span> Выход</a></li>
    </ul>
  </div>
</nav>

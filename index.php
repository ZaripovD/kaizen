<?php include('includes/session.php');
require 'php/orgCheck.php';?>

<div class="container text-center" id="mainPage">

  <?php
    if (isset($_SESSION['logged_user'])) {
      echo "
      <div class='form-group'>
        <a class='btn mainButton' href='persarea.php'>Личный кабинет</a>
      </div>";
      if ($sesRole == 3) {
        echo "
        <div class='form-group'>
          <a class='btn mainButton' href='rationals.php'>Отправить рацпредложение</a>
        </div>";
      } elseif ($sesRole == 2) {
        echo "
        <div class='form-group'>
          <a class='btn mainButton' href='rationals.php'>Отправить рацпредложение</a>
        </div>
        <div class='form-group'>
          <a class='btn mainButton' href='chiefPanel.php'>Информационная панель</a>
        </div>";
      } elseif ($sesRole == 1) {
        echo "
        <div class='form-group'>
          <a class='btn mainButton' href='adminPanel.php'>Админ панель</a>
        </div>";
      }
      echo "
      <div class='form-group'>
        <a class='btn mainButton' href='php/logout.php'>Выйти</a>
      </div>";
    }else {
      echo "
      <div class='form-group'>
        <a class='btn mainButton' href='registration.php'>Зарегистрироваться</a>
      </div>";
      echo "
      <div class='form-group'>
        <a class='btn mainButton' href='authorization.php'>Войти</a>
      </div>";
    }
  ?>
</div>

<?php include('includes/footer.php') ?>

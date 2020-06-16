<div class="container">
  <?php
    if (!isset($_SESSION['logged_user']) || $sesRole != 2) {
      die('Доступ запрещен');
    }
  ?>
</div>

<div class="container">
  <?php
    if (!isset($_SESSION['logged_user']) || $sesRole > 1) {
      die('Доступ запрещен');
    }
  ?>
</div>

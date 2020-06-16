<div class="container">
  <?php
    if (!isset ($_SESSION['logged_user'])) {
      die('Доступ запрещен');
    }
  ?>
</div>

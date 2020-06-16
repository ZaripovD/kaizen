<?php
if (isset($_GET['ВнеситеИнформациюОПредприятии'])) {
  include('includes/session.php');
} else {
  include('includes/adminside.php');
}
require 'php/admaccess.php';?>

<div class="container reg">
<?php
if (isset($data['registr'])) {
  if (empty($data['name'])) {
    $errors[] = "Введите название";
  }
  if (empty($data['description'])) {
    $errors[] = "Введите описание";
  }
  if (strlen($data['description']) < 15) {
    $errors[] = "Описание не должно быть короче 15-ти символов";
  }
  if (empty($errors)) {
    $add = mysqli_query($connection, "INSERT INTO departments (`name`, `description`)
    VALUES ('{$data['name']}', '{$data['description']}')");
    echo '
      <div class="row text-center errors">
        <h1>Отдел добавлен успешно</h1>
      </div>';
  } else {
    echo '
      <div class="row text-center errors">
        <h1>'.array_shift($errors).'</h1>
      </div>';
  }
}
 ?>
  <div class="headReg text-center">
    <h1 class="title">Создать отделение</h1>
  </div>
  <form class="auth" action="addDeps.php" method="post">
    <div class="form-group">
      <label for="name">Название</label>
      <input class="form-control" name="name" placeholder="Название отделения" id="name">
    </div>
    <div class="form-group">
      <label for="desc">Описание</label>
      <input class="form-control" name="description" placeholder="Краткое описание отделения" id="desc">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success" name="registr">
        Создать
      </button>
    </div>
  </form>
</div>


<?php include('includes/footer.php') ?>

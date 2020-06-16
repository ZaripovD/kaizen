<?php
if (isset($_GET['ДобавьтеСферыДеятельности'])) {
  include('includes/session.php');
} else {
  include('includes/adminside.php');
}
require 'php/orgCheck.php';

if (isset($data['registr'])) {
  if (empty($data['sphere'])) {
    $errors[] = "Введите название";
  }
  if (empty($errors)) {
    $add = mysqli_query($connection, "INSERT INTO spheres (`name`) VALUES ('{$data['sphere']}')");
  }else {
    echo "
    <div class='row text-center errors'>
     <h1>".array_shift($errors)."</h1>
    </div>";
  }
}
 ?>

<div class="container reg">
  <div class="headReg text-center">
    <h1 class="title">Сферы деятельности организации</h1>
  </div>
  <form class="auth" action="addSpheres.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="name">Название</label>
      <input class="form-control" name="sphere" placeholder="Направление деятельности" id="name">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success" name="registr">
        Добавить
      </button>
    </div>
  </form>
</div>

<?php include('includes/footer.php') ?>

<?php include('includes/adminSide.php');
require 'php/orgCheck.php';
require 'php/admaccess.php';
$org = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM organization"));
$depsNum = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM departments"));
$userNum = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM chiefs")) + mysqli_num_rows(mysqli_query($connection, "SELECT * FROM user"));
$ideasNum = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ideas"));
 ?>

<div class="container text-center" id="adminPanel">
  <div class="row" id="adminHead">
    <h1>Информация об организации</h1>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h2>Название:</h2>
      <h3><?php echo $org['name'] ?></h3><hr>
    </div>
    <div class="col-md-12">
      <h2>Описание:</h2>
      <h3><?php echo $org['description'] ?></h3><hr>
    </div>
    <div class="col-md-12">
      <h2>Количество зарегистрированных пользователей:</h2>
      <h3><?php echo $userNum ?></h3><hr>
    </div>
    <div class="col-md-12">
      <h2>Количество отделений:</h2>
      <h3><?php echo $depsNum ?></h3><hr>
    </div>
    <div class="col-md-12">
      <h2>Всего создано рацпредложений:</h2>
      <h3><?php echo $ideasNum ?></h3><hr>
    </div>
  </div>
</div>

<?php include('includes/footer.php') ?>

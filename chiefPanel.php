<?php include('includes/chiefSide.php');
require 'php/orgCheck.php';
require 'php/chiefaccess.php';

$dep = mysqli_fetch_assoc(mysqli_query($connection,
"SELECT departments.name as 'dName', description FROM departments LEFT JOIN chiefs ON departments.id = $sesDep"));

$depsNum = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM departments"));

$userNum = mysqli_num_rows(mysqli_query($connection,
"SELECT * FROM user WHERE department = $sesDep")) + mysqli_num_rows(mysqli_query($connection,
"SELECT * FROM chiefs WHERE department = $sesDep"));

$ideasNum = mysqli_num_rows(mysqli_query($connection,
"SELECT * FROM ideas LEFT JOIN user ON ideas.sender = user.id AND user.department = $sesDep WHERE sender = user.id"));
 ?>

<div class="container text-center" id="adminPanel">
  <div class="row" id="adminHead">
    <h1>Информация об отделе</h1>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h2>Название:</h2>
      <h3><?php echo $dep['dName'] ?></h3><hr>
    </div>
    <div class="col-md-12">
      <h2>Описание:</h2>
      <h3><?php echo $dep['description'] ?></h3><hr>
    </div>
    <div class="col-md-12">
      <h2>Количество сотрудников:</h2>
      <h3><?php echo $userNum ?></h3><hr>
    </div>
    <div class="col-md-12">
      <h2>Всего создано рацпредложений:</h2>
      <h3><?php echo $ideasNum ?></h3><hr>
    </div>
  </div>
</div>

<?php include('includes/footer.php') ?>

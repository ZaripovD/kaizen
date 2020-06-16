<?php include('includes/adminSide.php');
require 'php/orgCheck.php';?>

<div class="container text-center" id="adminPanel">
<?php
$dep = mysqli_fetch_assoc(mysqli_query($connection,
"SELECT id, name, description FROM departments WHERE id = {$_GET['dep_id']}"));

$chi = mysqli_query($connection,
"SELECT * FROM chiefs WHERE department = {$_GET['dep_id']} ORDER BY id ASC LIMIT 1");

$chief = mysqli_fetch_assoc($chi);

$chiefCheck = mysqli_num_rows($chi);

$userNum = mysqli_num_rows(mysqli_query($connection,
"SELECT * FROM user WHERE department = {$_GET['dep_id']}")) + mysqli_num_rows(mysqli_query($connection,
"SELECT * FROM chiefs WHERE department = {$_GET['dep_id']}"));

$ideasNum = mysqli_num_rows(mysqli_query($connection,
"SELECT * FROM ideas LEFT JOIN user ON ideas.sender = user.id AND user.department = {$_GET['dep_id']} WHERE sender = user.id"));

$users = mysqli_query($connection, "SELECT * FROM user WHERE department = {$_GET['dep_id']}");
$statusrows = mysqli_num_rows($users);
$statusrow = mysqli_fetch_row($users);

if (isset($data['make'])) {
  $cId = $statusrow['id'];

  $info = mysqli_fetch_row(mysqli_query($connection,
  "SELECT * FROM user WHERE id = $cId"));

  $usPh = mysqli_fetch_row(mysqli_query($connection,
  "SELECT * FROM profile_img WHERE id_user = $cId"));

  $chiefCr = mysqli_query($connection,
  "INSERT INTO chiefs (`name`, `family`, `father`, `department`, `mail`, `phone`, `password`, `role`, `id_pos`)
   VALUES ('{$info['name']}','{$info['family']}','{$info['father']}','{$info['department']}','{$info['mail']}','{$info['phone']}','{$info['password']}', '2','1')");

  $chCr = mysqli_fetch_row(mysqli_query($connection,
  "SELECT * FROM chiefs WHERE phone = '{$info['phone']}'"));

  $chPh = mysqli_query($connection,
  "INSERT INTO chief_img (`id_chief`, `id_status`)
   VALUES ('{$chCr['id']}', '{$usPh['id_status']}')");

  if ($chiefCr && $chPh) {
    $usPhDel = mysqli_query($connection, "DELETE FROM `profile_img` WHERE id = '{$usPh['id']}'");
    $usDel = mysqli_query($connection, "DELETE FROM `user` WHERE id = '{$info['id']}'");
    header("location:dep.php?dep_id={$dep['id']}");
  }
  if ( !$usPh) {
    echo mysqli_error($connection);
  }

}

?>

  <div class="row" id="adminHead">
    <h1>Информация об отделе</h1>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h2>Название:</h2>
      <h3><?php echo $dep['name'] ?></h3><hr>
    </div>
    <div class="col-md-12">
      <h2>Описание:</h2>
      <h3><?php echo $dep['description'] ?></h3><hr>
    </div>
    <div class="col-md-12">
      <h2>Руководитель:</h2>
      <h3><form <?php echo "action='dep.php?dep_id={$dep['id']}'"; ?> method="post">
        <?php
          if ($chiefCheck < 1) {
            echo "<button name='make'>Назначить</button>
            <input type='text' name='chief' list='chiefName'>
            <datalist id='chiefName' name='cchief'>";
            for ($i = 0 ; $i < $statusrows ; ++$i)
            {
              echo " <option>$statusrow[0] $statusrow[2] $statusrow[1] $statusrow[3] </option>";
            }
            "</datalist>";
          } else {
            echo $chief['family']." ".$chief['name']." ".$chief['father'];
          }
        ?>
      </form></h3><hr>
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

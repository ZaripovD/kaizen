<?php include('includes/session.php');
require 'php/useraccess.php';

if (isset($_GET['us'])) {
  $gett = $_GET['us'];
  $who = "user";
  $whoI = "sender";
  $resultImg = mysqli_query($connection, "SELECT * FROM profile_img WHERE id_user = '{$_GET['us']}' ");
} elseif ($_GET['ch']) {
  $gett = $_GET['ch'];
  $who = "chiefs";
  $whoI = "reciever";
  $resultImg = mysqli_query($connection, "SELECT * FROM profile_img WHERE id_chief = '{$_GET['ch']}' ");
}

$rats = mysqli_query($connection, "SELECT
   ideas.id as 'iId', ideas.name as 'iName', date, status,
   status.name as 'sName'
   FROM ideas
   LEFT JOIN status on ideas.status = status.id
   WHERE {$whoI} = {$gett}
   ORDER BY ideas.id DESC
   LIMIT 5");

$inf = mysqli_query($connection, "SELECT
  {$who}.name as 'name', {$who}.family as 'family', {$who}.father as 'father',
  {$who}.phone as 'phone', {$who}.mail as 'mail', {$who}.role as 'role',
  departments.name as 'dName', positions.name as 'pName'
  FROM {$who}
  LEFT JOIN departments on {$who}.department = departments.id
  LEFT JOIN positions on {$who}.id_pos = positions.id
  WHERE {$who}.id = {$gett}");

$ratsCount = mysqli_num_rows($rats);
$infs = mysqli_fetch_assoc($inf);
?>

<div class="container profile">
  <form action="persarea.php" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-4">
        <div class="profileImg">
          <?php
            while ($rowImg = mysqli_fetch_assoc($resultImg)) {
              $ext = $rowImg['extension'];
              if ($rowImg['id_status'] == 8) {
                echo "<img id='profilePic'src='img/uploads/profile/".$infs['phone'].".".$ext."'>";
              } else {
                echo "<img id='profilePic' src='img/uploads/profile/profiledef.jpg'>";
              }
            }
          ?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="profileHead text-center">
          <h3><?php echo $infs['family'].' '.$infs['name'].' '.$infs['father'] ?></h3>
          <h3><?php echo $infs['dName'] ?></h3>
          <h3><?php echo $infs['pName'] ?></h3>
          <?php if ($infs['role'] == 3){
            echo "<p >Отправлено предложений:$ratsCount </p>";
          } ?>
            <div class="profileSocials visible-xs text-center">
              <label>Электронная почта:</label>
              <a href="<?php echo $infs['mail'] ?>"><?php echo $infs['mail'] ?></a><br><br>
              <label>Телефон:</label><br>
              <a href="<?php echo $infs['phone'] ?>"><?php echo $infs['phone'] ?></a>
            </div>
            <?php if ($infs['role'] == 3){
              echo "<ul class='nav nav-tabs' role='tablist'>
                <li class='nav-item'>
                  <h3>Последние пять предложений</h3>
                </li>
              </ul>";
            } ?>

        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 hidden-xs">
        <div class="profileSocials">
          <p>Связь</p>
          <label>Электронная почта:</label>
          <a href="<?php echo $infs['mail'] ?>"><?php echo $infs['mail'] ?></a><br><br>
          <label>Телефон:</label><br>
          <a href="<?php echo $infs['phone'] ?>"><?php echo $infs['phone'] ?></a>
        </div>
      </div>
      <div class='col-md-8 tables'>
      <?php if ($infs['role'] == 3){ echo
      "<table class='table table-striped' style='border: 2px solid #337ab7'>
            <thead>
              <tr>
                <th scope='col'>ID</th>
                <th scope='col'>Название</th>
                <th scope='col'>Статус</th>
              </tr>
            </thead>
            <tbody>";
              while ($res = mysqli_fetch_assoc($rats)) {
                echo "
                <tr>
                  <td data-label='ID'>{$res['iId']}</td>
                  <td data-label='Название'>{$res['iName']}</td>
                  <td data-label='Статус'>{$res['sName']}</td>
                </tr>";
              }
            echo
            "</tbody>
          </table>";
      } ?>

    </div>
    </div>
  </form>
</div>

<?php include('includes/footer.php') ?>

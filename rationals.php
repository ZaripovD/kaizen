<?php include('includes/session.php');
require 'php/orgCheck.php';
require 'php/useraccess.php';?>
<section id="sending">
  <div class="container">
<?php
$ida = mysqli_query($connection, "SELECT * FROM ideas WHERE sender = '$sesid' ORDER BY id DESC LIMIT 1");

if (mysqli_num_rows($ida) > 0) {
  $last = mysqli_fetch_assoc($ida);
  $dt = strtotime($last['date']);
  $oneDay = $dt+(24*60*60);
  if (time() <= $oneDay) {
    die("<div class='row text-center errors'>
     <h1>Предложения можно отправлять не более раза в сутки</h1>
    </div>");
  }
}

$chief = mysqli_query($connection, "SELECT * FROM chiefs WHERE id_pos <> 0 and (department = 1 or department = $sesDep)");

$changebles = mysqli_query($connection, "SELECT * FROM changebles");
$spheres = mysqli_query($connection, "SELECT * FROM spheres");


if (isset($data['send'])) {
  if (empty($data['problem'])) {
    $errors[] = 'Укажите существующую проблему';
  }
  if (empty($data['name'])) {
    $errors[] = 'Введите название предложения';
  }
  if (empty($data['benefit'])) {
    $errors[] = 'Укажите ожидаемый эффект от внедрения';
  }
  if (empty($data['description']) || strlen($data['description']) < 60) {
    $errors[] = 'Напишите развернутое описание предложения';
  }

  if (empty($errors)) {
    $date = date("Y-m-d H:i:s");
    $add = mysqli_query($connection, "INSERT INTO ideas
    (`name`, `sphere`, `problem`, `description`, `reciever`, `sender`, `date`, `changeble`, `benefit`)
    VALUES
    ('{$data['name']}', '{$data['workSphere']}', '{$data['problem']}', '{$data['description']}', '{$data['reciever']}', '{$sesid}', '{$date}', '{$data['changebles']}', '{$data['benefit']}')
    ");

    $adm = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM chiefs WHERE id_pos = 0 "));
    $to = $adm['mail'];
    $subject = "Получено рационализаторского предложение";
    $message = "Получено новое рацпредложение.
    Отправитель:".htmlspecialchars($sesFamily)."  ".htmlspecialchars($sesName)."  ".htmlspecialchars($sesFather)."\n
    Проверьте его на наличие ошибок.";
    $headers = [
    'From' => 'kaizen-site',
    'Content-type' => 'text/html; charset=windows-1251'
    ];
    mail ($to, $subject, $message, $headers);

    header('location:phadd.php?access');
  } else {
    echo "
    <div class='row text-center errors'>
     <h1>".array_shift($errors)."</h1>
    </div>";
  }
}
?>
    <div class="headOne">
      <h1>Отправить рационализаторское предложение</h1>
    </div>
    <form method="post" action="rationals.php">
      <div class="form-group">
        <label for="sender">Отправитель</label>
        <input name="sender" id="sender" class="form-control" type="text" placeholder="<?php echo $sesFamily.' '.$sesName.' '.$sesFather ?>" readonly><br>
        <input name="sendDep" class="form-control" type="text" placeholder="<?php echo $dep['name'] ?>" readonly>
      </div>
      <div class="form-group">
        <label for="reciever">Получатель</label>
        <select class="form-control" name="reciever" id="reciever">
          <?php
          $chiefrows = mysqli_num_rows($chief);
          for ($i = 0 ; $i < $chiefrows ; ++$i)
          {
              $chiefrow = mysqli_fetch_row($chief);
              echo " <option>$chiefrow[0] $chiefrow[2] $chiefrow[1] $chiefrow[3] </option>";
          }?>
        </select>
      </div>
      <div class="form-group">
        <label for="change">Предлагается к изменению</label>
        <select class="form-control" id="change" name="changebles">
          <?php
          $changerows = mysqli_num_rows($changebles);
          for ($i = 0 ; $i < $changerows ; ++$i)
          {
              $changerow = mysqli_fetch_row($changebles);
              echo " <option>$changerow[0] $changerow[1] </option>";
          }?>
        </select>
      </div>
      <div class="form-group">
        <label for="workSphere">Направление деятельности</label>
        <select class="form-control" id="workSphere" name="workSphere">
          <?php
          $spheresrows = mysqli_num_rows($spheres);
          for ($i = 0 ; $i < $spheresrows ; ++$i)
          {
              $spheresrow = mysqli_fetch_row($spheres);
              echo " <option>$spheresrow[0] $spheresrow[1] </option>";
          }?>
        </select>
      </div>
      <div class="form-group">
        <label for="problem">Недостатки текущего положения</label>
        <input type="text" class="form-control" name="problem" id="problem" placeholder="Проблема, которую решает предложение">
      </div>
      <div class="form-group">
        <label for="name">Предложение</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Название предложения">
      </div>
      <div class="form-group">
        <label for="benefit">Ожидаемый положительный эффект</label>
        <input type="text" class="form-control" name="benefit" id="benefit" placeholder="Экономический или иной эффект от внедрения">
      </div>
      <div class="form-group">
        <label for="description">Развернутое описание предложения</label>
        <textarea class="form-control" name="description" id="description" rows="5"></textarea>
      </div>
         <button type="submit" class="btn btn-success" name="send">Отправить</button>
    </form>
  </div>
</section>

<?php include('includes/footer.php') ?>

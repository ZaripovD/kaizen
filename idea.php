<?php include('includes/session.php');?>

<section id="sending">
<div class="container text-center">

<?php
  $find = mysqli_fetch_assoc(mysqli_query($connection,
   "SELECT ideas.id as 'iId', ideas.name as 'iName', ideas.description 'iDesc', problem, benefit, ideas.status as 'iStatus',
    user.name as 'uName', user.family as 'uFam', user.father as 'uFath',
    chiefs.name as 'cName', chiefs.family as 'cFam', chiefs.father as 'cFath',
    departments.name as 'dName', spheres.name as 'sName', changebles.name as 'chName',
    positions.name as 'pName'
    FROM `ideas`
    LEFT JOIN user on user.id = ideas.sender
    LEFT JOIN positions on user.id_pos = positions.id
    LEFT JOIN chiefs on chiefs.id = ideas.reciever
    LEFT JOIN departments on departments.id = user.department
    LEFT JOIN spheres on spheres.id = ideas.sphere
    LEFT JOIN changebles on changebles.id = ideas.changeble
    WHERE ideas.id = {$_GET['idea_id']}"));

    if (isset($data['send'])) {
      $upd = mysqli_query($connection, "UPDATE ideas SET status = '2' WHERE id = '{$_GET['idea_id']}'");
      echo '
       <div class="row text-center ">
         <h1>Предложение отправлено получателю</h1>
       </div>';
    }
    if (isset($data['return'])) {
      if (empty($data['reason'])) {
        $errors[] = 'Опишите проблемы предложения';
      }
      if (empty($errors)) {
        $ret = mysqli_query($connection, "UPDATE ideas SET status = '3' WHERE id = '{$_GET['idea_id']}'");
        $com = mysqli_query($connection, "INSERT INTO comments (`text`, `idea`)
        VALUES ('{$data['reason']}', '{$find['iId']}')");
        echo '
         <div class="row text-center ">
           <h1>Предложение возвращено отправителю</h1>
         </div>';
      } else {
        echo '
         <div class="row text-center ">
           <h1>'.array_shift($errors).'</h1>
         </div>';
      }
    }
    if (isset($data['accept'])) {
      $acc = mysqli_query($connection, "UPDATE ideas SET status = '4' WHERE id = '{$_GET['idea_id']}'");
      echo '
       <div class="row text-center ">
         <h1>Предложение было принято</h1>
       </div>';
    }
    if (isset($data['deny'])) {
      $den = mysqli_query($connection, "UPDATE ideas SET status = '5' WHERE id = '{$_GET['idea_id']}'");
      echo '
       <div class="row text-center ">
         <h1>Предложение было отклонено</h1>
       </div>';
    }
 ?>


 <div id="content">
  <div class="headOne">
    <h1>Рационализаторское предложение</h1>
  </div>
  <form method="post" <?php echo "action='idea.php?idea_id={$find['iId']}'"?> id="look">
    <div class="form-group">
      <label for="sender">Отправитель</label>
      <h4><?php echo $find['uFam'].' '.$find['uName'].' '.$find['uFath'].', '.$find['dName'].', '.$find['pName'] ?></h4>
    </div>
    <div class="form-group">
      <label for="reciever">Получатель</label>
      <h4><?php echo $find['cFam'].' '.$find['cName'].' '.$find['cFath'] ?></h4>
    </div>
    <div class="form-group">
      <label for="change">Предлагается к изменению</label>
      <h4><?php echo  $find['chName']?></h4>
    </div>
    <div class="form-group">
      <label for="workSphere">Направление деятельности</label>
      <h4><?php echo  $find['sName']?></h4>
    </div>
    <div class="form-group">
      <label for="problem">Недостатки текущего положения</label>
      <h4><?php echo  $find['problem']?></h4>
    </div>
    <div class="form-group">
      <label for="name">Предложение</label>
      <h4><?php echo  $find['iName']?></h4>
    </div>
    <div class="form-group">
      <label for="benefit">Ожидаемый положительный эффект</label>
      <h4><?php echo  $find['benefit']?></h4>
    </div>
    <div class="form-group">
      <label for="description">Описание предложения</label>
      <h4><?php echo  $find['iDesc']?></h4>
    </div>
    <hr>
    <div class="form-group">
      <label>Приложения</label><br>
      <?php
        $result = mysqli_query($connection, "SELECT * FROM ideas_img WHERE idea = '{$_GET['idea_id']}' AND extension != 'jpg' AND extension != 'png' AND extension != 'jpeg'");
        while ($row = mysqli_fetch_assoc($result)) {
          $fId = $row['id'];
          $extt = $row['extension'];
          $nFile = $row['file'];
          echo "
          <span class='glyphicon glyphicon-download-alt'></span>
          <a id='downLink' href='php/fileDownload.php?file_id=".$fId."'>".$nFile.".".$extt."</a>";
        }
      ?>
    </div>
    <div class="fotorama" id="ratsFoto">
      <?php
        $result = mysqli_query($connection, "SELECT * FROM ideas_img WHERE idea = '{$_GET['idea_id']}' AND (extension = 'jpg' OR extension = 'png' OR extension = 'jpeg')");
        while ($row = mysqli_fetch_assoc($result)) {
        $extt = $row['extension'];
        $nFile = $row['file'];
        echo "
          <img class='foto' src='img/uploads/rationals/".$nFile.".".$extt."'>";
        }
      ?>
    </div>
     <br>
    <?php
      if ($find['iStatus'] == 1 && $sesPos == 0) {
        echo "
        <a class='btn btn-primary' data-toggle='collapse' href='#collapseExample' role='button' aria-expanded='false' aria-controls='collapseExample'>Отправить на исправление</a>
        <button type='submit' class='btn btn-success' name='send'>Отправить получателю</button>
        <div class='collapse' id='collapseExample'>
          <div class='card card-body'>
            <div class='form-group'>
              <div class='row'><br>
                <label>Причина возврата предложения</label>
              </div>
              <div class='row'>
                <textarea name='reason' rows='8' cols='80'></textarea>
              </div>
              <div class='row'><br>
                <button type='submit' class='btn btn-danger' name='return'>Вернуть</button>
              </div>
            </div>
          </div>
        </div>";
      } elseif ($find['iStatus'] == 2 && $sesPos == 1) {
        echo "
        <button type='submit' class='btn btn-danger' name='deny'>Отклонить предложение</button>
        <button type='submit' class='btn btn-success' name='accept'>Одобрить предложение</button>";
      } elseif ($find['iStatus'] == 4) {
      echo "<a class='btn btn-primary' href='print.php?idea_id={$_GET['idea_id']}' target='_blank'>Сохранить в формате Word</a>";
    }
    ?></div>
  </form>
</div>
</section><br>
<?php include('includes/footer.php') ?>

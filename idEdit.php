<?php include('includes/session.php');
require 'php/useraccess.php';?>

<section id="idea">
<div class="container text-center">

<?php
if ($sesRole == 3) {
  $rats = mysqli_query($connection, "SELECT
     ideas.id as 'iId', ideas.name as 'iName', date, status, problem, benefit, description,
     user.name as 'uName', user.family as 'uFamily', user.father as 'uFather',
     spheres.name as 'sName', spheres.id as 'spId',
     changebles.id as 'cId', changebles.name as 'cName'
     FROM ideas
     LEFT JOIN spheres on ideas.sphere = spheres.id
     LEFT JOIN changebles on ideas.changeble = changebles.id
     LEFT JOIN status on ideas.status = status.id
     LEFT JOIN user on ideas.sender = user.id
     WHERE ideas.id = '{$_GET['idIdea']}'");
} else {
  $rats = mysqli_query($connection, "SELECT
     ideas.id as 'iId', ideas.name as 'iName', date, status, problem,
     user.name as 'uName', user.family as 'uFamily', user.father as 'uFather',
     status.name as 'sName', spheres.id as 'spId',
     changebles.id as 'cId', changebles.name as 'cName'
     FROM ideas
     LEFT JOIN spheres on ideas.sphere = spheres.id
     LEFT JOIN changebles on ideas.changeble = changebles.id
     LEFT JOIN status on ideas.status = status.id
     LEFT JOIN chiefs on ideas.sender = chiefs.id
     WHERE ideas.id = '{$_GET['idIdea']}'");
}
$comm = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM comments WHERE idea = '{$_GET['idIdea']}' "));

$res = mysqli_fetch_assoc($rats);
$resc = mysqli_num_rows($rats);

$chnglbs = mysqli_query($connection, "SELECT * FROM changebles");

$chnR = mysqli_num_rows($chnglbs);

$sphrs = mysqli_query($connection, "SELECT * FROM spheres");
$sphR = mysqli_num_rows($sphrs);

if (isset($data['changeBut'])) {
  if (empty($data['title'])) {
    $errors[] = 'Ни одно поле не должно быть пустым';
  }
  if (empty($data['limitations'])) {
    $limit = $data['limitationsIn'];
  } else {
    $limit = $data['limitationsTA'];
  }

  if (empty($data['benef'])) {
    $ben = $data['benefIn'];
  } else {
    $ben = $data['benefTA'];
  }

  if (empty($data['descrTA'])) {
    $des = $data['descrIn'];
  } else {
    $des = $data['descrTA'];
  }
  if (empty($errors)) {
    $update = mysqli_query($connection,
    "UPDATE ideas SET problem = '$limit', name = '{$data['title']}', benefit = '$ben', description = '$des', status = '1'
     WHERE id = '{$_GET['idIdea']}'");
     if ($update) {
       echo "
       <div class='row text-center'>
         <h1>Обновленная версия была отправлена</h1>
       </div>";
     } else {
       echo mysqli_error($connection);
     }
  } else {
    echo "
    <div class='row text-center errors'>
     <h1>".array_shift($errors)."</h1>
    </div>";
  }
}
?>

<div class="headOne">
  <h1>Редактирование рацпредложения</h1>
</div>
<form method="post" <?php echo "action='idEdit.php?idIdea={$res['iId']}'" ?>>
  <div class="form-group">
    <label for="comments">
      Комментарий администратора
    </label>
    <h3><?php echo $comm['text'] ?></h3>
  </div><hr>
  <div class="form-group">
    <label for="change">Предлагается к изменению</label><br>
    <input type="text" name="" value="<?php echo $res['cId']." ".$res['cName'] ?>" class="ideaInput" list="change">
    <datalist id='change' name='change'>
    <?php
      for ($i = 0 ; $i < $chnR ; ++$i)
      {
        $chn = mysqli_fetch_row($chnglbs);
        echo " <option>$chn[0] $chn[1] </option>";
      }
    ?>
    </datalist>
  </div>
  <div class="form-group">
    <label for="workSphere">Направление деятельности</label><br>
    <input type="text" name="" value="<?php echo $res['spId']." ".$res['sName'] ?>" class="ideaInput" list="sphere">
    <datalist id='sphere' name='change'>
    <?php
      for ($i = 0 ; $i < $sphR ; ++$i)
      {
        $sph = mysqli_fetch_row($sphrs);
        echo " <option>$sph[0] $sph[1] </option>";
      }
    ?>
    </datalist>
  </div>
  <div class="form-group">
    <label for="problem">Недостатки текущего положения</label><br>
    <input type="hidden" name="limitationsIn" value="<?php echo $res['problem'] ?>">
    <textarea name="limitationsTA" rows="3" class="ideaArea"><?php echo $res['problem'] ?></textarea>
  </div>
  <div class="form-group">
    <label for="name">Название предложения</label><br>
    <input type="text" name="title" value="<?php echo $res['iName'] ?>" class="ideaInput">
  </div>
  <div class="form-group">
    <label for="benefit">Ожидаемый положительный эффект</label><br>
    <input type="hidden" name="benefIn" value="<?php echo $res['benefit'] ?>">
    <textarea name="benefTA" rows="4" class="ideaArea"><?php echo $res['benefit'] ?></textarea>
  </div>
  <div class="form-group">
    <label for="description">Описание предложения</label><br>
    <input type="hidden" name="descrIn" value="<?php echo $res['description'] ?>">
      <textarea name="descrTA" rows="8" cols="80" class="ideaArea"><?php echo $res['description'] ?></textarea>
  </div>
  <div class="form-group">
    <button name="changeBut" class="btn btn-success">
      Отправить обновленную версию
    </button>
  </div>
</form>
</div>
</section>
<?php include('includes/footer.php') ?>

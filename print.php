<?php include('includes/session.php');

$year = date("Y", time());
?>

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

 ?>


 <div id="content" >
   <form method="post" <?php echo "action='idea.php?idea_id={$find['iId']}'"?> id="look">
     <p></p>
     <table>
       <thead>
         <tr>
           <th>Организация:</th>
           <th><h3> <?php echo $name['name'] ?>.</h3></th>
           <th>____</th>
           <th>Зарегистрировано</th>
         </tr>
       </thead>
       <tbody>
         <tr>
           <td>наименование предприятия,</td>
           <td>организации, учреждения</td>
           <td>____</td>
           <td>за №  ______________ <br>
           «____»_________ <?php echo $year ?></td>
         </tr>
       </tbody>
     </table><br>

   <table id="classic">
     <thead>
       <tr>
         <th>Фамилия, имя, отчество автора </th>
         <th>Отдел</th>
         <th>Профессия (должность) </th>
       </tr>
     </thead>
     <tbody>
       <tr>
         <td><?php echo $find['uFam'].' '.$find['uName'].' '.$find['uFath']?></td>
         <td><?php echo $find['dName'] ?></td>
         <td><?php echo $find['pName'] ?></td>
       </tr>
     </tbody>
   </table>

    <h2>Заявление <br> на рационализаторское предложение</h2>
  <p>Прошу рассмотреть предложение под названием:<<<?php echo  $find['iName']?>>></p>
  <p>признать его рационализаторским и принять к использованию.</p>
  <p>Предлагается создать (изменить): <?php echo  $find['chName']?></p>
  <div class="text-center">
    <h3>Описание предложения</h3>
  </div>
  <h4>Предложение относится к направлению деятельности:</h4>
  <p><?php echo  $find['sName'] ?></p>

  <h4>Недостатки существующей конструкции изделия, технологии производства, применяемой техники, состава материала или организационного решения:</h4>
  <p><?php echo  $find['problem']?></p>

  <h4>Содержание предлагаемого технического или организационного решения, включая данные, достаточные для его практического осуществления:</h4>
  <p><?php echo  $find['iDesc']?></p>

  <h4>Сведения об экономическом или ином положительном эффекте:</h4>
  <p><?php echo  $find['benefit']?></p><br><br>

  <p>Я утверждаю, что действительно являюсь автором данного предложения.<br>
Мне известно, что в случае признания предложения секретным, я обязуюсь соблюдать правила секретности об открытиях, изобретениях и рационализаторских предложениях.
</p>
<div class="row">
  <div class="col-md-2">
    <p>«   » ________ <?php echo $year ?>г.</p>
  </div>
</div>
    <hr>
    <div class="form-group">
      <h4>Приложения</h4><br>
    </div>
      <?php
        $result = mysqli_query($connection, "SELECT * FROM ideas_img WHERE idea = '{$_GET['idea_id']}' AND (extension = 'jpg' OR extension = 'png' OR extension = 'jpeg')");
        while ($row = mysqli_fetch_assoc($result)) {
        $extt = $row['extension'];
        $nFile = $row['file'];
        echo "
          <img class='attachments' src='img/uploads/rationals/".$nFile.".".$extt."'>";
        }
      ?></div>
  </form>
</div>
</section><br>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js\FileSaver.js"></script>
<script src="js\jquery.wordexport.js"></script>
<script type="text/javascript">
$(function downl() {
            $("#content").wordExport();
            window.close();
    });

</script>

<?php include('includes/footer.php') ?>

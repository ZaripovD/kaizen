<?php include('includes/session.php');
if (!isset($_GET['access'])) {
  die('Доступ закрыт');
}

$idea = mysqli_fetch_assoc(mysqli_query($connection,
"SELECT * FROM ideas WHERE sender = '$sesid' ORDER BY id DESC LIMIT 1"));
$idAp = $idea['id'];
?>

<section id="sending">
  <div class="container">
    <div class="headOne">
      <h1 class="hidden-xs">Отправить рационализаторское предложение</h1>
      <h4 class="visible-xs">Отправить рационализаторское предложение</h4>
    </div>
    <form method="post" action="phAdd.php?access" enctype="multipart/form-data">
        <div class="form-group">
          <label for="attachment">Добавить приложение</label>
          <div class="attach">
            <input type="file" name="file" id="attachment" value="jpg, png, jpeg">
          </div>
        </div>
        <div class="form-group">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success" name="upload">Загрузить</button>
            <p>jpg, jpeg, png, doc, docx, pdf. Не более 6-ти мегабайт.</p>
        </div>
        <div class='form-group'>
          <a href='added.php?access'  class='btn btn-primary stretched-link' style='background-color: grey'>Закончить</a>
        </div>

    <?php if (isset($_POST['upload'])) {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf');

    $chars="qazxswedcvfrtgbnhyujmkiolp";
    $max=4;
    $size=StrLen($chars)-1;
    $letters=null;
    while($max--){
      $letters.=$chars[rand(0,$size)];
    }

    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 6000000) {
          $fileUplName = $sesid."-".$idAp."-".$letters;
          $fileNameNew = $sesid."-".$idAp."-".$letters.".".$fileActualExt;
          $fileDestination = 'img/uploads/rationals/'.$fileNameNew;
          move_uploaded_file($fileTmpName, $fileDestination);
          $update = mysqli_query($connection, "
            INSERT INTO  `ideas_img` (`idea`,`file`, `extension`)
            VALUES ('$idAp','$fileUplName', '$fileActualExt')");
        } else {
          echo "Размер файла слишком большой!";
        }
      } else {
        echo "Произошла ошибка при загрузке файла.";
      }
    } else {
      echo "Этот тип файлов запрещен для загрузки!";
    }
    }
    ?>
      <div class="">
        <?php
    	 		$result = mysqli_query($connection, "SELECT * FROM ideas_img WHERE idea = '$idAp' AND extension != 'jpg' AND extension != 'png' AND extension != 'jpeg'");
    			while ($row = mysqli_fetch_assoc($result)) {
            $fId = $row['id'];
      			$extt = $row['extension'];
      			$nFile = $row['file'];
      			echo "
            <span class='glyphicon glyphicon-download-alt'></span>
            <a href='php/fileDownload.php?file_id=".$fId."'>".$nFile.".".$extt."</a>";
    			}
    	 	?>
      </div><hr>
      <div class="fotorama text-center" id="ratsFoto">
        <?php
    	 		$result = mysqli_query($connection, "SELECT * FROM ideas_img WHERE idea = '$idAp' AND (extension = 'jpg' OR extension = 'png' OR extension = 'jpeg')");
    			while ($row = mysqli_fetch_assoc($result)) {
    			$extt = $row['extension'];
    			$nFile = $row['file'];
    			echo "
            <img src='img/uploads/rationals/".$nFile.".".$extt."'>";
    			}
    	 	?>
      </div>
    </form>
  </div>
</section>

<?php include('includes/footer.php') ?>

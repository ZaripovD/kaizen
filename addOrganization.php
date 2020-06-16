<?php include('includes/session.php');

$chi = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM chiefs WHERE role = 2"));
$chief = $chi['family'].' '.$chi['name'].' '.$chi['father'];
if (isset($data['registr'])) {
  if (empty($data['organ'])) {
    $errors[] = "Введите название";
  }
  if (empty($data['description'])) {
    $errors[] = "Введите описание";
  }
  if (strlen($data['description']) < 15) {
    $errors[] = "Описание не должно быть короче 15-ти символов";
  }
  if (empty($errors)) {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $letters = substr("$fileName", 0, 10);
    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 6000000) {
          $fileNameNew = $letters.".".$fileActualExt;
          $fileDestination = 'img/uploads/'.$fileNameNew;
          move_uploaded_file($fileTmpName, $fileDestination);
          $update = mysqli_query($connection, "
            INSERT INTO  `organization_img` (`file`, `extension`)
            VALUES ('$letters', '$fileActualExt')");
            header('location:addDeps.php');
        } else {
          echo "Размер файла слишком большой!";
        }
      } else {
        echo "Произошла ошибка при загрузке файла.";
      }
    } else {
      echo "Этот тип файлов запрещен для загрузки!";
    }
    $create = mysqli_query($connection, "INSERT INTO organization (`name`, `description`)
    VALUES ('{$data['organ']}', '{$data['description']}')");
  }
}
 ?>

<div class="container reg">
  <div class="headReg text-center">
    <h1 class="title">Информация об организации</h1>
  </div>
  <form class="auth" action="addOrganization.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="name">Название</label>
      <input class="form-control" name="organ" placeholder="Название организации" id="name">
    </div>
    <div class="form-group">
      <label>Руководитель</label><br>
      <input class="form-control" name="city" placeholder="<?php echo $chief ?>" readonly>
    </div>
    <div class="form-group">
      <label for="description">Описание</label>
      <input class="form-control" name="description" placeholder="Краткая информация об организации" id="description">
    </div>
    <div class="form-group">
      <label>Логотип</label>
      <input type="file" name="file">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success" name="registr">
        Зарегистрировать
      </button>
    </div>
  </form>
</div>

<?php include('includes/footer.php') ?>

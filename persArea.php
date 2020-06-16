<?php include('includes/session.php');
require 'php/useraccess.php';

if ($sesRole == '3') {
  $rats = mysqli_query($connection, "SELECT
     ideas.id as 'iId', ideas.name as 'iName', date, status,
     user.name as 'uName', user.family as 'uFamily', user.father as 'uFather',
     status.name as 'sName'
     FROM ideas
     LEFT JOIN status on ideas.status = status.id
     LEFT JOIN user on ideas.sender = user.id
     WHERE sender = $sesid
     ORDER BY ideas.id DESC
     LIMIT 5");
}

$ratsCount = mysqli_num_rows($rats);

if (isset($data['fileUpl'])) {
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
				$fileNameNew = $sesPhone.".".$fileActualExt;
				$fileDestination = 'img/uploads/profile/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
        if ($sesRole == '3') {
          $update = mysqli_query($connection, "
  					UPDATE `profile_img` SET `extension` = '$fileActualExt', `id_status` = '8'");
        } else {
          $update = mysqli_query($connection, "
  					UPDATE `chief_img` SET `extension` = '$fileActualExt', `id_status` = '8'");
        }
        if (!$update) {
          echo mysqli_error($connection);
        }

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

<div class="container profile">
  <form action="persarea.php" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-4">
        <div class="profileImg">
          <?php
          if ($sesRole == 3) {
            $resultImg = mysqli_query($connection,
            "SELECT * FROM profile_img
              WHERE id_user = '$sesid' ");
          }else {
            $resultImg = mysqli_query($connection,
            "SELECT * FROM chief_img
              WHERE id_chief = '$sesid'
              LIMIT 1");
          }
            while ($rowImg = mysqli_fetch_assoc($resultImg)) {
              $ext = $rowImg['extension'];
              if ($rowImg['id_status'] == 8) {
                echo "<img id='profilePic'src='img/uploads/profile/".$sesPhone.".".$ext."'>";
              } else {
                echo "<img id='profilePic' src='img/uploads/profile/profiledef.jpg'>";
              }
            }
          ?>

          <div class="file btn btn-lg btn-primary">
            Поменять фото
            <input type="file" name="file" id="fileCh">
          </div>
        </div>
      </div>
      <div class="col-md-6">
      <button type="submit" name="fileUpl" id="fileUpl">Загрузить</button>
        <div class="profileHead text-center">
          <h3><?php echo $sesFamily.' '.$sesName.' '.$sesFather ?></h3>
          <h3><?php echo $dep['name'] ?></h3>
          <h3><?php echo $pos['name'] ?></h3>
          <?php if ($sesRole == 3){
            echo "<p >Отправлено предложений:$ratsCount </p>";
          } ?>
            <div class="profileSocials visible-xs text-center">
              <label>Электронная почта:</label>
              <a href="<?php echo $sesMail ?>"><?php echo $sesMail ?></a><br><br>
              <label>Телефон:</label><br>
              <a href="<?php echo $sesPhone ?>"><?php echo $sesPhone ?></a>
            </div>
            <?php if ($sesRole == 3){
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
          <a href="mailto:<?php echo $sesMail ?>"><?php echo $sesMail ?></a><br><br>
          <label>Телефон:</label><br>
          <a href="tel:<?php echo $sesPhone ?>"><?php echo $sesPhone ?></a>
        </div>
      </div>
      <div class='col-md-8 tables'>
      <?php if ($sesRole == 3){ echo
      "<table class='table table-striped' style='border: 2px solid #337ab7'>
            <thead>
              <tr>
                <th scope='col'>ID</th>
                <th scope='col'>Название</th>
                <th scope='col'>Статус</th>
                <th scope='col'></th>
              </tr>
            </thead>
            <tbody>";

              while ($res = mysqli_fetch_assoc($rats)) {
                echo "
                <tr>
                  <td data-label='ID'>{$res['iId']}</td>
                  <td data-label='Название'>{$res['iName']}</td>
                  <td data-label='Статус'>{$res['sName']}</td>
                ";
                if ($res['status'] == 3) {
                  echo "
                  <td data-label=''>
                    <a href='idEdit.php?idIdea={$res['iId']}' class='btn btn-primary'>
                      Редактировать
                    </a>
                  </td>
                </tr>";
              } else {
                echo "
                <td data-label=''>
                </td>
                </tr>";
              }
            }; echo
            "</tbody>
          </table>";
      } ?>

    </div>
    </div>
  </form>
</div>
<script>
document.getElementById("fileUpl").style.display = "none";
document.getElementById("fileCh").onclick = function() {
    document.getElementById("fileUpl").style.display = "block";
    document.getElementById("fileCh").style.display = "none";
}

</script>
<?php include('includes/footer.php') ?>

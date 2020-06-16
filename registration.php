<?php include('includes/session.php');
require 'php/password.php'; ?>

<section id="registration">
  <div class="container reg">
    <?php
    $deps = mysqli_query($connection, "SELECT * FROM departments WHERE id <> 1");
    $pos = mysqli_query($connection, "SELECT * FROM positions WHERE id <> 0");

    if (isset($data['registr'])) {
      $name = $data['name'];
      $family = $data['family'];
      $father = $data['father'];
      $birth = $data['birth'];
      $phone = $data['phone'];
      $mail = $data['email'];
      $department = $data['department'];
      $pos = $data['position'];

      $char="1234567890";
      $ma=4;
      $size=StrLen($char)-1;
      $id=null;
      while($ma--){
        $id.=$char[rand(0,$size)];
      }

      if (empty($family)) {
        $errors[] = "Введите фамилию";
      }elseif (!preg_match("/^[а-яА-Я]/", $family)) {
        $errors[] = "Фамилия должна состоять только из букв русского алфавита";
      }
      if (empty($name)) {
        $errors[] = "Введите имя";
      }elseif (!preg_match("/^[а-яА-Я]/", $name)) {
        $errors[] = "Имя должно состоять только из букв русского алфавита";
      }
      if (empty($father)) {
        $errors[] = "Введите отчество";
      }elseif (!preg_match("/^[а-яА-Я]/", $father)) {
        $errors[] = "Отчество должно состоять только из букв русского алфавита";
      }

      if (empty($phone)) {
        $errors[] = "Введите номер телефона";
      }else {
        $phCheck = mysqli_query($connection, "SELECT phone FROM chiefs WHERE phone = $phone");
        $resCheck = mysqli_num_rows($phCheck);
        if ($resCheck > 0) {
          $errors[] = "Номер телефона занят";
        }
      }
      if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "";
      }else {
        $maCheck = mysqli_query($connection, "SELECT mail FROM chiefs WHERE mail = $mail");
        $reCheck = mysqli_num_rows($reCheck);
        if ($reCheck > 0) {
          $errors[] = "Адрес электронной почты занят";
        }
      }

      if (empty($errors)) {

        $create = mysqli_query($connection, "INSERT INTO user (`id`, `name`, `family`, `father`, `department`, `mail`, `phone`, `password`, `id_pos`)
        VALUES ('{$id}', '{$name}', '{$family}', '{$father}', '{$department}', '{$mail}', '{$phone}', '{$sPassword}', '{$pos}')");

        if (!$create) {
          echo mysqli_error($connection);
        }else {
          $us = mysqli_fetch_assoc(mysqli_query($connection, "SELECT id FROM user WHERE phone = '{$phone}'"));
          $crPh = mysqli_query($connection, "INSERT INTO profile_img (`id_user`) VALUES ('{$us['id']}')");

          $to = $mail;
          $subject = "Регистрация на сайте";
          $message = "Вы были успешно зарегистрированы в сервисе для отправки рацпредложений.
          Данные для входа:".htmlspecialchars($phone)."  ".htmlspecialchars($mail)."\n
          Ваш пароль:".htmlspecialchars($password)."\r\n
          Используйте его для входа в личный кабинет.";
          $headers = [
          'From' => 'kaizen-site',
          'Content-type' => 'text/html; charset=windows-1251'
          ];
          mail ($to, $subject, $message, $headers);

          echo '
           <div class="row text-center errors">
             <h1>Регистрация прошла успешна, пароль для входа отправлен на ваш почтовый ящик</h1>
           </div>';

      }
    }else { echo '
      <div class="row text-center errors">
        <h1>'.array_shift($errors).'</h1>
      </div>';
    }
    } ?>

    <div class="headReg text-center">
      <h1 class="title">Регистрация</h1>
    </div>
    <form class="auth" action="registration.php" method="post">
      <div class="form-group">
        <label for="family">Фамилия</label>
        <input class="form-control" type="text" placeholder="Фамилия" name="family" id="family" value="<?php echo @$data['family'] ?>">
      </div>
      <div class="form-group">
        <label for="name">Имя</label>
        <input class="form-control" type="text" placeholder="Имя" name="name" id="name" value="<?php echo @$data['name'] ?>">
      </div>
      <div class="form-group">
        <label for="father">Отчество</label>
        <input class="form-control" type="text" placeholder="Отчество" name="father" id="father" value="<?php echo @$data['father'] ?>">
      </div>
      <div class="form-group">
        <label for="birth">Дата рождения</label>
        <input class="form-control" type="date" name="birth" id="birth" value="<?php echo @$data['birth'] ?>">
      </div>
      <div class="form-group">
        <label for="department">Отдел</label>
        <select class="form-control" id="department" name="department">
          <?php
          if($deps)
          {
          $statusrows = mysqli_num_rows($deps);
          for ($i = 0 ; $i < $statusrows ; ++$i)
          {
              $statusrow = mysqli_fetch_row($deps);
              echo " <option>$statusrow[0] $statusrow[1] </option>";
          }
          } ?>
        </select>
      </div>
      <div class="form-group">
        <label for="position">Должность</label>
        <select class="form-control" id="position" name="position">
          <?php
          if($pos)
          {
          $statusrows = mysqli_num_rows($pos);
          for ($i = 0 ; $i < $statusrows ; ++$i)
          {
              $statusrow = mysqli_fetch_row($pos);
              echo " <option>$statusrow[0] $statusrow[1] </option>";
          }
          } ?>
        </select>
      </div>
      <div class="form-group">
        <label for="phone">Номер телефона</label>
        <input class="form-control" type="text" placeholder="+7-999-999-99-99" name="phone" id="phone" value="<?php echo @$data['phone'] ?>">
      </div>
      <div class="form-group">
        <label for="email">Электронная почта</label>
        <input class="form-control" type="text" placeholder="mail@ex.ru" name="email" id="email" value="<?php echo @$data['email'] ?>">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success" name="registr">
          Зарегистрироваться
        </button>
      </div>
    </form>
  </div>
</section>

<?php include('includes/footer.php') ?>

<?php include('includes/session.php');
require 'php/password.php';?>
<section id="registration">
  <div class="container reg">

<?php
if (isset($data['registr'])) {

  $name = $data['name'];
  $family = $data['family'];
  $father = $data['father'];
  $birth = $data['birth'];
  $phone = $data['phone'];
  $mail = $data['mail'];
  if ($data['role']=="Руководитель") {
    $role = 2;
  } elseif ($data['role']=="Администратор") {
    $role = 1;
  } else{
    $errors[] = "Выберите роль";
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

    $id = substr($phone, -4);
    $create = mysqli_query($connection, "INSERT INTO chiefs (id, name, family, father, department, mail, phone, password, role)
    VALUES ('$id', '$name', '$family', '$father', '1', '$mail', '$phone', '$sPassword', '$role')");

    if (!$create) {
      echo mysqli_error($connection);
    }else {
      $to = $mail;
      $subject = "Регистрация на сайте";
      $message = "Вы были успешно зарегистрированы в сервисе для отправки рацпредложений.
      Ваш пароль:".htmlspecialchars($password)."
      Используйте его для входа в личный кабинет.";
      $headers = [
      'From' => 'kaizen-site',
      'Content-type' => 'text/html; charset=utf-8'
      ];
      mail ($to, $subject, $message, $headers);

      echo '
       <div class="row text-center errors">
         <h1>Регистрация прошла успешна, пароль отправлен на ваш почтовый ящик</h1>
       </div>';

  }
}else { echo '
  <div class="row text-center errors">
    <h1>'.array_shift($errors).'</h1>
  </div>';
}
}
?>


    <div class="headReg text-center">
      <h1 class="title">Регистрация администратора и руководителя</h1>
    </div>
    <form class="auth" action="addchief.php" method="post">
      <div class="form-group">
        <label for="family">Фамилия</label>
        <input class="form-control" type="text" placeholder="Фамилия" id="family" name="family">
      </div>
      <div class="form-group">
        <label for="name">Имя</label>
        <input class="form-control" type="text" placeholder="Имя" id="name" name="name">
      </div>
      <div class="form-group">
        <label for="father">Отчество</label>
        <input class="form-control" type="text" placeholder="Отчество" id="father" name="father">
      </div>
      <div class="form-group">
        <label for="birth">Дата рождения</label>
        <input class="form-control" type="date" placeholder="" id="birth" name="birth">
      </div>
      <div class="form-group">
        <label for="role">Положение</label>
        <select class="form-control" id="role" name="role">
          <option></option>
          <option>Руководитель</option>
          <option>Администратор</option>
        </select>
      </div>
      <div class="form-group">
        <label for="phone">Номер телефона</label>
        <input class="form-control" type="text" placeholder="+7-999-999-99-99" id="phone" name="phone">
      </div>
      <div class="form-group">
        <label for="email">Электронная почта</label>
        <input class="form-control" type="text" placeholder="mail@ex.ru" id="email" name="mail">
      </div>
      <div class="form-group text-center">
        <button type="submit" class="btn btn-success" name="registr">
          Зарегистрироваться
        </button>
      </div>
    </form>
  </div>
</section>

<?php include('includes/footer.php') ?>

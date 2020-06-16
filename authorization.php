<?php include('includes/session.php');

if (isset($data['login'])) {

  $mail = $data['mail'];
  $pass = $data['password'];

  if (empty($mail) || empty($pass)) {
    $errors[] = "Заполните оба поля";
  }
    $findU = mysqli_query($connection, "SELECT * FROM user WHERE mail = '$mail' OR phone = '$mail'");
    $U = mysqli_num_rows($findU);
    $findC = mysqli_query($connection, "SELECT * FROM chiefs WHERE mail = '$mail' OR phone = '$mail'");
    $C = mysqli_num_rows($findC);
    echo mysqli_error($connection);
    if ($C < 1 && $U < 1) {
      $errors[]="Пользователь не найден";
    }
      if ($C > 0) {
        if ($row = mysqli_fetch_assoc($findC)) {
          if (password_verify($pass, $row['password'])) {
            $arr = array($row['id'], $row['father'], $row['name'], $row['family'], $row['department'], $row['mail'], $row['phone'], $row['role'], $row['id_pos']);
            $_SESSION['logged_user'] = $arr;
              header('location: persarea.php');
          }else {
            $errors[]="Неверный пароль";
          }
        }
        }
      if ($U > 0) {
        if ($row = mysqli_fetch_assoc($findU)) {
            if (password_verify($pass, $row['password'])) {
            $arr = array($row['id'], $row['father'], $row['name'], $row['family'], $row['department'], $row['mail'], $row['phone'], $row['role'], $row['id_pos']);
            $_SESSION['logged_user'] = $arr;
                header('location: persarea.php');
              } else {
                $errors[]="Неверный пароль";
              }
        }
    }
  if (!empty($errors)) {
    echo '
      <div class="row text-center errors">
        <h1>'.array_shift($errors).'</h1>
      </div>';
  }
}
 ?>
<section id="registration">
  <div class="container reg">
    <div class="headReg text-center">
      <h1 class="title">Авторизация</h1>
    </div>
    <form class="auth" action="authorization.php" method="post">
      <div class="form-group">
        <label for="">Почта или телефон</label>
        <input class="form-control" name="mail" placeholder="Введите почту или номер телефона">
      </div>
      <div class="form-group">
        <label for="">Пароль</label>
        <input class="form-control" type="password" name="password">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success" name="login">
          Войти
        </button>
      </div>
    </form>
  </div>
</section>

<?php include('includes/footer.php') ?>

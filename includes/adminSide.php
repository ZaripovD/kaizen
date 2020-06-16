<?php include('includes/session.php') ?>

<div id="sideAdmin">
  <nav>
    <button type="button" name="button" id="hide">
    <span class="glyphicon glyphicon-eye-open" id="eyeOpen"></span>
    <span class="glyphicon glyphicon-eye-close" id="eyeClose"></span>
    </button>
    <ul class="nav flex-column text-center" id="navigation">
      <li></li>
      <li class="nav-item">
        <a class="nav-link" href="charts.php">Статистика</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="adminusers.php">Пользователи</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admindepartments.php">Отделения</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="addDeps.php">Добавить отдел</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="addSpheres.php">Добавить сферу деятельности</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="adminstory.php">Предложения</a>
      </li>
    </ul>
  </nav>
</div>

<script type="text/javascript">

document.getElementById("eyeClose").style.display = "none";
document.getElementById("navigation").style.display = "none";

document.getElementById("hide").onclick = function() {

  if (document.getElementById("navigation").style.display == "block") {
    document.getElementById("navigation").style.display = "none";
    document.getElementById("eyeClose").style.display = "none";
    document.getElementById("eyeOpen").style.display = "block";
  } else {
    document.getElementById("navigation").style.display = "block";
    document.getElementById("eyeOpen").style.display = "none";
    document.getElementById("eyeClose").style.display = "block";
  }
}
</script>

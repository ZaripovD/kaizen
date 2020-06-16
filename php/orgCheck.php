<?php
if (mysqli_num_rows($org) < 1) {
  header("location:addorganization.php?ВнеситеИнформациюОПредприятии");

} elseif (mysqli_num_rows($chiefAdm) < 2) {
  header("location:addchief.php?ДобавьтеРуководителяИАдминистратора");

} elseif (mysqli_num_rows($deps) < 2) {
  header("location:adddeps.php?ДобавьтеДваОтдела");

} elseif (mysqli_num_rows($sph) < 2) {
  header("location:addspheres.php?ДобавьтеСферыДеятельности");

}

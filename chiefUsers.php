<?php include('includes/chiefSide.php');
require 'php/orgCheck.php';
require 'php/chiefaccess.php'; ?>

<div class="container departments">
  <input class="form-control mb-4 admTable" id="tableSearch" type="text" placeholder="Введите любые данные пользователя">
  <table>
    <thead>
      <tr>
        <th scope="col">Фамилия</th>
        <th scope="col">Имя</th>
        <th scope="col">Отчество</th>
        <th scope="col">Положение</th>
        <th scope="col">Почта</th>
        <th scope="col">Телефон</th>
      </tr>
    </thead>
    <tbody id="myTable">
<?php
  $users = mysqli_query($connection, "SELECT
    departments.name as 'dName', description, user.name as 'uname', user.family as 'ufamily', user.father as 'ufather',
    user.mail as 'umail', user.phone as 'uphone', role.name as 'role', positions.name as 'posName'
     FROM user
     LEFT JOIN role on user.role = role.id
     LEFT JOIN departments on departments.id = user.department
     LEFT JOIN positions ON positions.id = user.id_pos
     where user.department = $sesDep");

  $chiefs = mysqli_query($connection, "SELECT
    departments.name as 'dName', description, chiefs.name as 'cname', chiefs.family as 'cfamily', chiefs.father as 'cfather',
    chiefs.mail as 'cmail', chiefs.phone as 'cphone', role.name as 'role', positions.name as 'posName'
     FROM chiefs
     LEFT JOIN role on chiefs.role = role.id
     LEFT JOIN departments on departments.id = chiefs.department
     LEFT JOIN positions ON positions.id = chiefs.id_pos
     WHERE chiefs.department = $sesDep");
     
    while ($cres = mysqli_fetch_assoc($chiefs)) {
       echo "
       <tr>
         <td data-label='Фамилия'>{$cres['cfamily']}</td>
           <td data-label='Имя'>{$cres['cname']}</td>
         <td data-label='Отчество'>{$cres['cfather']}</td>
         <td data-label='Положение'>{$cres['posName']}</td>
         <td data-label='Почта'>{$cres['cmail']}</td>
         <td data-label='Телефон'>{$cres['cphone']}</td>
       </tr>
       ";
     }
  while ($res = mysqli_fetch_assoc($users)) {
    echo "
    <tr>
      <td data-label='Фамилия'>{$res['ufamily']}</td>
        <td data-label='Имя'>{$res['uname']}</td>
      <td data-label='Отчество'>{$res['ufather']}</td>
      <td data-label='Положение'>{$res['posName']}</td>
      <td data-label='Почта'>{$res['umail']}</td>
      <td data-label='Телефон'>{$res['uphone']}</td>
    </tr>
    ";
  }
?>

    </tbody>
  </table>
</div>
<script>
$(document).ready(function(){
$("#tableSearch").on("keyup", function() {
  var value = $(this).val().toLowerCase();
  $("#myTable tr").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  });
});
});
</script>
<?php include('includes/footer.php') ?>

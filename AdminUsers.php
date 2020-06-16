<?php include('includes/adminSide.php');
require 'php/orgCheck.php';
require 'php/admaccess.php'; ?>

<div class="container departments">
  <input class="form-control mb-4 admTable" id="tableSearch" type="text" placeholder="Введите любые данные пользователя">
  <table style="border-bottom: 2px solid #337ab7; ">
    <thead>
      <tr>
        <th scope="col">Фамилия</th>
        <th scope="col">Имя</th>
        <th scope="col">Отчество</th>
        <th scope="col">Отдел</th>
        <th scope="col">Должность</th>
        <th scope="col">Почта</th>
        <th scope="col">Телефон</th>
      </tr>
    </thead>
    <tbody id="myTable">
<?php
  $users = mysqli_query($connection, "SELECT
    departments.name as 'dName', description, user.name as 'uname', user.family as 'ufamily', user.father as 'ufather',
    user.mail as 'umail', user.phone as 'uphone', positions.name as 'position'
     FROM user
     LEFT JOIN positions on user.id_pos = positions.id
     LEFT JOIN departments on departments.id = user.department");

  $chiefs = mysqli_query($connection, "SELECT
    departments.name as 'dName', description, chiefs.name as 'cname', chiefs.family as 'cfamily', chiefs.father as 'cfather',
    chiefs.mail as 'cmail', chiefs.phone as 'cphone', positions.name as 'position'
     FROM chiefs
     LEFT JOIN positions on chiefs.id_pos = positions.id
     LEFT JOIN departments on departments.id = chiefs.department");
    while ($cres = mysqli_fetch_assoc($chiefs)) {
       echo "
       <tr>
         <td data-label='Фамилия'>{$cres['cfamily']}</td>
           <td data-label='Имя'>{$cres['cname']}</td>
         <td data-label='Отчество'>{$cres['cfather']}</td>
         <td data-label='Отдел'>{$cres['dName']}</td>
         <td data-label='Должность'>{$cres['position']}</td>
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
      <td data-label='Отдел'>{$res['dName']}</td>
      <td data-label='Должность'>{$res['position']}</td>
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

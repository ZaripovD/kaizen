<?php include('includes/adminSide.php');
require 'php/orgCheck.php';
require 'php/admaccess.php'; ?>

<div class="container departments">
  <input class="form-control mb-4 admTable" id="tableSearch" type="text" placeholder="Введите название, описание или руководителя">
  <table style="border: 2px solid #337ab7; border-top:0px;">
    <thead>
      <tr>
        <th scope="col">Название</th>
        <th scope="col">Описание</th>
        <th scope="col">Руководитель</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody id="myTable">
<?php
  $deps = mysqli_query($connection, "SELECT
    departments.id as 'iId', departments.name as 'name', description, chiefs.name as 'cName', chiefs.family as 'cFam'
     FROM departments
     LEFT JOIN chiefs on departments.id = chiefs.department");

  while ($res = mysqli_fetch_assoc($deps)) {
    echo "
    <tr>
      <td data-label='Название'>{$res['name']}</td>
      <td data-label='Описание'>{$res['description']}</td>
      <td data-label='Руководитель'>{$res['cName']} {$res['cFam']}</td>
      <td data-label=''><a class='btn btn-primary' name='more' href='dep.php?dep_id={$res['iId']}'>Подробнее</a></td>
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

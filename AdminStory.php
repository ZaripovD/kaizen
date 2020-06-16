<?php include('includes/adminSide.php');
require 'php/orgCheck.php';
require 'php/admaccess.php'; ?>

<section>

<div class="container departments">
    <input class="form-control mb-4 admTable" id="tableSearch" type="text" placeholder="Введите имя отправителя, получателя или название отдела">
  <table>
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Название</th>
        <th scope="col">Отправитель</th>
        <th scope="col">Получатель</th>
        <th scope="col">Создано</th>
        <th scope="col">Статус</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody id="myTable">
<?php
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 5;
  $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";

  if ($sesPos == 1) {
    $sel = "SELECT COUNT(*) As total_records
       FROM ideas
       WHERE ideas.status != 1 AND ideas.reciever = '{$sesid}'";
  } else {
    $sel =  "SELECT COUNT(*) As total_records
       FROM ideas
       LEFT JOIN chiefs on ideas.reciever = chiefs.id";
  }

  $result_count = mysqli_query($connection, $sel);
  $total_records = mysqli_fetch_array($result_count);
  $total_records = $total_records['total_records'];
  $total_no_of_pages = ceil($total_records / $total_records_per_page);
  $second_last = $total_no_of_pages - 1;

  if ($sesPos == 1) {
    $last = "SELECT
       ideas.id as 'iId', ideas.name as 'iName', ideas.description as 'iDesc', date, status,
       user.name as 'uName', user.family as 'uFamily', user.father as 'uFather', user.id as 'uId',
       chiefs.family as 'cFamily', chiefs.name as 'cName', chiefs.father as 'cFather', chiefs.id as 'cId',
       status.name as 'sName'
       FROM ideas
       LEFT JOIN status on ideas.status = status.id
       LEFT JOIN user on ideas.sender = user.id
       LEFT JOIN chiefs on ideas.reciever = chiefs.id
       WHERE ideas.status != 1 AND ideas.reciever = '{$sesid}' AND ideas.status != 3
       ORDER BY ideas.id DESC, status
       LIMIT $offset, $total_records_per_page";
  } elseif ($sesPos == 0) {
    $last =  "SELECT
       ideas.id as 'iId', ideas.name as 'iName', ideas.description as 'iDesc', date, status,
       user.name as 'uName', user.family as 'uFamily', user.father as 'uFather', user.id as 'uId',
       chiefs.family as 'cFamily', chiefs.name as 'cName', chiefs.father as 'cFather', chiefs.id as 'cId',
       status.name as 'sName'
       FROM ideas
       LEFT JOIN status on ideas.status = status.id
       LEFT JOIN user on ideas.sender = user.id
       LEFT JOIN chiefs on ideas.reciever = chiefs.id
       ORDER BY ideas.id DESC, status
       LIMIT $offset, $total_records_per_page";
  }
  $result = mysqli_query($connection, $last);
  while ($res = mysqli_fetch_assoc($result)) {
    $date = date("d-".$monthsName[date('n') - 1]."-Y", strtotime($res['date']));
    echo "
    <tr>
      <td data-label='ID'>{$res['iId']}</td>
      <td data-label='Название'>{$res['iName']}</td>
      <td data-label='Отправитель'><a href='person.php?us={$res['uId']}'>{$res['uFamily']} {$res['uName']} {$res['uFather']}</a></td>
      <td data-label='Получатель'>{$res['cFamily']} {$res['cName']} {$res['cFather']}</td>
      <td data-label='Создано'>{$date}</td>
      <td data-label='Статус'>{$res['sName']}</td>
      <td data-label=''><a class='btn btn-primary' name='more' href='idea.php?idea_id={$res['iId']}'>Подробнее</a></td>
    </tr>
    ";
  }
?>
</tbody>
</table>
<div id="pagin">
<strong>Страница <?php echo $page_no." из ".$total_no_of_pages; ?></strong>

<ul class="pagination">
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>

	<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Пред.</a>
	</li>

    <?php
	if ($total_no_of_pages <= 10){
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){

	if($page_no <= 4) {
	 for ($counter = 1; $counter < 8; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
		echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
           if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
       }
       echo "<li><a>...</a></li>";
	   echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
	   echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
            }

		else {
        echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
                }
            }
	}
?>
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>След.</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li><a href='?page_no=$total_no_of_pages'>Конец &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>
</div>
</div>
</section>
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

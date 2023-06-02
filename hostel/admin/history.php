<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// if(isset($_GET['del']))
// {
// 	$id=intval($_GET['del']);
// 	$adn="delete from registration where regNo=?";
// 		$stmt= $mysqli->prepare($adn);
// 		$stmt->bind_param('i',$id);
//         $stmt->execute();
//         $stmt->close();	   


// }
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Управление Студентами</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+510+',height='+430+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
</script>

</head>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
			<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title" style="margin-top:4%">История Студентов</h2>
						<div class="panel panel-default">
							<div class="panel-heading">ДЕТАЛЬНАЯ ИНФОРМАЦИЯ</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>№</th>
											<th>Регистрационный номер</th>
											<th>ФИО</th>
											<th>Комната</th>
											<th>Факультет</th>
											<th>Оплата</th>
											<th>Контакты</th>
											<th>Электронная почта</th>
											<th>Дата Выезда</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>№</th>
											<th>Регистрационный номер</th>
											<th>ФИО</th>
											<th>Комната</th>
											<th>Факультет</th>
											<th>Оплата</th>
											<th>Контакты</th>
											<th>Электронная почта</th>
											<th>Дата Выезда</th>
										</tr>
									</tfoot>
									<tbody>
<?php	
$aid=$_SESSION['id'];
$ret="select * from departed_students";
$stmt= $mysqli->prepare($ret) ;
//$stmt->bind_param('i',$aid);
$stmt->execute() ;//ok
$res=$stmt->get_result();
$cnt=1;
while($row=$res->fetch_object())
	  {
	  	?>
<tr><td><?php echo $cnt;;?></td>
<td><?php echo $row->regno; ?></td>
<td><?php echo $row->firstName; ?>  <?php echo $row->lastName; ?></td>
<td><?php echo $row->roomno;?></td>
<td><?php echo $row->course;?></td>
<td><?php echo $row->payment_status;?></td>
<td><?php echo $row->contactno;?></td>
<td><?php echo $row->emailid;?></td>
<td><?php echo $row->departed_date;?></td>
<td>
<!-- <a href="student-details.php?regno=<?php echo $row->regno;?>" title="Посмотреть полную информацию"><i class="fa fa-desktop"></i></a>&nbsp;&nbsp;
<a href="manage-students.php?del=<?php echo $row->regno;?>" title="Выселить " onclick="return deleteStudent('<?php echo $row->regno;?>');"><i class="fa fa-close"></i></a>
<a href="edit-student.php?del=<?php echo $row->regno;?>" title="Изменить" onclick="return deleteStudent('<?php echo $row->regno;?>');"><i class="fa fa-pencil"></i></a> -->
										</tr>
									<?php
$cnt=$cnt+1;
									 } ?>
											
										
									</tbody>
								</table>

								
							</div>
						</div>

					
					</div>
				</div>

			

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
	<!-- <script>
		function deleteStudent(regno) {
  if (confirm('Do you want to delete?')) {
    $.ajax({
      url: 'delete-student.php', // Путь к файлу обработчику удаления студента
      type: 'POST',
      data: {regno: regno},
      success: function(response) {
        // Здесь можно добавить код для обработки успешного удаления студента

        // Отправка данных о удаленном студенте в таблицу departed_students
        $.ajax({
          url: 'save-departed-student.php', // Путь к файлу обработчику сохранения в departed_students
          type: 'POST',
          data: {regno: regno},
          success: function(response) {
            // Здесь можно добавить код для обработки успешного сохранения студента в departed_students
          },
          error: function(xhr, status, error) {
            // Здесь можно добавить код для обработки ошибки сохранения студента в departed_students
          }
        });
      },
      error: function(xhr, status, error) {
        // Здесь можно добавить код для обработки ошибки удаления студента
      }
    });
  }
  return false;
}

	</script> -->

</body>

</html>

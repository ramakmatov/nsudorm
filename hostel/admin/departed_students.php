<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_GET['del'])) {
    $regno = $_GET['del'];

    // Получаем информацию о пользователе, которого нужно удалить
    $query = "SELECT * FROM registration WHERE regno = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $regno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Сохраняем информацию о пользователе в таблице departed_students
        $insertQuery = "INSERT INTO departed_students (id, regno, firstName, lastName, roomno, course, departed_date, payment_status, isActive, contactno, emailid) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $mysqli->prepare($insertQuery);
        $stmtInsert->bind_param(
            'ssssssssss',
            $row['regno'],
            $row['firstName'],
            $row['lastName'],
            $row['roomno'],
            $row['course'],
            date('Y-m-d'), // Текущая дата в формате 'YYYY-MM-DD'
            $row['payment_status'],
            $row['isActive'],
            $row['contactno'],
            $row['emailid']
        );
        $stmtInsert->execute();

        // Удаляем пользователя из таблицы students
        $deleteQuery = "DELETE FROM registration WHERE regno = ?";
        $stmtDelete = $mysqli->prepare($deleteQuery);
        $stmtDelete->bind_param('s', $regno);
        $stmtDelete->execute();

        echo "<script>alert('User has been departed successfully');</script>";
    } else {
        echo "<script>alert('User not found');</script>";
    }
}

?>
<!-- Остальной HTML-код -->

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Manage Rooms</title>
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
						<h2 class="page-title" style="margin-top:4%">Управление Студентами</h2>
						<div class="panel panel-default">
							<div class="panel-heading">ДЕТАЛЬНАЯ ИНФОРМАЦИЯ</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>№</th>
											<th>фио</th>
											<th>Факультет</th>
											<th>Комната</th>
											<th>Статус</th>
											<th>Оплата</th>
											<th>Оплачено</th>
											<th>Долг</th>
											<th>Действие</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>№</th>
											<th>фио</th>
											<th>Факультет</th>
											<th>Комната</th>
											<th>Статус</th>
											<th>Оплата</th>
											<th>Оплачено</th>
											<th>Остаток</th>
											<th>Действие</th>
										</tr>
									</tfoot>
									<tbody>
<?php	
$aid=$_SESSION['id'];
$ret="select * from registration";
$stmt= $mysqli->prepare($ret) ;
// $stmt->bind_param('i',$aid);
$stmt->execute() ;//ok
$res=$stmt->get_result();
$cnt=1;
while($row=$res->fetch_object())
	  {    
		$payment_amount = $row->payment_amount; // Получение значения payment_amount из объекта $row
		$difference = 8000 - $payment_amount; // Вычитание 8000 из payment_amount
	  	?>
<tr><td><?php echo $cnt;;?></td>
<td><?php echo $row->firstName; ?>   <?php echo $row->lastName; ?></td>
<td><?php echo $row->course;?></td>
<td><?php echo $row->roomno;?></td>
<td><?php echo $row->isActive;?></td>
<td><?php echo $row->payment_status;?></td>
<td><?php echo $row->payment_amount;?></td>
<td><?php echo $difference;?></td>
<td>
<a href="student-details.php?regno=<?php echo $row->regno;?>" title="Посмотерть полную инфорацию"><i class="fa fa-desktop"></i></a>&nbsp;&nbsp;
<a href="edit_student.php?id=<?php echo $row->id;?>" title="Изменит"><i class="fa fa-edit"></i></a>
<a href="departed_students.php?del=<?php echo $row->regno;?>" title="Выселить" onclick="return confirm('Do you want to delete');"><i class="fa fa-close"></i></a></td>
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

</body>

</html>

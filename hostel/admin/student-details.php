<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
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
	<title>Room Details</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">

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
				<div class="row" id="print">


					<div class="col-md-12">
						<h2 class="page-title" style="margin-top:4%">Детали</h2>
						<div class="panel panel-default">
							<div class="panel-heading">ВСЕ ДЕТАЛИ</div>
							<div class="panel-body">
							<table id="zctb" class="table table-bordered " cellspacing="0" width="100%" border="1">
									<span style="float:left" ><i class="fa fa-print fa-2x" aria-hidden="true" OnClick="CallPrint(this.value)" style="cursor:pointer" title="Print the Report"></i></span>			
											   <tbody>
<?php	
$aid=intval($_GET['regno']);
	$ret="select * from registration where (regno	=?)";
$stmt= $mysqli->prepare($ret) ;
$stmt->bind_param('s',$aid);
$stmt->execute() ;
$res=$stmt->get_result();
$cnt=1;
while($row=$res->fetch_object())
	  {
	  	?>

<tr>
<td colspan="6" style="text-align:left; color:red"><h4>Информация о комнате</h4></td>
</tr>
<tr>
<th>Регистрационный номер:</th>
<td><?php echo $row->regno;?></td>
<th>Дата заселении:</th>
<td colspan="3"><?php echo $row->postingDate;?></td>
</tr>



<tr>
<td><b>Номер комнаты:</b></td>
<td><?php echo $row->roomno;?></td>
<td><b>Место:</b></td>
<td><?php echo $row->seater;?></td>
<td><b>Актиность:</b></td>
<td><?php echo $row->isActive;?></td>
</tr>

<tr>
<!-- <td><b>Оплата в год:</b></td>
<td><?php echo $row->feespm;?></td> -->
<td><b>Статус оплаты:</b></td>
<td><?php echo $row->payment_status;?></td>
<th>Оплачено:</th>
<th colspan="5"><?php echo $row->payment_amount;?></th>
</tr>

<tr>
<td colspan="6" style="color:red"><h4>Персональные данные</h4></td>
</tr>

<tr>
<td><b>Регистрационный номер:</b></td>
<td><?php echo $row->regno;?></td>
<td><b>ФИО:</b></td>
<td><?php echo $row->firstName;?><?php echo $row->lastName;?></td>
<td><b>Электронная почта:</b></td>
<td><?php echo $row->emailid;?></td>
</tr>


<tr>
<td><b>Контактные данные:</b></td>
<td><?php echo $row->contactno;?></td>
<td><b>Пол:</b></td>
<td><?php echo $row->gender;?></td>
<td><b>специальность:</b></td>
<td><?php echo $row->course_code;?></td>
</tr>


<tr>
<td><b>Экстранные контакты:</b></td>
<td><?php echo $row->egycontactno;?></td>
<td><b>Имя опекуна:</b></td>
<td><?php echo $row->guardianName;?></td>
<td><b>Отношение опекуна</b></td>
<td><?php echo $row->guardianRelation;?></td>
</tr>

<tr>
<td><b>Контакты опекуна:</b></td>
<td colspan="6"><?php echo $row->guardianContactno;?></td>
</tr>

<tr>
<td colspan="6" style="color:red"><h4>Адрес</h4></td>
</tr>
<tr>
<td><b>Почтовый адрес:</b></td>
<td colspan="2">
<?php echo $row->corresAddress;?><br />
<?php echo $row->corresCity;?>, <?php echo $row->corresPincode;?><br />
<?php echo $row->corresState;?>

</td>
<td><b>Постаянный адрес:</b></td>
<td colspan="2">
<?php echo $row->pmntAddress;?><br />
<?php echo $row->pmntCity;?>, <?php echo $row->pmntPincode;?><br />
<?php echo $row->pmntState;?>	
</td>
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
 <script>
$(function () {
$("[data-toggle=tooltip]").tooltip();
    });
function CallPrint(strid) {
var prtContent = document.getElementById("print");
var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();
}
</script>
</body>

</html>

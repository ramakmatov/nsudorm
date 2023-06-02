<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for add courses
if(isset($_POST['submit']))
{
$seater=$_POST['seater'];
$roomno=$_POST['rmno'];
$fees=$_POST['fee'];
$inventors=$_POST['inventors'];
$sql="SELECT room_no FROM rooms where room_no=?";
$stmt1 = $mysqli->prepare($sql);
$stmt1->bind_param('i',$roomno);
$stmt1->execute();
$stmt1->store_result(); 
$row_cnt=$stmt1->num_rows;;
if($row_cnt>0)
{
echo"<script>alert('Room alreadt exist');</script>";
}
else
{
$query="insert into  rooms (seater,room_no,fees,inventors) values(?,?,?,?)";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('iiis',$seater,$roomno,$fees,$inventors);
$stmt->execute();
echo"<script>alert('Room has been added successfully');</script>";
header("Location: manage-rooms.php");
exit;
}
}
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
	<title>Добавить комнату</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
</head>
<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Добавить комнату</h2>
	
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Добавить комнату</div>
									<div class="panel-body">
									<?php if(isset($_POST['submit']))
{ ?>
<p style="color: red"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg']=""); ?></p>
<?php } ?>
										<form method="post" class="form-horizontal">
											
											<div class="hr-dashed"></div>
											<div class="form-group">
												<label class="col-sm-2 control-label">Количество мест </label>
												<div class="col-sm-8">
												<Select name="seater" class="form-control" required>
<option value="">Выберите место</option>
<option value="1">Один</option>
<option value="2">Два</option>
<option value="3">Три</option>
<option value="4">Четыре</option>
<option value="5">Пять</option>
</Select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Номер комнаты</label>
<div class="col-sm-8">
<input type="text" class="form-control" name="rmno" id="rmno" value="" required="required">
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Оплата (За студента)</label>
<div class="col-sm-8">
<input type="text" class="form-control" name="fee" id="fee" value="" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Инвентари</label>
<div class="col-sm-8">
<input type="text" class="form-control" name="inventors" id="inventors" value="" required="required">
</div>
</div>

<div class="col-sm-8 col-sm-offset-2">
<input class="btn btn-primary" type="submit" name="submit" value="Добавить комнату ">
												</div>
											</div>

										</form>

									</div>
								</div>
									
							
							</div>
						
									
							

							</div>
						</div>

					</div>
				</div> 	
				

			</div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</script>
</body>

</html>
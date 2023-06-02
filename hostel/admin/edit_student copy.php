<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for add courses
if(isset($_POST['submit']))
{ 
// $fname=$_POST['fname'];
// $lname=$_POST['lname'];
$roomno = $_POST['room'];
$isActive = $_POST['isactive'];
$course = $_POST['course'];
// $regno = $_POST['regno'];
$contactno = $_POST['contact'];
$emailid = $_POST['email'];
$emcntno = $_POST['econtact'];
$gurname = $_POST['gname'];
$gurrelation = $_POST['grelation'];
$gurcntno = $_POST['gcontact'];
$caddress = $_POST['address'];
$ccity = $_POST['city'];
$cstate = $_POST['state'];
$cpincode = $_POST['pincode'];
$paddress = $_POST['paddress'];
$pcity = $_POST['pcity'];
$pstate = $_POST['pstate'];
$ppincode = $_POST['ppincode'];
$id=$_GET['id'];
$query="update registration set roomno=?,isActive=?,course=?,contecno=?,emailid=?,emcntno=?,gurname=?,gurrelation=?,gurcntno=?,caddress=?,ccity=?,cstate=?,cpincode=?,paddress=?,pcity=?,pstate=?,ppincode=? where id=?";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('issisississsisssii' ,$roomno,$isActive,$course,$contecno,$emailid,$emcntno,$gurname,$gurrelation,$gurcntno,
$caddress,$ccity,$cstate,$cpincode,$paddress,$pcity,$pstate,$ppincode,$id);
$stmt->execute();
echo"<script>alert('Данные успешно изменены!');</script>";
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
	<title>Изменение</title>
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
					
						<h2 class="page-title">Изменить данные о студенте</h2>
	
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Изменить</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal">
												<?php	
												$id=$_GET['id'];
	$ret="select * from registration where id=?";
		$stmt= $mysqli->prepare($ret) ;
	 $stmt->bind_param('i',$id);
	 $stmt->execute() ;//ok
	 $res=$stmt->get_result();
	 //$cnt=1;
	   while($row=$res->fetch_object())
	  {
	  	?>
<div class="form-group">
<label class="col-sm-2 control-label">Имя :</label>
<div class="col-sm-8">
<input type="text" name="fname" id="fname"  class="form-control" value="<?php echo $row->firstName;?>" required="required" disabled>
<span class="help-block m-b-none">Невозможно изменить</span>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Фамилия : </label>
<div class="col-sm-8">
<input type="text" name="lname" id="lname"  class="form-control" value="<?php echo $row->lastName;?>" required="required" disabled>
<span class="help-block m-b-none">Невозможно изменить</span>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Факультет</label>
<div class="col-sm-8">
<select name="course" id="course" class="form-control" required> 
<option value="<?php echo $row->course;?>">Выбрать факультет</option>
<?php $query ="SELECT * FROM courses";
$stmt2 = $mysqli->prepare($query);
$stmt2->execute();
$res=$stmt2->get_result();
while($row=$res->fetch_object())
{
?>
<option value="<?php echo $row->course_fn;?>"><?php echo $row->course_fn;?>&nbsp;&nbsp;(<?php echo $row->course_sn;?>)</option>
<?php } ?>
</select> </div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Комната </label>
<div class="col-sm-8">
<select name="room" id="room"class="form-control"  onChange="getSeater(this.value);" onBlur="checkAvailability()" required> 
<option >Выберите комнату</option>
<?php $query ="SELECT * FROM rooms";
$stmt2 = $mysqli->prepare($query);
$stmt2->execute();
$res=$stmt2->get_result();
while($row=$res->fetch_object())
{
?>
<option value="<?php echo $row->room_no;?>"> <?php echo $row->room_no;?></option>
<?php } ?>
</select> 
<span id="room-availability-status" style="font-size:12px;"></span>

</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Активность</label>
<div class="col-sm-8">
<select name="isactive" id="duration" class="form-control" value="<?php echo $row->isActive;?>">
<option >Выберите статус активности</option>
<option value="Активен">Активен</option>
<option value="Выехал">Выехал</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Статус оплаты</label>
<div class="col-sm-8">
<select name="payment_status" id="duration" class="form-control" disabled>
<option value="">Выберите статус оплаты</option>
<option value="Оплачено">Оплачено</option>
<option value="Не оплачено">Не оплачено</option>
</select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Сумма оплаты</label>
<div class="col-sm-8">
<input type="number" name="payment_amount" id="payment_amount"  class="form-control" required="required" placeholder="Введите сумму оплаты" disabled>
</div>
</div>
				 <!-- <div class="form-group">
				<label class="col-sm-2 control-label">Оплачено</label>
		<div class="col-sm-8">
	<input type="text" class="form-control" name="cns" id="cns" value="<?php echo $row->payment_amount;?>" required="required">
						 </div>
						</div> -->
<!-- <div class="form-group">
									<label class="col-sm-2 control-label">Course Name(Full)</label>
									<div class="col-sm-8">
									<input type="text" class="form-control" name="cnf" value="<?php echo $row->course_fn;?>" >
												</div>
											</div> -->


<?php } ?>
												<div class="col-sm-8 col-sm-offset-2">
													
													<input class="btn btn-primary" type="submit" name="submit" value="Обновить">
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
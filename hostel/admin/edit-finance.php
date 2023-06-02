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
$payment_status=$_POST['payment_status'];
$payment_amount=$_POST['payment_amount'];
$id=$_GET['id'];
$query="update registration set payment_status=?,payment_amount=? where id=?";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('sii',$payment_status,$payment_amount,$id);
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
	<title>Edit Course</title>
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
					
						<h2 class="page-title">Изменить статус оплаты </h2>
	
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
<label class="col-sm-2 control-label">Статус оплаты</label>
<div class="col-sm-8">
<select name="payment_status" id="duration" class="form-control">
<option value="<?php echo $row->payment_status;?>">Выберите статус оплаты</option>
<option value="Оплачено">Оплачено</option>
<option value="Не оплачено">Не оплачено</option>
</select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Сумма оплаты</label>
<div class="col-sm-8">
<input type="number" name="payment_amount" id="payment_amount"  class="form-control" value="<?php echo $row->payment_amount;?>" required="required" placeholder="Введите сумму оплаты">
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
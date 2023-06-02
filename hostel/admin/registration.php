<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
// Функция для генерации регистрационного номера
function generateRegNo()
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $regNo = '';
    for ($i = 0; $i < 8; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $regNo .= $characters[$index];
    }
    return $regNo;
}

// Код для регистрации
if (isset($_POST['submit'])) {
    $roomno = $_POST['room'];
    $seater = $_POST['seater'];
    // $feespm = $_POST['feespm'];
    $stayfrom = $_POST['stayf'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['payment_amount'];
    $isActive = $_POST['isactive'];
    $course = $_POST['course'];
    $regno = $_POST['regno'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
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

    // Проверка, зарегистрирован ли уже указанный номер регистрации или адрес электронной почты
    $result = "SELECT count(*) FROM userRegistration WHERE email=? OR regNo=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('ss', $emailid, $regno);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<script>alert('Registration number or email id already registered.');</script>";
    } else {
          // Генерация регистрационного номера
        $regno = uniqid();

        // Вставка данных в таблицу registration
        $query = "INSERT INTO registration (id, roomno, seater, stayfrom, payment_status, payment_amount, isactive, course, regno, firstName, lastName, gender, contactno, emailid, egycontactno, guardianName, guardianRelation, guardianContactno, corresAddress, corresCity, corresState, corresPincode, pmntAddress, pmntCity, pmntState, pmntPincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iiissississsisississsisssi', $id, $roomno, $seater, $stayfrom, $payment_status, $payment_amount, $isActive, $course, $regno, $fname, $lname, $gender, $contactno, $emailid, $emcntno, $gurname, $gurrelation, $gurcntno, $caddress, $ccity, $cstate, $cpincode, $paddress, $pcity, $pstate, $ppincode);
        $stmt->execute();
        $stmt->close();

        // // Вставка данных в таблицу userregistration
        // $password = '...'; // Замените на фактическое значение пароля
        // $query1 = "INSERT INTO userregistration (regNo, firstName, lastName, gender, contactNo, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        // $stmt1 = $mysqli->prepare($query1);
        // $stmt1->bind_param('sssssiss', $regno, $fname, $lname, $gender, $contactno, $emailid, $password);
        // $stmt1->execute();
        // $stmt1->close();

        echo "<script>alert('Student successfully registered.');</script>";
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
	<title>Student Hostel Registration</title>
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
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script>
function getSeater(val) {
$.ajax({
type: "POST",
url: "get_seater.php",
data:'roomid='+val,
success: function(data){
//alert(data);
$('#seater').val(data);
}
});

$.ajax({
type: "POST",
url: "get_seater.php",
data:'rid='+val,
success: function(data){
//alert(data);
$('#fpm').val(data);
}
});
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
					
						<h2 class="page-title">Заселение Студента</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">ЗАПОЛНИТЕ ВСЮ ИНФОРМАЦИЮ</div>
									<div class="panel-body">
										<form method="post" action="" class="form-horizontal">
											
										
<div class="form-group">
<label class="col-sm-4 control-label"><h4 style="color: green" align="left">Информация о номере </h4> </label>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Комната </label>
<div class="col-sm-8">
<select name="room" id="room"class="form-control"  onChange="getSeater(this.value);" onBlur="checkAvailability()" required> 
<option value="">Выберите комнату</option>
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
<label class="col-sm-2 control-label">Место</label>
<div class="col-sm-8">
<input type="text" name="seater" id="seater"  class="form-control" readonly="true"  >
</div>
</div>

<!-- <div class="form-group">
<label class="col-sm-2 control-label">Плата за месяц</label>
<div class="col-sm-8">
<input type="text" name="feespm" id="feespm"  class="form-control" readonly="true">
</div>
</div> -->

<div class="form-group">
<label class="col-sm-2 control-label">Дата заселение</label>
<div class="col-sm-8">
<input type="date" name="stayf" id="stayf"  class="form-control" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Оплата</label>
<div class="col-sm-8">
<select name="payment_status" id="duration" class="form-control">
<option value="">Выберите статус оплаты</option>
<option value="Оплачено">Оплачено</option>
<option value="Не оплачено">Не оплачено</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Сумма оплаты</label>
<div class="col-sm-8">
<input type="number" name="payment_amount" id="payment_amount"  class="form-control" required="required" placeholder="Введите сумму оплаты">
</div>
</div>

<!-- <div id="payment-input" style="display: none;">
    <div class="form-group">
        <label class="col-sm-2 control-label">Сумма оплаты</label>
        <div class="col-sm-8">
            <input type="number" name="payment_amount" class="form-control" placeholder="Введите сумму оплаты">
        </div>
    </div>
</div> -->

<div class="form-group">
<label class="col-sm-2 control-label">Активность</label>
<div class="col-sm-8">
<select name="isactive" id="duration" class="form-control">
<option value="">Выберите статус активности</option>
<option value="Активен">Активен</option>
<option value="Выехал">Выехал</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label"><h4 style="color: green" align="left">Персональные данные</h4> </label>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Факультет</label>
<div class="col-sm-8">
<select name="course" id="course" class="form-control" required> 
<option value="">Выбрать факультет</option>
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
<label class="col-sm-2 control-label">Регистрационный номер :</label>
<div class="col-sm-8">
<input type="text" name="regno" id="regno"  class="form-control" required="required"  onBlur="checkRegnoAvailability()" value="<?php echo generateRegNo(); ?>">
<span id="user-reg-availability" style="font-size:12px;"></span>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Имя :</label>
<div class="col-sm-8">
<input type="text" name="fname" id="fname"  class="form-control" required="required" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Фамилия : </label>
<div class="col-sm-8">
<input type="text" name="lname" id="lname"  class="form-control" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Пол : </label>
<div class="col-sm-8">
<select name="gender" class="form-control" required="required">
<option value="">Выберите пол</option>
<option value="male">Мужчина</option>
<option value="female">Женщина</option>
<!-- <option value="others">Others</option> -->
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Контактный номер </label>
<div class="col-sm-8">
<input type="text" name="contact" id="contact"  class="form-control" required="required" >
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Электранная почта </label>
<div class="col-sm-8">
<input type="email" name="email" id="email"  class="form-control" onBlur="checkAvailability()" required="required">
<span id="user-availability-status" style="font-size:12px;"></span>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Экстранный контакт </label>
<div class="col-sm-8">
<input type="text" name="econtact" id="econtact"  class="form-control" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Имя опекуна </label>
<div class="col-sm-8">
<input type="text" name="gname" id="gname"  class="form-control" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Отношение опекуна </label>
<div class="col-sm-8">
<input type="text" name="grelation" id="grelation"  class="form-control" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Контакты опекуна </label>
<div class="col-sm-8">
<input type="text" name="gcontact" id="gcontact"  class="form-control" required="required">
</div>
</div>	

<div class="form-group">
<label class="col-sm-3 control-label"><h4 style="color: green" align="left">Постаянный адрес </h4> </label>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Адрес </label>
<div class="col-sm-8">
<textarea  rows="5" name="paddress"  id="paddress" class="form-control" required="required"></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Город </label>
<div class="col-sm-8">
<input type="text" name="pcity" id="pcity"  class="form-control" required="required">
</div>
</div>	

<div class="form-group">
<label class="col-sm-2 control-label">Область</label>
<div class="col-sm-8">
<select name="pstate" id="pstate"class="form-control" required> 
<option value="">Выбрать</option>
<?php $query ="SELECT * FROM states";
$stmt2 = $mysqli->prepare($query);
$stmt2->execute();
$res=$stmt2->get_result();
while($row=$res->fetch_object())
{
?>
<option value="<?php echo $row->State;?>"><?php echo $row->State;?></option>
<?php } ?>
</select> </div>
</div>							

<div class="form-group">
<label class="col-sm-2 control-label">Почтовый индекс </label>
<div class="col-sm-8">
<input type="text" name="ppincode" id="ppincode"  class="form-control" required="required">
</div>
</div>	


<div class="form-group">
<label class="col-sm-3 control-label"><h4 style="color: green" align="left">Адрес опекуна</h4> </label>
</div>

<!-- <div class="form-group">
<label class="col-sm-5 control-label">Permanent Address same as Correspondense address : </label>
<div class="col-sm-4">
<input type="checkbox" name="adcheck" value="1"/>
</div>
</div> -->

<div class="form-group">
<label class="col-sm-2 control-label">Адрес </label>
<div class="col-sm-8">
<textarea  rows="5" name="address"  id="address" class="form-control" required="required"></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Город </label>
<div class="col-sm-8">
<input type="text" name="city" id="city"  class="form-control" required="required">
</div>
</div>	

<div class="form-group">
<label class="col-sm-2 control-label">Область </label>
<div class="col-sm-8">
<select name="state" id="state"class="form-control" required> 
<option value="">Выбрать</option>
<?php $query ="SELECT * FROM states";
$stmt2 = $mysqli->prepare($query);
$stmt2->execute();
$res=$stmt2->get_result();
while($row=$res->fetch_object())
{
?>
<option value="<?php echo $row->State;?>"><?php echo $row->State;?></option>
<?php } ?>
</select> </div>
</div>							

<div class="form-group">
<label class="col-sm-2 control-label">Почтовый ииндекс </label>
<div class="col-sm-8">
<input type="text" name="pincode" id="pincode"  class="form-control" required="required">
</div>
</div>	


<div class="col-sm-6 col-sm-offset-4">
<button class="btn btn-default" type="submit">Назад</button>
<input type="submit" name="submit" Value="Заселить" class="btn btn-primary">
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
</body>
<script type="text/javascript">
	$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#paddress').val( $('#address').val() );
                $('#pcity').val( $('#city').val() );
                $('#pstate').val( $('#state').val() );
                $('#ppincode').val( $('#pincode').val() );
            } 
            
        });
    });
</script>
	<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'roomno='+$("#room").val(),
type: "POST",
success:function(data){
$("#room-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

	<script>
function checkAvailability() {

$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function ()
{
event.preventDefault();
alert('error');
}
});
}
</script>
	<script>
function checkRegnoAvailability() {

$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'regno='+$("#regno").val(),
type: "POST",
success:function(data){
$("#user-reg-availability").html(data);
$("#loaderIcon").hide();
},
error:function ()
{
event.preventDefault();
alert('error');
}
});
}
// document.getElementById('duration').addEventListener('change', function () {
//         var paymentInput = document.getElementById('payment-input');
//         if (this.value === 'Оплачено') {
//             paymentInput.style.display = 'block';
//         } else {
//             paymentInput.style.display = 'none';
//         }
//     });
	function deleteStudent(regno) {
  if (confirm("Вы уверены, что хотите выселить студента?")) {
    // Выполнить AJAX запрос
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "update-student-status.php?regno=" + regno + "&status=выехал", true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Обработать ответ от сервера
        var response = xhr.responseText;
        if (response === "success") {
          // Обновить статус на странице
          var statusElement = document.getElementById("status-" + regno);
          if (statusElement) {
            statusElement.innerHTML = "выехал";
          }
        } else {
          alert("Произошла ошибка при изменении статуса студента.");
        }
      }
    };
    xhr.send();
  }
  return false;
}

</script>
</body>
</html>
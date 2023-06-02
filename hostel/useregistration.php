<?php
session_start();
include('includes/config.php');

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

if (isset($_POST['submit'])) {
    $regno = generateRegNo();
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $contactno = $_POST['contact'];
    $emailid = $_POST['email'];
    $course = $_POST['course'];

    $result = "SELECT count(*) FROM userRegistration WHERE email=? || regNo=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('ss', $emailid, $regno);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<script>alert('Registration number or email id already registered.');</script>";
    } else {
        $query = "INSERT INTO userRegistration(regNo, firstName, lastName, gender, contactNo, email, course) VALUES(?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sssssss', $regno, $fname, $lname, $gender, $contactno, $emailid, $course);
        $stmt->execute();
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
    <title>Заявка</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript">
        function valid() {
            if (document.registration.password.value != document.registration.cpassword.value) {
                alert("Password and Re-Type Password Field do not match  !!");
                document.registration.cpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="ts-main-content">
    <!-- <?php include('includes/sidebar.php'); ?> -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h2 class="page-title">Заявка Студента</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Данные Студента</div>
                                <div class="panel-body">
                                    <form method="post" action="" name="registration" class="form-horizontal"
                                          onSubmit="return valid();">
                                        <!-- <div class="form-group">
                                            <label class="col-sm-2 control-label">Registration No :</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="regno" id="regno" class="form-control"
                                                       value="<?php echo generateRegNo(); ?>" readonly>
                                                <span id="user-reg-availability" style="font-size:12px;"></span>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Имя :</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="fname" id="fname" class="form-control"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Фамилия :</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="lname" id="lname" class="form-control"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Пол :</label>
                                            <div class="col-sm-8">
                                                <select name="gender" class="form-control" required="required">
                                                    <option value="">Ваш пол</option>
                                                    <option value="male">Мужчина</option>
                                                    <option value="female">Женщина</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Контакты :</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="contact" id="contact" class="form-control"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Электронная почта :</label>
                                            <div class="col-sm-8">
                                                <input type="email" name="email" id="email" class="form-control"
                                                       onBlur="checkAvailability()" required="required">
                                                <span id="user-availability-status" style="font-size:12px;"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Спеиальность :</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="course" id="course" class="form-control"
                                                       required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-sm-offset-4">
                                            <input type="submit" name="submit" Value="Отправить" class="btn-primary btn">
                                                   <a href="index.php" class="btn-default btn">Назад</a>
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
</body>
</html>

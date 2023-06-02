<?php
session_start();
include('includes/config.php');

// if (isset($_GET['del'])) {
//     $id = intval($_GET['del']);
//     $adn = "DELETE FROM registration WHERE firstName=?";
//     // $stmt = $conn->prepare($adn);
//     // $stmt->bind_param('s', $firstName);
//     // $stmt->execute();
//     // $stmt->close();
// }

// Проверка, была ли отправлена форма
if(isset($_POST['submit'])) {
    $regno = $_POST['regno'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $contactno = $_POST['contact'];
    $emailid = $_POST['email'];

    // Проверка, существует ли уже такой регистрационный номер или email в базе данных
    $result = "SELECT count(*) FROM userRegistration WHERE email=? OR regNo=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('ss', $emailid, $regno);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if($count > 0) {
        echo "<script>alert('Registration number or email id already registered.');</script>";
    } else {
        // Сохранение данных в базу данных
        $query = "INSERT INTO userRegistration (regNo, firstName, lastName, gender, contactNo, email) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssssis', $regno, $fname, $lname, $gender, $contactno, $emailid);
        $stmt->execute();
        echo "<script>alert('Student successfully registered.');</script>";
    }
}

// Запрос для получения всех сохраненных заявок из базы данных
$query = "SELECT * FROM userRegistration";
$result = $mysqli->query($query);
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
    <title>Заявки Студентов</title>
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
                alert("Password and Re-Type Password Field do not match!!");
                document.registration.cpassword.focus();
                return false;
            }
            return true;
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
<br>
                <h2 class="page-title">Заявки</h2>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Информации</div>
                            <div class="panel-body">
                                <form method="post" action="" class="form-horizontal">
                                <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th>Registration No</th> -->
                                        <th>Имя</th>
                                        <th>Фамилия</th>
                                        <th>Специальность</th>
                                        <th>Пол</th>
                                        <th>Контакты</th>
                                        <th>Электронная почта</th>
                                        <!-- <th>Действие</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Вывод данных о зарегистрированных студентах
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        // echo "<td>".$row['regNo']."</td>";
                                        echo "<td>".$row['firstName']."</td>";
                                        echo "<td>".$row['lastName']."</td>";
                                        echo "<td>".$row['course']."</td>";
                                        echo "<td>".$row['gender']."</td>";
                                        echo "<td>".$row['contactNo']."</td>";
                                        echo "<td>".$row['email']."</td>";
                                        // echo "<td>";
                                        // echo "<a href='userregistration.php?del=".$row['firstName']."' onclick=\"return confirm('Вы уверены, что хотите удалить?');\"><i class='fa fa-trash-o' aria-hidden='true' style='margin-right: 5px;'></i></a>";
                                        // echo "<a href='registration.php?id=".$row['id']."&regNo=".$row['regNo']."&firstName=".$row['firstName']."&lastName=".$row['lastName']."&gender=".$row['gender']."&contactNo=".$row['contactNo']."&email=".$row['email']."&course=".$row['course']."'><i class='fa fa-check-square-o' aria-hidden='true' style='margin-left: 5px;'></i></a>";
                                        // echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
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
                error:function () {
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
                error:function () {
                    event.preventDefault();
                    alert('error');
                }
            });
        }
    </script>
</body>
</html>

<?php 
session_start();
include "conn.php";
if (isset($_SESSION['id']) && isset($_SESSION['role']) && ($_SESSION['role'] === "admin" || $_SESSION['role'] === "teacher")) {
   
   

    $usersTable = "t_users";
    $school = $conn->prepare("SELECT * FROM $usersTable ORDER BY id DESC");
    $school->execute();
    $users = $school->fetchAll(PDO::FETCH_ASSOC);

    $studentClass = "t_classes_students";
    $school = $conn->prepare("SELECT * FROM $studentClass ORDER BY id DESC");
    $school->execute();
    $studentClasses = $school->fetchAll(PDO::FETCH_ASSOC);

                    
    $classTable = "t_classes";
    $school = $conn->prepare("SELECT * FROM $classTable ORDER BY id DESC");
    $school->execute();
    $classes = $school->fetchAll(PDO::FETCH_ASSOC);

    $tempClassName = "";

    if($_SESSION["role"] == "teacher"){
        foreach ($classes as $class) {
            if($class["class_teacher_id"] === $_SESSION["id"]){
                    $tempClassName =  $class["class_name"];               
            }
        }
      
    }

   
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Yavuzlar School</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-home">
    <div class="black-fill"><br /> <br />
        <div class="container">
        <?php include("includes/homeNavBar.php"); ?>

        <section class="user-text d-flex  align-items-center flex-column btn-danger">
            <div class="conteiner d-flex w-25 mt-4 mb-4">
            <img class="col-md-2 mx-2" src="img/yavuzlar.png" >
            <h3 class="col-md-10 mt-4" style="color: #eee; font-size: 45px; font-family: 'Lobster', cursive;">Students List</h3>
            </div>
            <?php if($_SESSION["role"] === "admin") { ?>
            <p>
                Add New Student <a href="addStudentIndex.php" class="btn btn-info" role="button">ADD</a>
            </p>
            <?php } ?>
        </section>

        <?php if (isset($_GET['error'])) { ?>
        <div id="tempClass" class="alert alert-danger d-flex justify-content-center align-items-center" role="alert">
            <?=$_GET['error']?>
        </div>
        <script>
            setTimeout(function() {
                var errorDiv = document.getElementById("tempClass");
                 errorDiv.style.display = "none";
            }, 2500); 
        </script>
         <?php } ?>

        
        <section id="listUser" class="d-flex justify-content-center align-items-center flex-column">
            <div class="card mb-3 card-1">
                <div class="row g-0">
                    <div class="col-md-12">
                        <div class="table-wrap">
                        <label class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3" for="filter">Filter by Class:</label>
                                <select id="filter" class="p-1 text-primary-emphasis border border-primary-subtle rounded-3" style=" background-color : #78cc8e;">
                                 <option value="all">All</option>

                                  <?php 
                                    foreach ($classes as $class) {
                                   ?>
                                
                                <option value="<?php echo $class["id"]; ?>"><?php echo $class["id"];?> - <?php echo  $class["class_name"];?></option>
                                   <?php } ?>
                                </select>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Class</th>
                                        <th>Exam Number</th>
                                        <th>Detailed Info</th>
                                        <?php if($_SESSION["role"] === "admin") { ?>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 

                                foreach ($users as $user) {
                                    
                                    if($user["role"] === "student"){

                                       
                                        $studentId = "N/A";
                                        $studentClassId = "N/A";
                                        $studentClassName = "none";
                                        foreach ($studentClasses as $studentClass) {
                                            if($studentClass["student_id"] === $user["id"]){
                                                $studentId = $studentClass["id"];
                                                $studentClassId = $studentClass["class_id"];
                                                foreach ($classes as $class) {
                                                    if ((int)$studentClass["class_id"] === (int)$class["id"]){
                                                        $studentClassName =  $class["class_name"];
                                                        break;
                                                    }
                                                }
                                                break;
                                            }
                                        }
                                        
                                        //if(!empty($studentClassId) && $studentClassId != " "){
                                        if($_SESSION["role"] === "teacher" && !($tempClassName == $studentClassName)){
                                            continue;
                                        }   

                                            $query = $conn->prepare("SELECT COUNT(*) AS exam_count FROM t_exams WHERE student_id = ?");
                                            $query->execute([$user["id"]]);
                                            $examCount = $query->fetch(PDO::FETCH_ASSOC)["exam_count"];
                                           
                                            echo '
                                            <tr class="alert" role="alert" data-filter="'. $studentClassId .'">
                                                <th scope="row">'.$user["id"].'</th>
                                                <td>'.$user["name"].'</td>
                                                <td>'.$user["surname"].'</td>
                                                <td>'.$studentClassId.' - '.$studentClassName.'</td>
                                                <td>'.$examCount.'</td> 
                                                <td>
                                                    <a href="studentInfo.php?id='. $user["id"] .'" class="btn btn-block btn-secondary">Detailed Info</a>
                                                </td>
                                                ';

                                                if($_SESSION["role"] === "admin") {
                                                    echo '
                                                    <td>
                                                        <a href="editStudentIndex.php?id='. $studentId .'" class="btn btn-block btn-warning">Edit</a>
                                                    </td>
                                                    <td>
                                                    <a href="app/student/deleteStudent.php?id='. $studentId .'" class="btn btn-block btn-danger">Delete</a>
                                                    </td>
                                                </tr>';
                                                }
                                              
                                        //}  
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>    
    <script>
        document.getElementById('filter').addEventListener('change', function () {
            var selectedRole = this.value;
            var rows = document.querySelectorAll('#listUser tbody tr');
            
            rows.forEach(function (row) {
                if (selectedRole === 'all' || row.getAttribute('data-filter') === selectedRole) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
<?php } else {
    header("Location: login.php");
    exit;
} ?>

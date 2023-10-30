<?php 
session_start();
include "conn.php";
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    
        $studentId = $_GET['id'];

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


        $lessonsTable = "t_lessons";
        $school = $conn->prepare("SELECT * FROM $lessonsTable ORDER BY id DESC");
        $school->execute();
        $lessons = $school->fetchAll(PDO::FETCH_ASSOC);
        

        $examTable = "t_exams";
        $school = $conn->prepare("SELECT * FROM $examTable ORDER BY id DESC");
        $school->execute();
        $exams = $school->fetchAll(PDO::FETCH_ASSOC);
        

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
        <div class="d-flex justify-content-center align-items-center flex-column">
            <div class="login">
                <div class="text-center">
                    <img src="img/yavuzlar.png" width="100">
                </div>
                <h3>Student Information</h3>

                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?=$_GET['error']?>
                    </div>
                <?php } ?>


                <?php foreach($users as $user) {
                    $id = "";
                    $name = "";
                    $surname = "";
                    $username = "";
                    $role = "";

                    if($user["id"] == $studentId){
                        $id = $user["id"];
                        $name = $user["name"];
                        $surname = $user["surname"];
                        $username = $user["username"];
                        $role = $user["role"];

                        $i = 0;
                        $sumScore = 0;

                        foreach ($exams as $exam) { 
                            
                            if($exam["student_id"] == $studentId){
                                $sumScore += $exam["exam_score"];
                                $i++;
                            }
                        }
                        if ($i > 0) {
                            $AvaregeScore = round(($sumScore/ $i), 2);
                        } else {
                            $AvaregeScore = "N/A"; 
                        }

                        break;
                    }
                    
                } ?>
                    <div class="mb-3">
                        <h5>ID: <?= $id ?><br></h5>
                        <h5>Name: <?=  $name ?><br></h5>
                        <h5>Surname: <?=$surname?><br></h5>
                        <h5>Username: <?=$username?><br></h5>
                        <h5>Role: <?=$role?><br></h5>
                        <h5>Overall Success Average: <?=$AvaregeScore?><br></h5>
                    </div>

                    <h4>Exams</h4>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Exam ID</th>
                                <th>Class ID</th>
                                <th>Lesson Name</th>
                                <th>Exam Score</th>
                                <th>Exam Date</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($exams as $exam) { 
                                if($exam["student_id"] == $studentId){
                                   
                                    $studentClassName = " ";
                                    foreach ($classes as $class) {
                                        if($exam["class_id"] === $class["id"]){
                                            $studentClassName =  $class["class_name"];
                                            break;
                                        }
                                    }

                                    $studentLessonName = " ";
                                    foreach ($lessons as $lesson) {
                                        if($exam["lesson_id"] === $lesson["id"]){
                                            $studentLessonName =  $lesson["lesson_name"];
                                            break;
                                        }
                                    }
                                ?>
                                <tr>
                                    <td><?=$exam["id"]?></td>
                                    <td><?=$exam["class_id"]?> - <?=$studentClassName?></td>
                                    <td><?=$exam["lesson_id"]?> - <?=$studentLessonName?></td>
                                    <td><?=$exam["exam_score"]?></td>
                                    <td><?=$exam["exam_date"]?></td>

                                </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>

                <a href="studentsList.php" class="btn btn-secondary" role="button">Back to Students List</a>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php }else {
	header("Location: login.php");
	exit;
} ?>
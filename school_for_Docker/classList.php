<?php 
session_start();
include "conn.php";
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {

    $userId = $_SESSION['id'];
    $userRole = $_SESSION['role'];

    if ($userRole === "student") {
        $studentClassesTable = "t_classes_students";
        $query = $conn->prepare("SELECT class_id FROM $studentClassesTable WHERE student_id = ?");
        $query->execute([$userId]);
        $studentClassIds = $query->fetchAll(PDO::FETCH_COLUMN);
    }else if($userRole === "teacher"){
        $classesTable = "t_classes";
        $query = $conn->prepare("SELECT id FROM $classesTable WHERE class_teacher_id = ?");
        $query->execute([$userId]);
        $teacherClassIds = $query->fetchAll(PDO::FETCH_COLUMN);
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
        	<h4 class="col-md-10 mt-4">Class List</h4>
            </div>
            <?php if($_SESSION["role"] === "admin") { ?>
        	<p>
            Add New Class <a href="addClassIndex.php" class="btn btn-info" role="button" >ADD</a>
            </p>
            <?php } ?>
        </section>

        <?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-danger d-flex justify-content-center align-items-center" role="alert">
			  <?=$_GET['error']?>
			</div>
		<?php } ?>
        
        <section id="listUser"
                 class="d-flex justify-content-center align-items-center flex-column">
        	<div class="card mb-3 card-1">
			  <div class="row g-0">
              <div class="col-md-12">
                <div class="table-wrap">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Teacher</th>
                                <th>Class Name</th>
                                
                                <?php if($_SESSION["role"] === "admin" || $_SESSION["role"] === "teacher") { ?>
                                <th>Number of Students</th>
                                <th>Course Average</th>
                                <th>Overall Success</th>
                                <th>Class Success</th>

                                <?php } ?>

                                <?php if($_SESSION["role"] === "admin") { ?>
                                <th>Edit</th>
                                <th>Delete</th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tbody>
                        <?php 

                        $studentClass = "t_classes_students";
                        $school = $conn->prepare("SELECT * FROM $studentClass ORDER BY id DESC");
                        $school->execute();
                        $studentClasses = $school->fetchAll(PDO::FETCH_ASSOC);                        
                                                
                        $classesTable = "t_classes";
                        $school = $conn->prepare("SELECT * FROM $classesTable ORDER BY id DESC");
                        $school->execute();
                        $classes = $school->fetchAll(PDO::FETCH_ASSOC);
                        
                        $examTable = "t_exams";
                        $school = $conn->prepare("SELECT * FROM $examTable ORDER BY id DESC");
                        $school->execute();
                        $exams = $school->fetchAll(PDO::FETCH_ASSOC);
                        

                        foreach ($classes as $class) { 
                            if ($userRole === "student" && !in_array($class["id"], $studentClassIds)) {
                                continue;
                            }else if($userRole === "teacher" && !in_array($class["id"], $teacherClassIds)){
                                continue;
                            }

                            $teacherName = "No longer a teacher";
                            $teacherSurname = "";   
                           
                            $teacherTable = "t_users";
                            $teacherQuery = $conn->prepare("SELECT id, name, surname FROM $teacherTable WHERE id = ?");
                            $teacherQuery->execute([$class["class_teacher_id"]]);
                            $teacher = $teacherQuery->fetch(PDO::FETCH_ASSOC);

                           
                            if ($teacher) {
                                $teacherName = $teacher["name"];
                                $teacherSurname = $teacher["surname"];
                            }
                             
                            // Student Count
                            $studentsInClassQuery = $conn->prepare("SELECT COUNT(*) AS student_count FROM t_classes_students WHERE class_id = ?");
                            $studentsInClassQuery->execute([$class["id"]]);
                            $studentCount = $studentsInClassQuery->fetch(PDO::FETCH_ASSOC)["student_count"];
                            
                            // Course Average
                            $courseAverageQuery = $conn->prepare("SELECT AVG(exam_score) AS avg_score FROM t_exams WHERE class_id = ?");
                            $courseAverageQuery->execute([$class["id"]]);
                            $averageSuccess = $courseAverageQuery->fetch(PDO::FETCH_ASSOC)["avg_score"];

                             // Overall Success
                       
                            
                            $j = 0;
                            $overallSuccess = $averageSuccess; 
                            foreach ($exams as $exam) { 
                                if($exam["class_id"] == $class["id"]){
                                    foreach ($studentClasses as $studentClass) {
                                        if($exam["student_id"] == $studentClass["student_id"]){
                                            $j++;
                                        }
                                    }
                                }
                            }
                        
                            // Class Success

                            $i = 0;
                            $sumScore = 0;

                            foreach ($exams as $exam) { 
                                if($exam["class_id"] == $class["id"]){
                                    foreach ($studentClasses as $studentClass) {
                                        if($exam["student_id"] == $studentClass["student_id"]){
                                            $sumScore += $exam["exam_score"];
                                            $i++;
                                        }
                                    }
                                }
                            }

                            //$AvaregeScore = $sumScore / $i;
                            $AvaregeScore = $sumScore;
                            if ($i > 0 && $studentCount > 0) {
                                $ClassSuccessScore = round((($AvaregeScore/ $i) / $studentCount), 2);
                            } else {
                                $ClassSuccessScore = "N/A"; 
                            }

                            echo '
                            <tr class="alert" role="alert">
                                <th scope="row">' . $class["id"] . '</th>
                                <td>' . $teacherName . ' ' . $teacherSurname . '</td>
                                <td>' . $class["class_name"] . '</td>
                                ';
                                if($_SESSION["role"] === "admin" || $_SESSION["role"] === "teacher") {
                                    echo '
                                    <td>' . $studentCount . '</td>
                                    <td>' . ($averageSuccess ? round($averageSuccess, 2) : "N/A") . '</td>
                                    <td>' . ($overallSuccess ? round(($averageSuccess/$j), 2) : "N/A") . '</td>
                                    <td>' . $ClassSuccessScore . '</td>
                                    ';
                                }
                            if($_SESSION["role"] === "admin") {
                                echo '
                                <td>
                                <a href="editClassIndex.php?id='. $class["id"] .'" class="btn btn-block btn-warning">Edit</a>
                                </td>
                                <td>
                                    <a href="app/class/deleteClass.php?id='. $class["id"] .'" class="btn btn-block btn-danger">Delete</a>
                                </td>
                            </tr>';
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
			  </div>
			</div>
        </section>

    	</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>
<?php } else {
    header("Location: login.php");
    exit;
} ?>

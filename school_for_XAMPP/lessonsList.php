<?php 
session_start();
include "conn.php";
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {


    $examTable = "t_exams";
    $school = $conn->prepare("SELECT * FROM $examTable ORDER BY id DESC");
    $school->execute();
    $exams = $school->fetchAll(PDO::FETCH_ASSOC);

    $teacherRole = "teacher";
    $query = $conn->prepare("SELECT id, name, surname FROM t_users WHERE role = ?");
    $query->execute([$teacherRole]);

    $teachers = $query->fetchAll(PDO::FETCH_ASSOC);
  

    $lessonsTable = "t_lessons";
    $school = $conn->prepare("SELECT * FROM $lessonsTable ORDER BY id DESC");
    $school->execute();
    $lessons = $school->fetchAll(PDO::FETCH_ASSOC); 


    $lessonArray = array();
    $userRole = $_SESSION['role'];

    if($_SESSION['role'] == "student"){
        foreach ($exams as $exam) {
          if($exam["student_id"] == $_SESSION['id']){
            foreach($lessons as $lesson){
                if($exam["lesson_id"] == $lesson["id"]){
                    array_push($lessonArray, $lesson["id"]);
                }
            }
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
        	<h4 class="col-md-10 mt-4">Lessons List</h4>
            </div>
            <?php if($_SESSION["role"] === "admin") { ?>
        	<p>
            Add New Lesson <a href="addLessonIndex.php" class="btn btn-info" role="button" >ADD</a>
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
                <label class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3" for="filter">Filter by Teacher:</label>
                                <select id="filter" class="p-1 text-primary-emphasis border border-primary-subtle rounded-3" style=" background-color : #78cc8e;">
                                 <option value="all">All</option>

                                  <?php 
                                     
                                        foreach ($teachers as $teacher) { 
                                           
                                        
                                   ?>
                                
                                <option value="<?php echo $teacher["id"]; ?>"><?php echo  $teacher["name"];?> - <?php echo   $teacher["surname"];?></option>
                                   <?php } ?>
                                </select>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Teacher Id</th>
                                <th>Lesson Name</th>
                                <?php if($_SESSION["role"] === "admin" || $_SESSION["role"] === "teacher") { ?>
                                <th>Edit</th>
                                <?php } ?>
                                <?php if($_SESSION["role"] === "admin") { ?>
                                <th>Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                       
                     
                        foreach ($lessons as $lesson) { 
                            if($userRole === "student" && !in_array($lesson["id"], $lessonArray)){
                                continue;
                            }else if($userRole === "teacher" && !($lesson["teacher_user_id"] === $_SESSION["id"])){
                                continue;
                            }
                            
                            $teacherName = "no longer in the role of teacher";
                            $teacherSurname = "";   
                            foreach ($teachers as $teacher) { 
                                if($teacher['id'] == $lesson["teacher_user_id"]){
                                    $teacherName = $teacher["name"];
                                    $teacherSurname = $teacher["surname"];
                                }
                            }
                                echo '
                                <tr class="alert" role="alert" data-filter="'. $lesson["teacher_user_id"] .'">
                                    <th scope="row">' . $lesson["id"] . '</th>
                                    <td>'.$lesson["teacher_user_id"].' - ' . $teacherName . ' ' . $teacherSurname . '</td>
                                    <td>'.$lesson["lesson_name"].'</td>
                                    
                                ';
                                if($_SESSION["role"] === "admin" || $_SESSION["role"] === "teacher") {
                                    echo '
                                    <td>
                                    <a href="editLessonIndex.php?id='. $lesson["id"] .'" class="btn btn-block btn-warning">Edit</a>
                                </td>';
                                }
                                if($_SESSION["role"] === "admin") {
                                    echo '
                                    <td>
                                    <a href="app/lesson/deleteLesson.php?id='. $lesson["id"] .'" class="btn btn-block btn-danger">Delete</a>
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
<?php }else {
	header("Location: login.php");
	exit;
} ?>
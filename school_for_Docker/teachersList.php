<?php 
session_start();
include "conn.php";
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
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
        	<div class="conteiner d-flex w-50 mt-4 mb-4 ml-4">
            <img class="col-md-2 mx-2" src="img/yavuzlar.png" >
        	<h4 class="col-md-10 mt-4">Teachers List</h4>
            </div>
        </section>

        
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
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Lesson</th>
                                <th>Class</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $usersTable = "t_users";
                        $school = $conn->prepare("SELECT * FROM $usersTable ORDER BY id DESC");
                        $school->execute();
                        $users = $school->fetchAll(PDO::FETCH_ASSOC);

                        
                        $classTable = "t_classes";
                        $school = $conn->prepare("SELECT * FROM $classTable ORDER BY id DESC");
                        $school->execute();
                        $classes = $school->fetchAll(PDO::FETCH_ASSOC);


                        $lessonsTable = "t_lessons";
                        $school = $conn->prepare("SELECT * FROM $lessonsTable ORDER BY id DESC");
                        $school->execute();
                        $lessons = $school->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($users as $user) {
                            if($user["role"] === "teacher"){
                                $userLessons = array(); 
                                foreach ($lessons as $lesson) {
                                    if ($user["role"] === "teacher" && $user["id"] === $lesson["teacher_user_id"]) {
                                        $userLessons[] = $lesson["lesson_name"]; 
                                    }
                                }

                                $userClass = "";
                                foreach ($classes as $class) {
                                    if ($user["role"] === "teacher" && $user["id"] === $class["class_teacher_id"]) {
                                        $userClass = $class["class_name"];
                                        break;
                                    }
                                }
                                
                            
                                $lessonsText = implode(', ', $userLessons);
                            
                                echo '
                                <tr class="alert" role="alert">
                                    <th scope="row">'.$user["id"].'</th>
                                    <td>'.$user["name"].'</td>
                                    <td>'.$user["surname"].'</td>
                                    <td>'.$lessonsText.'</td>
                                    <td>'.$userClass.'</td> 
                                </tr>
                                ';
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
<?php }else {
	header("Location: login.php");
	exit;
} ?>
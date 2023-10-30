<?php
include "conn.php";

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || ($_SESSION['role'] !== "admin" && $_SESSION['role'] !== "teacher")) {
    $em = "Warning";
    header("Location: lessonsList.php?error=$em");
    exit;
} else {

    $id = $_GET['id'];
    $classTable = "t_classes";

    // If the user is a teacher, he can only pull his own classes
    if ($_SESSION['role'] === "teacher") {
        $teacher_id = $_SESSION['id'];

        $query = $conn->prepare("SELECT * FROM $classTable WHERE class_teacher_id = ?");
        $query->execute([$teacher_id]);
        $classes = $query->fetchAll(PDO::FETCH_ASSOC);

        // Class to which the teacher is assigned
        $query = $conn->prepare("SELECT class_name FROM $classTable WHERE class_teacher_id = ?");
        $query->execute([$teacher_id]);
        $assigned_class = $query->fetchColumn();
    } else {
        $query = $conn->prepare("SELECT * FROM $classTable");
        $query->execute();
        $classes = $query->fetchAll(PDO::FETCH_ASSOC);

        $assigned_class = ""; // There is no class assigned for admin
    }

    
    $teacherRole = "teacher";
    $query = $conn->prepare("SELECT id, name, surname FROM t_users WHERE role = ?");
    $query->execute([$teacherRole]);
    $teachers = $query->fetchAll(PDO::FETCH_ASSOC);

    // Identify teachers unassigned classes
    $unassigned_classes = [];
    foreach ($teachers as $teacher) {
        $teacher_id = $teacher['id'];

        $query = $conn->prepare("SELECT class_name FROM $classTable WHERE class_teacher_id = ?");
        $query->execute([$teacher_id]);
        $assigned_class = $query->fetchColumn();

        if ($assigned_class == null) {
            $unassigned_classes[] = $teacher;
        }
    }

    $class_name = "";
    foreach ($classes as $class) {
        if ($class['id'] == $id) {
            $class_name = $class['class_name'];
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Edit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
        <div class="d-flex justify-content-center align-items-center flex-column">
        <form class="login" action="app/class/editClass.php" method="POST">
            <div class="text-center">
                <img src="img/yavuzlar.png"
                     width="100">
            </div>
            <h3>EDIT CLASS</h3>
            
            <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-info" role="alert">
              <?=$_GET['error']?>
            </div>
            <?php } ?>

       
          
          <div class="mb-3">
            <label class="form-label">Class Name</label>
            <input type="text" class="form-control" name="class_name" value="<?php echo "$class_name" ?>" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Teacher Id</label>
            <select class="form-control" name="teacher_id">
                <?php if ($_SESSION['role'] !== "teacher") { ?>
                    <option value="0" selected>Select Teacher</option>
                <?php } ?>
                <?php foreach ($unassigned_classes as $teacher) { 
                    $teacher_id = $teacher['id'];
                    $teacher_name = $teacher['name'] . ' ' . $teacher['surname'];
                ?>
                    <option value="<?= $teacher_id ?>"><?= $teacher_name ?></option>
                <?php } ?>
            </select>
          </div>

          <!-- Hidden id submit to app/class/editClass.php -->
          <input type="hidden" name="id" value="<?=$id?>">

          <button type="submit" class="btn btn-primary">Edit</button>
          <a href="home.php" class="btn btn-secondary" role="button" >Home</a>
        </form>
        
       
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>    
</body>
</html>

<?php 
session_start();
include "conn.php";
if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === "admin") {
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
                    <img class="col-md-2 mx-2" src="img/yavuzlar.png">
                    <h4 class="col-md-10 mt-4">Users List</h4>
                </div>
                <p>
                    Add New User <a href="addUserIndex.php" class="btn btn-info" role="button" >ADD</a>
                </p>
            </section>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger d-flex justify-content-center align-items-center" role="alert">
                    <?=$_GET['error']?>
                </div>
            <?php } ?>
            <section id="listUser" class="d-flex justify-content-center align-items-center flex-column">
                <div class="card mb-3 card-1">
                    <div class="row g-0">
                        <div class="col-md-12">
                            <div class="table-wrap">
                                <label class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3" for="filter">Filter by Role:</label>
                                <select id="filter" class="p-1 text-primary-emphasis border border-primary-subtle rounded-3" style=" background-color : #78cc8e;">
                                    <option value="all">All</option>
                                    <option value="admin">Admin</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="student">Student</option>
                                </select>
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Surname</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $usersTable = "t_users";
                                        $school = $conn->prepare("SELECT * FROM $usersTable ORDER BY id DESC");
                                        $school->execute();
                                        $users = $school->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($users as $user) { 
                                            echo '
                                            <tr class="alert" role="alert" data-filter="'.$user["role"].'">
                                                <th scope="row">'.$user["id"].'</th>
                                                <td>'.$user["name"].'</td>
                                                <td>'.$user["surname"].'</td>
                                                <td>'.$user["username"].'</td>
                                                <td>'.$user["role"].'</td> 
                                                <td>
                                                    <a href="editUserIndex.php?id='. $user["id"] .'" class="btn btn-block btn-warning">Edit</a>
                                                </td>
                                                <td>
                                                    <a href="app/user/deleteUser.php?id='. $user["id"] .'" class="btn btn-block btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            ';
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

<?php }else {
	header("Location: login.php");
	exit;
} ?>
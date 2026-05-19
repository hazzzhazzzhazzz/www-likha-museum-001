<?php
    
    session_start();
    require_once '../../BusinessLogic/AdminUserManagement.php';
    
    $userManagement = new AdminUserManagement();
    $users = $userManagement -> getUser();
    $tableUsers = array_map(function ($user) {
        unset($user['Password']);
        return $user;
    }, $users);

    //Login Page

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--AJAX--><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!--Sweet Alert 2--><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Materialize CSS--><!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">-->
    <!--Materialize JS--><!--<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>-->
    <!--Bootstrap CSS--><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!--Bootstrap JS--><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!--Materialize Icons--><!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <!--Bootstrap Icons--><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!--DataTables Bootstrap 5--><link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.css" />
    <!--DataTables Core--><script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
    <!--DataTables Bootstrap 5--><script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.js"></script>
    <!--Animate CSS--><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!--CSS in CSS Folder--><link rel="stylesheet" href="../../CSS/ProjectStyle.css">

    <link rel="icon" type="image/png" href="../../Multimedia/Images/Likha-Museum-Icon.png">

    <title>Login</title>
</head>

<body class="Login-Page">
    
    <div class="HeaderBorder">
        <h1 class="title">Login</h1>
    </div>

    <div class="BodyBorder">

        <div class="InputFields col s12 m12 l12">
                
            <div class="row">
                <form>
                    
                    <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="loginEmail" placeholder="Email" required>
                                    <label for="loginEmail">Email</label>
                                </div>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="loginPassword" placeholder="Password" required>
                                <label for="loginPassword">Enter Password</span></label>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div>
                <button class="btn btn-to-dashboard" style="width:100%" title="Login" onclick="loginFunc()" type="button"><i class="bi bi-person-fill-add"></i> Login</button>
            </div>

        </div>

    <script src="../../Scripts/AdminService.js"></script>

</body>

</html>
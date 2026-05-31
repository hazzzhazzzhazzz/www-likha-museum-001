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

<body class="Login-Page p-0 m-0">
    
    <div class="container-fluid p-0">
        <div class="row g-0 vh-100 align-items-stretch">
            
            <div class="col-md-6 d-none d-md-flex flex-column justify-content-between p-5 position-relative text-start">
                <div class="logo-area">
                    <img src="../../Multimedia/Images/Likha-Museum-Logo-Transparent.png" alt="Museum Icon" class="logo">
                </div>
                
                <div class="headline-area my-auto">
                    <h1 class="title text-start mb-2" style="font-size: 3.5rem;">LIKHA ART <br>MUSEUM</h1>
                    <p class="fs-5 text-dark-50 ms-1" style="font-family: 'Playfair-Display', serif;">Experience human expression reimagined.</p>
                </div>
                
                <div class="footer-area small opacity-75" style="font-family: 'Roboto', sans-serif;">
                    © 2026 Likha Museum. All rights reserved.
                </div>
            </div>

            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center bg-white p-4 p-md-5">
                <div class="w-100" style="max-width: 440px;">
                    
                    <h2 class="fw-bold mb-1 text-dark" style="font-family: 'Playfair-Display', serif; font-size: 2.2rem; letter-spacing: 0.5px;">LOGIN</h2>
                    <p class="text-muted mb-4 small" style="font-family: 'Roboto', sans-serif;">Login with your email address below</p>

                    <form>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="lEmail" placeholder="Email" required autocomplete="email">
                            <label for="lEmail">Email</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="lPassword" placeholder="Password" required autocomplete="current-password">
                            <label for="lPassword">Enter Password</label>
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-standard w-100 py-3" title="Login" onclick="loginFunc()" type="button">
                                <i class="bi bi-person-fill-add me-2"></i>Login
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4" style="font-family: 'Roboto', sans-serif;">    
                        <p class="text-muted small">
                            Don't have an account? <a class="redirectLink" onclick="redirectFunc(3)">Sign up</a>
                        </p>
                    </div>


                </div>
            </div>

        </div>
    </div>

    <script src="../../Scripts/AdminService.js"></script>
</body>
</html>
<?php
    session_start();
    require_once '../../BusinessLogic/AdminUserManagement.php';
    
    $userManagement = new AdminUserManagement();
    $users = $userManagement -> getUser();
    $departments = $userManagement -> getDepartments();
    $tableUsers = array_map(function ($user) {
        unset($user['Password']);
        return $user;
    }, $users);

    //RegistrationPage.php
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

    <title>Registration Page</title>

</head>

<body class="Registration-Page">

    <div class="container-fluid p-0">
        <div class="row g-0 split-container">
            
            <div class="col-md-5 branding-side d-none d-md-flex text-start">
                <div class="logo-area">
                    <img src="../../Multimedia/Images/Likha-Museum-Logo-Transparent.png" alt="Likha Museum Logo" class="logo">
                </div>
                <div class="headline-area my-auto">
                    <h1 class="title text-start mb-2">Registration</h1>
                    <p class="fs-5 text-dark-50" style="font-family: 'Playfair-Display', serif;">Join the Likha Art Museum Administration team.</p>
                </div>
                <div class="footer-area small text-muted" style="font-family: 'Roboto', sans-serif;">
                    © 2026 Likha Museum. All rights reserved.
                </div>
            </div>

            <div class="col-12 col-md-7 form-side">
                <div class="form-content-scroll">
                    
                    <h2 class="fw-bold mb-1 text-dark" style="font-family: 'Playfair-Display', serif; font-size: 2rem;">CREATE ACCOUNT</h2>
                    <p class="text-muted mb-4 small" style="font-family: 'Roboto', sans-serif;">Fill out the details below to set up a new profile.</p>

                    <form>
                        
                        <fieldset>
                            <legend class="AdminRegistrationLegend fs-5 mb-3">User Information</legend>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="txtFirstName" placeholder="First Name" maxlength="99" title="Enter a first name" required>
                                        <label for="txtFirstName">First Name<span class="requiredAskterisk">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="txtMiddleName" placeholder="Middle Name" maxlength="99" title="Enter a middle name" required>
                                        <label for="txtMiddleName">Middle Name<span class="requiredAskterisk">*</span></label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="txtLastName" placeholder="Last Name" maxlength="99" title="Enter a last name" required>
                                        <label for="txtLastName">Last Name<span class="requiredAskterisk">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="dateBirthDate" placeholder="Birth Date" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" title="Enter a birth date" required>
                                        <label for="dateBirthDate">Birth Date<span class="requiredAskterisk">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <select class="form-select py-3" id="selDepartment" aria-label="Department Selection" style="height: calc(3.5rem + 2px);">
                                        <option selected disabled>Select Department*</option>
                                        <?php foreach($departments as $department): ?>
                                            <option value="<?= (int) $department['Department_ID'] ?>"><?= htmlspecialchars($department['DepartmentName']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="AdminRegistrationLegend fs-5 mb-3">Contacts Information</legend>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="txtEmail" placeholder="Email" maxlength="149" title="Enter an email address" required>
                                        <label for="txtEmail">Email<span class="requiredAskterisk">*</span></label>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-3">
                                    <div class="form-floating">
                                        <input class="form-control text-center text-muted" type="text" value="+63" aria-label="Country Code" disabled style="padding-top: 1.625rem;">
                                        <label>Country Code</label>
                                    </div>
                                </div>
                                <div class="col-8 col-sm-9">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="txtContactNumber" placeholder="Contact Number" maxlength="9" title="Enter a contact number" required>
                                        <label for="txtContactNumber">Contact Number<span class="requiredAskterisk">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="AdminRegistrationLegend fs-5 mb-3">Create Password</legend>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="hiddenSetPassword" placeholder="Set Password" maxlength="254" title="Set up a password" required>
                                        <label for="hiddenSetPassword">Set Password<span class="requiredAskterisk">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="hiddenConfirmPassword" placeholder="Confirm Password" maxlength="254" title="Confirm your password" required>
                                        <label for="hiddenConfirmPassword">Confirm Password<span class="requiredAskterisk">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="mt-4">
                            <hr class="flex-grow-1 m-0 opacity-25">
                            <button class="btn btn-standard w-100" onclick="addFunc()" type="button">
                                <i class="bi bi-person-fill-add me-2"></i> Register
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4" style="font-family: 'Roboto', sans-serif;">
                        <p class="text-muted small mb-1">
                            By registering you agree with our <a href="#" class="text-decoration-none text-dark fw-semibold">Terms and Conditions</a>
                        </p>

                        <?php if(!empty($tableUsers)): ?> <!-- This only shows up kapag may users sa table -->
                            <p class="text-muted small">
                                Already have an account? <a class="redirectLink" onclick="redirectFunc(1)">Log in</a>
                            </p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="../../Scripts/AdminService.js"></script>
</body>
</html>
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

    <?php if(!empty($tableUsers)): ?>
        <a class="btn btn-login" onclick="redirectFunc(1)"><i class="bi bi-person-badge"></i> Log in</a>
    <?php endif; ?>

    <div class="HeaderBorder">
        <!--<img src="../../Multimedia/Images/Likha-Museum-Logo.png" alt="Likha Museum Logo" class="logo">-->
        <h1 class="title">Registration Page</h1>
    </div>

    <div class="BodyBorder">

        <div class="InputFields col s12 m12 l12">
                
            <div class="row">
                <form>
                    <fieldset>
                        <legend class="AdminRegistrationLegend">User Information</legend>
                    
                    
                    <div class="row">
                        <div class="col s6 m6 l6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="txtFirstName" placeholder="First Name" maxlength="99" title="Enter a first name" required>
                                <label for="txtFirstName">First Name<span class="requiredAskterisk">*</span></label>
                            </div>
                        </div>

                        <div class="col s6 m6 l6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="txtMiddleName" placeholder="Middle Name" maxlength="99" title="Enter a middle name" required>
                                <label for="txtMiddleName">Middle Name<span class="requiredAskterisk">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="txtLastName" placeholder="Last Name" maxlength="99" title="Enter a last name" required>
                                <label for="txtLastName">Last Name<span class="requiredAskterisk">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <select class="form-select form-select-sm" id="selDepartment" aria-label=".form-select-sm example">
                                <option selected disabled>Select Department*</option>
                            <?php foreach($departments as $department): ?>
                                <option value="<?= (int) $department['Department_ID'] ?>"><?= htmlspecialchars($department['DepartmentName']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <br/>

                    

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="dateBirthDate" placeholder="Birth Date" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" title="Enter a birth date" required>
                                <label for="dateBirthDate">Birth Date<span class="requiredAskterisk">*</span></label>
                            </div>
                        </div>
                    </div>
                    
                    </fieldset>

                    <fieldset>
                        <legend class="AdminRegistrationLegend">Contacts Information</legend>

                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="txtEmail" placeholder="Email" maxlength="149" title="Enter an email address" required>
                                    <label for="txtEmail">Email<span class="requiredAskterisk">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="text" placeholder="Disabled input" aria-label="Disabled input example" disabled>
                                    <label>+63</label>
                                </div>
                            </div>

                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="txtContactNumber" placeholder="Contact Number" maxlength="9" title="Enter a contact number" required>
                                    <label for="txtContactNumber">Contact Number<span class="requiredAskterisk">*</span></label>
                                </div>
                            </div>
                        </div>

                    </fieldset>

                    <fieldset>
                        <legend class="AdminRegistrationLegend">Create Password</legend>

                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="hiddenSetPassword" placeholder="Set Password" maxlength="254" title="Set up a password" required>
                                    <label for="hiddenSetPassword">Set Password<span class="requiredAskterisk">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="hiddenConfirmPassword" placeholder="Confirm Password" maxlength="254" title="Confirm your password" required>
                                    <label for="hiddenConfirmPassword">Confirm Password<span class="requiredAskterisk">*</span></label>
                                </div>
                            </div>
                        </div>

                    </fieldset>

                </form>
                </div>
                
                <div>
                    <button class="btn btn-add" style="width:100%" title="Add a new user." onclick="addFunc()" type="button"><i class="bi bi-person-fill-add"></i> Add</button>
                </div>

        </div>

    </div>


    
    

    <script src="../../Scripts/AdminService.js"></script>

</body>
</html>
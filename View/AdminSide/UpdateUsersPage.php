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

    // Get user ID from URL parameter
    $selectedUser = null;
    if(isset($_GET['userID']) && !empty($_GET['userID'])) {
        $userID = (int)$_GET['userID'];
        foreach($users as $user) {
            if($user['Employee_ID'] == $userID) {
                $selectedUser = $user;
                break;
            }
        }
    }

    // Convert selected user to JSON for JavaScript
    $selectedUserJSON = json_encode($selectedUser);

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

    <title>Update Users Page</title>
    
</head>

<body class="Update-Users-Page">


    <div class="HeaderBorder">
        <h1 class="title">Update Information</h1>
    </div>

    <div class="BodyBorder">

        <div class="InputFields col s12 m12 l12">
                
            <div class="row">
                <form>
                    <fieldset>
                        <legend>User Information</legend>
                    
                    
                    <div class="row">
                        <div class="col s6 m6 l6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="txtFirstName" maxlength="99" placeholder="First Name" required>
                                <label for="txtFirstName">First Name<span class="requiredAskterisk">*</span></label>
                            </div>
                        </div>

                        <div class="col s6 m6 l6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="txtMiddleName" maxlength="99" placeholder="Middle Name" required>
                                <label for="txtMiddleName">Middle Name<span class="requiredAskterisk">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="txtLastName" maxlength="99" placeholder="Last Name" required>
                                <label for="txtLastName">Last Name<span class="requiredAskterisk">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="txtUserID" placeholder="User ID" required hidden>
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
                                <input type="date" class="form-control" id="dateBirthDate" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" placeholder="Birth Date" required>
                                <label for="dateBirthDate">Birth Date<span class="requiredAskterisk">*</span></label>
                            </div>
                        </div>
                    </div>
                    
                    </fieldset>

                    <fieldset>
                        <legend>Contacts Information</legend>

                            <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="txtEmail" maxlength="149" placeholder="Email" required>
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
                                    <input type="text" class="form-control" id="txtContactNumber" maxlength="9" placeholder="Contact Number" required>
                                    <label for="txtContactNumber">Contact Number<span class="requiredAskterisk">*</span></label>
                                </div>
                            </div>
                        </div>

                    </fieldset>

                    <fieldset>
                        <legend>Change Password</legend>

                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="hiddenSetPassword" maxlength="254" placeholder="Update Password" required>
                                    <label for="hiddenSetPassword">Update Password<span class="requiredAskterisk">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="hiddenConfirmPassword" maxlength="254" placeholder="Confirm Password" required>
                                    <label for="hiddenConfirmPassword">Confirm Password<span class="requiredAskterisk">*</span></label>
                                </div>
                            </div>
                        </div>

                    </fieldset>

                </form>
                </div>
                
                <div>
                    <button class="btn btn-standard" style="width:100%" title="Update user." onclick="updateFunc(document.getElementById('txtUserID').value)" type="button"><i class="bi bi-pencil-square"></i> Update</button>
                </div>

            </div>

        </div>
    </div>

    <script>
        const selectedUser = <?= $selectedUserJSON ?: 'null' ?>;

        document.addEventListener('DOMContentLoaded', function () {
            if (!selectedUser) {
                return;
            }

            const setValue = function (id, value) {
                const element = document.getElementById(id);
                if (element) {
                    element.value = value ?? '';
                }
            };

            setValue('txtUserID', selectedUser.Employee_ID);
            setValue('txtFirstName', selectedUser.FirstName);
            setValue('txtMiddleName', selectedUser.MiddleName);
            setValue('txtLastName', selectedUser.LastName);
            setValue('txtEmail', selectedUser.Email);
            setValue('txtContactNumber', selectedUser.ContactNumber);
            setValue('dateBirthDate', selectedUser.BirthDate);
            setValue('selDepartment', selectedUser.Department_Id);
        });
    </script>
    <script src="../../Scripts/AdminService.js"></script>

</body>
</html>
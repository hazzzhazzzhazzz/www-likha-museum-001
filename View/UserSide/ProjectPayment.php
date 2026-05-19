<!-- ?php
    require_once '../../BusinessLogic/CustomerUserManagement.php';
    
    $userManagement = new CustomerUserManagement();
    $customerTypes = $userManagement->getCustomers() ?? [];
? -->

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
    <!--CSS in CSS Folder--><link rel="stylesheet" href="../../CSS/ProjectStyle.css">
    
    <link rel="icon" type="image/png" href="../../Multimedia/Images/Likha-Museum-Icon.png">

    <title>Payment | Likha Museum</title>

</head>

<body>

    <nav>
        <ul>
            <li><a href="ProjectHomePage.php"><img src="../../Multimedia/Images/Likha-Museum-Logo.png" alt="Likha Museum Logo" class="logo"></a></li>
            <li><a href="ProjectHomePage.php"></a></li>
            <li><a href="ProjectExhibits.php"></a></li>
            <li><a href="ProjectEvents.php"></a></li>
            <li><a href="ProjectVisitPage.php"></a></li>
            <li><a href="ProjectContacts.php"></a></li>
        </ul>
    </nav>
    
    <section class="opening-hours-section">
        <h1 class="opening-hours-title">Opening Hours</h1>
        <p class="opening-hours-text">
            Monday to Sunday: 9:00 AM - 7:00 PM<br>
            Last Admission: 6:30 PM
        </p>
    </section>

    <section class="opening-hours-section">
        <form>
            <fieldset>
                        <legend class="CustomerRegistrationLegend">User Information</legend>
                    
                    <div class="row">

                        <select class="form-select form-select-sm" id="selCustomerType" aria-label=".form-select-sm example">
                                <option selected disabled>Select Customer Type*</option>
                            <!--< ?php foreach($customerTypes as $customerType): ?>
                                <option value="< ?= (int) $customerType['CustomerType_ID'] ?>">< ?= htmlspecialchars($customerType['TypeName']) ?></option>
                            < ?php endforeach; ?>-->
                        </select>
                    </div>
                    <br/>
                    
                    
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
                        <div class="col s12 m12 l12">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="dateBirthDate" placeholder="Birth Date" title="Enter a birth date" required>
                                <label for="dateBirthDate">Birth Date<span class="requiredAskterisk">*</span></label>
                            </div>
                        </div>
                    </div>
                    
                    </fieldset>

                    <fieldset>
                        <legend class="CustomerRegistrationLegend">Contacts Information</legend>

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
                        <legend class="CustomerRegistrationLegend">Scheduled Date</legend>

                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="dateScheduledDate" placeholder="Scheduled Date" title="Enter a scheduled date" required>
                                    <label for="dateScheduledDate">Scheduled Date<span class="requiredAskterisk">*</span></label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="row" style="margin-top: 20px;">
                        <div class="col s12 m12 l12">
                            <button type="button" class="btn btn-primary" onclick="addFunc()" style="width: 100%;">Book Your Visit</button>
                        </div>
                    </div>
        </form>
    </section>
    <script src="../../Scripts/CustomerService.js"></script>
</body>
</html>
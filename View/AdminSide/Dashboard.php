<?php
    
    session_start();
    require_once '../../BusinessLogic/AdminUserManagement.php';
    //kailangan ng user management because of the table
    
    $userManagement = new AdminUserManagement();
    $users = $userManagement -> getUser();
    $departments = $userManagement -> getAllDepartments();
    $departmentsmonth = $userManagement -> getMonthCreated();
    $departmentsCurrMonthLogins = $userManagement -> getAdminLoginsCurrentMonth();
    $departmentsAllMonthLogins = $userManagement -> getAdminLoginsMonths();

    $tableUsers = array_map(function ($user) {
        unset($user['Password']);
        return $user;
    }, $users);

    $totalEmp = $userManagement -> getAllTotalEmployees();
    $totalDept = $userManagement -> getAllTotalDepartments();
    $currMonthLogins = $userManagement -> getAdminLoginsCurrentMonth();

    $labels = array_column($departments, 'DepartmentName');
    $data = array_column($departments, 'TotalDepartments');

    $monthLabels = array_column($departmentsmonth, 'MonthJoined');
    $monthData = array_column($departmentsmonth, 'NumberofEmployees');

    $allMonthLoginsLabels = array_column($departmentsAllMonthLogins, 'LastLoginDate');
    $allMonthLoginsData = array_column($departmentsAllMonthLogins, 'NumberofEmployees');

    //Dashboard.php

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

    <title>Dashboard</title>
</head>

<body class="Dashboard-Page">

    <a class="btn btn-logout" onclick="logoutFunc()"><i class="bi bi-door-open-fill"></i> Log out</a>
    


    <div class="dashboard-container">
        <header class="dashboard-header">
            <div><a href="Dashboard.php"><img src="../../Multimedia/Images/Likha-Museum-Logo.png" alt="Likha Museum Logo" class="logo"></a></div>
            <h1 class="title">Data Dashboard</h1>
        <div class="live-timestamp"><p id="currentDate"></p><p id="currentTime"></p></div>
        </header>

        <section class="main-chart-card">
            <div class="line-graph-wrapper">
                <h3>Employee Logins Month</h3><canvas id="EmployeeLineChart"></canvas>
            </div>
        </section>

        <div class="bottom-grid">
            <article class="card column-chart">Numbers of Employees per Department<canvas id="EmployeeBarChart"></canvas></article>
            <article class="card column-chart">Employees Joined Per Month<canvas id="EmployeePieChart"></canvas></article>
            
            <div class="metrics-sidebar">
                <div class="kpi-card">Total Departments: <?= $totalDept['TotalDepartments'] /*alias ng column from query*/ ?></div>
                <div class="kpi-card">Total Employees: <?= $totalEmp['TotalEmployees'] /*alias ng column from query*/ ?></div>
                <div class="kpi-card">Logs This Month: <?= $currMonthLogins['NumberofEmployees'] /*alias ng column from query*/ ?></div>
                <div class="kpi-card">Title: 0</div>
            </div>
        </div>
    </div>
    
    <div class="TableField" id="Tables">

        <table id="myTable" class="table table-striped table-hover align-middle">

            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Department</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Birthdate</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if(!empty($tableUsers)): ?>
                <?php foreach($tableUsers as $index => $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['Employee_ID']) ?></td>
                    <td><?= htmlspecialchars($user['Department']) ?></td>
                    <td><?= htmlspecialchars($user['FirstName']) ?></td>
                    <td><?= htmlspecialchars($user['MiddleName']) ?></td>
                    <td><?= htmlspecialchars($user['LastName']) ?></td>
                    <td><?= htmlspecialchars($user['Email']) ?></td>
                    <td><?= '+63 ' . htmlspecialchars($user['ContactNumber']) ?></td> <!--hindi pinakita ang +63 sa database pero may concat siya here-->
                    <td><?= htmlspecialchars($user['BirthDate']) ?></td>

                    <td>
                        <button type="button" class="btn btn-update" title="Update this user." onclick="redirectFunc(4, <?= (int) $user['Employee_ID'] ?>)"><i class="bi bi-pencil-square"></i></button>
                        <button type="button" class="btn btn-delete" title="Delete this user." onclick="deleteFunc(<?= (int) $user['Employee_ID'] ?>)"><i class="bi bi-person-x"></i></button>
                    </td>

                </tr>

                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

            

        </table>

    </div>
    
    <script>
        window.EmployeeBarChart = {
            labels: <?= json_encode($labels) ?>,
            data: <?= json_encode($data) ?>
        }

        window.EmployeePieChart = {
            labels: <?= json_encode($monthLabels) ?>,
            data: <?= json_encode($monthData) ?>
        }

        window.EmployeeLineChart = {
            labels: <?= json_encode($allMonthLoginsLabels) ?>,
            data: <?= json_encode($allMonthLoginsData) ?>
        }
    </script>

    <!--Chartjs CDN--><script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../Scripts/AdminService.js"></script>

</body>
</html>
<?php

    class AdminRegistration {

        private $conn;
        public function __construct($db)
        {
            $this -> conn = $db;
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        
        public function createRegistration($firstName, $middleName, $lastName, $email, $contactNumber, $birthDate, $password, $departmentID) {
            
            $dateNow = date("Y-m-d H:i:s");

            $this -> conn -> beginTransaction();

            try {

            $query_tblEmployees = "INSERT INTO tbl_employees (Department_Id, FirstName, MiddleName, LastName, Email, ContactNumber, BirthDate, createdAt, updatedAt) 
            VALUES (:departmentID, :firstName, :middleName, :lastName, :email, :contactNumber, :birthDate, :createdAt, :updatedAt)";

            $response_tblEmployees = $this -> conn -> prepare($query_tblEmployees);

            $response_tblEmployees -> bindParam(':departmentID', $departmentID);
            $response_tblEmployees -> bindParam(':firstName', $firstName);
            $response_tblEmployees -> bindParam(':middleName', $middleName);
            $response_tblEmployees -> bindParam(':lastName', $lastName);
            $response_tblEmployees -> bindParam(':email', $email);
            $response_tblEmployees -> bindParam(':contactNumber', $contactNumber);
            $response_tblEmployees -> bindParam(':birthDate', $birthDate);
            $response_tblEmployees -> bindParam(':createdAt', $dateNow);
            $response_tblEmployees -> bindParam(':updatedAt', $dateNow);

            $response_tblEmployees -> execute();

            $employeeID = $this -> conn -> lastInsertId();


            $passwordHash = password_hash($password, PASSWORD_ARGON2ID);

            $query_tblAdminDetails = "INSERT INTO tbl_admindetails (Employee_ID, PasswordHash, createdAt, updatedAt) 
            VALUES (:employeeID, :passwordHash, :createdAt, :updatedAt)";

            $response_tblAdminDetails = $this -> conn -> prepare($query_tblAdminDetails);

            $response_tblAdminDetails -> bindParam(':employeeID', $employeeID);
            $response_tblAdminDetails -> bindParam(':passwordHash', $passwordHash);
            $response_tblAdminDetails -> bindParam(':createdAt', $dateNow);
            $response_tblAdminDetails -> bindParam(':updatedAt', $dateNow);

            $response_tblAdminDetails -> execute();
            $adminID = $this -> conn -> lastInsertId();


            $query_tblAdminLoginHistory = "INSERT INTO tbl_adminloginhistory (Admin_ID, LastLogin)
            VALUES (:adminID, :lastLogin)";

            $response_tblAdminLoginHistory = $this -> conn -> prepare($query_tblAdminLoginHistory);

            // Use the inserted admin primary key to satisfy FK constraints in login history.
            $response_tblAdminLoginHistory -> bindParam(':adminID', $adminID);
            $response_tblAdminLoginHistory -> bindParam(':lastLogin', $dateNow);

            $response_tblAdminLoginHistory -> execute();

            $this -> conn -> commit();
            return true;

            }
            catch (PDOException $ex) {
                if ($this -> conn -> inTransaction()) {
                    $this -> conn -> rollBack();
                }

                throw $ex;
            }

        }
        

        public function readRegistration() {
            
                /***
                    Bakit LEFT JOIN?
                    
                    because ang mentioned sa schema video na may na-combine na same column with left join to 
                    mawala ang error and ang relation is 
                    An employee may or may not be admins, but admins are not allowed to exist without employee details. 
                    Kaya LEFT JOIN para makuha lahat admin details AND employee details.
                ***/

            $query = "SELECT e.*, d.DepartmentName AS Department
                  FROM tbl_employees e
                  LEFT JOIN tbl_departments d ON d.Department_ID = e.Department_Id";

            /***
                Bale ang left table is tbl_employees kasi dito nakalagay lahat ng employee details, 
                at ang right table is tbl_departments kasi dito nakalagay yung department name na gusto nating i-display sa result set.
            ***/
            
            $response = $this -> conn -> prepare($query);
            
            $response -> execute();
            
            return $response;
         }

          public function readDepartments() {
              $query = "SELECT Department_ID, DepartmentName FROM tbl_departments ORDER BY DepartmentName ASC";
              $response = $this -> conn -> prepare($query);
              $response -> execute();
              return $response;
          }

            public function updateRegistration($firstName, $middleName, $lastName, $email, $contactNumber, $birthDate, $employeeID, $departmentID, $password = null) {
            $this -> conn -> beginTransaction();

            try {
                    $query_tblEmployees = "UPDATE tbl_employees SET Department_Id = :departmentID, FirstName = :firstName, MiddleName = :middleName, LastName = :lastName, Email = :email, 
                    ContactNumber = :contactNumber, BirthDate = :birthDate, updatedAt = :updatedAt WHERE Employee_ID = :employeeID";

                    $response_tblEmployees = $this -> conn -> prepare($query_tblEmployees);

                    $dateNow = date("Y-m-d H:i:s");
                    
                    $response_tblEmployees->bindParam(':departmentID', $departmentID);
                    $response_tblEmployees -> bindParam(':firstName', $firstName);
                    $response_tblEmployees -> bindParam(':middleName', $middleName);
                    $response_tblEmployees -> bindParam(':lastName', $lastName);
                    $response_tblEmployees -> bindParam(':email', $email);
                    $response_tblEmployees -> bindParam(':contactNumber', $contactNumber);
                    $response_tblEmployees -> bindParam(':birthDate', $birthDate);
                    $response_tblEmployees -> bindParam(':updatedAt', $dateNow);
                    $response_tblEmployees -> bindParam(':employeeID', $employeeID);

                    $response_tblEmployees -> execute();

                    if (!empty($password)) {
                        $query_tblAdminDetails = "UPDATE tbl_admindetails SET PasswordHash = :passwordHash, updatedAt = :updatedAt WHERE Employee_ID = :employeeID";
                        $response_tblAdminDetails = $this -> conn -> prepare($query_tblAdminDetails);
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                        $response_tblAdminDetails -> bindParam(':passwordHash', $passwordHash);
                        $response_tblAdminDetails -> bindParam(':updatedAt', $dateNow);
                        $response_tblAdminDetails -> bindParam(':employeeID', $employeeID);
                        $response_tblAdminDetails -> execute();
                    }

                    $this -> conn -> commit();
                    return true;
                }
                catch (PDOException $ex) {
                    if ($this -> conn -> inTransaction()) {
                        $this -> conn -> rollBack();
                    }

                    throw $ex;
                }

            }

         /***
            galing sa lesson ni sir pero nilagyan ko ng transaction handling at error handling gamit ang try catch block
            kasi nag-normalized na tayo kaya may mga $query_tblAdminLoginHistory etc. 
            instead na $query lang
         ***/
         public function deleteRegistration($employeeID) {
            $this -> conn -> beginTransaction();

            try {
                    $query_tblAdminLoginHistory = "DELETE FROM tbl_adminloginhistory WHERE Admin_ID IN (SELECT Admin_ID FROM tbl_admindetails WHERE Employee_ID = :employeeID)";
                    $response_tblAdminLoginHistory = $this -> conn -> prepare($query_tblAdminLoginHistory);
                    $response_tblAdminLoginHistory -> bindParam(':employeeID', $employeeID);
                    $response_tblAdminLoginHistory -> execute();

                    $query_tblAdminDetails = "DELETE FROM tbl_admindetails WHERE Employee_ID = :employeeID";
                    $response_tblAdminDetails = $this -> conn -> prepare($query_tblAdminDetails);
                    $response_tblAdminDetails -> bindParam(':employeeID', $employeeID);
                    $response_tblAdminDetails -> execute();

                    $query_tblEmployees = "DELETE FROM tbl_employees WHERE Employee_ID = :employeeID";
                    $response_tblEmployees = $this -> conn -> prepare($query_tblEmployees);
                    $response_tblEmployees -> bindParam(':employeeID', $employeeID);
                    $response_tblEmployees -> execute();

                    $this -> conn -> commit();
                    return true;
                }
                catch (PDOException $ex) {
                    if ($this -> conn -> inTransaction()) {
                        $this -> conn -> rollBack();
                    }

                    throw $ex;
                }

         }

         //kukunin ang email from tbl_employees at password hash from tbl_admindetails para sa login verification
         public function getAdminByEmail($email) {
              $query = 
              "SELECT e.Employee_ID, e.Department_Id, e.FirstName, e.MiddleName, e.LastName, e.Email, a.PasswordHash
                FROM tbl_employees e
                INNER JOIN tbl_admindetails a ON a.Employee_ID = e.Employee_ID
                WHERE e.Email = :email
                LIMIT 1"; //isang email because common sense na isang email lang ang mag-login
                
                /***
                    Bakit INNER JOIN?  
                    
                    basically tbl_employees has zero or one tbl_AdminDetails and
                    tbl_admindetails has exactly one tbl_employees.
                    Kaya nag-INNER JOIN because dito titingan kung may matching email sa tbl_employees 
                    at kukunin yung corresponding password hash sa tbl_admindetails.
                ***/
              
              $response = $this -> conn -> prepare($query);
              $response -> bindParam(':email', $email);
              $response -> execute();

              return $response -> fetch(PDO::FETCH_ASSOC);
          }

          public function DepartmentEmployeeCount () {
            $query = "SELECT d.DepartmentName AS DepartmentName, COUNT(e.Employee_ID) AS TotalDepartments FROM tbl_departments d LEFT JOIN tbl_employees e ON e.Department_ID = d.Department_ID GROUP BY d.DepartmentName";
            $response = $this -> conn -> prepare($query);
            $response -> execute();
            return $response;
          }

          public function EmployeeMonthCreatedAcc() {
            $query = "SELECT MONTHNAME(createdAt) AS MonthJoined, COUNT(Employee_ID) AS NumberofEmployees FROM tbl_employees GROUP BY MonthJoined ORDER BY MONTH(createdAt) ASC";
            $response = $this -> conn -> prepare($query);
            $response -> execute();
            return $response;
          }

          public function LastLoginsCountMonth() {
            $query = "SELECT MONTHNAME(LastLogin) AS LastLoginDate, COUNT(Admin_ID) AS NumberofEmployees FROM tbl_adminloginhistory GROUP BY LastLoginDate ORDER BY MONTH(LastLogin) ASC";
            $response = $this -> conn -> prepare($query);
            $response -> execute();
            return $response;
          }
        
          public function cardTotalDepartments() {
            $query = "SELECT COUNT(Department_ID) AS TotalDepartments FROM tbl_departments";
            $response = $this -> conn -> prepare($query);
            $response -> execute();
            return $response;
          }
        
          public function cardTotalEmployees() {
            $query = "SELECT COUNT(Employee_ID) AS TotalEmployees FROM tbl_employees";
            $response = $this -> conn -> prepare($query);
            $response -> execute();
            return $response;

        }

        public function cardLoginsCurrentMonth() {
            $query = "SELECT MONTHNAME(LastLogin) AS LastLoginDate, COUNT(Admin_ID) AS NumberofEmployees FROM tbl_adminloginhistory WHERE MONTH(LastLogin) = MONTH(CURRENT_DATE()) AND YEAR(LastLogin) = YEAR(CURRENT_DATE()) GROUP BY LastLoginDate";
            $response = $this -> conn -> prepare($query);
            $response -> execute();
            return $response;
        }

    }

    //naalala ko pa ang mga queries here sa ICS2607 SQL Workbench
    // na-enjoy ko po lwk mag-SQL queries

?>
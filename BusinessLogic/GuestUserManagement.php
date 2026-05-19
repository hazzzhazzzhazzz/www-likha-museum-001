<?php

    require_once __DIR__ . '/../Model/Admins/AdminDatabase.php';
    require_once __DIR__ . '/../Model/RegistrationModel.php';

    class AdminUserManagement {

        private $registrationModel;

        private function initializeSessionUserArray() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['userArray']) || !is_array($_SESSION['userArray'])) {
                $_SESSION['userArray'] = [];
            }
        }

        public function __construct() {
            $this -> initializeSessionUserArray();

            $database = new AdminDatabase();
            $db = $database -> connect();
            
            $this -> registrationModel = new Registration($db);
        }

        public function addUserFunc($firstName, $middleName, $lastName, $deptID, $email, $contactNumber, $birthDate, $password) {
        
            try {
                
                if($this -> registrationModel -> createRegistration($firstName, $middleName, $lastName, $email, $contactNumber,
                $birthDate, $password, $deptID)) {
                    echo "User added successfully in HeidiSQL.";
                }

                else {
                    echo "Failed to add user in HeidiSQL.";
                }

            }

            catch(InvalidArgumentException $ex) {
                
                http_response_code(500);
                echo $ex->getMessage();
                exit;
                
            }

            catch(PDOException $ex) {
                http_response_code(500);
                echo $ex->getMessage();
                exit;
            }

        }

        public function updateUserFunc($firstName, $middleName, $lastName, $userID, $email, $contactNumber, $birthDate, $password, $deptID) {
            $this -> initializeSessionUserArray();

            try {
                if ($this -> registrationModel -> updateRegistration($firstName, $middleName, $lastName, $email, $contactNumber, $birthDate, $userID, $deptID, $password)) {
                    echo "User updated successfully in HeidiSQL.";
                }

                else {
                    echo "Failed to update user in HeidiSQL.";
                }
            }
            catch(PDOException $ex) {
                http_response_code(500);
                echo $ex->getMessage();
                exit;
            }
        }

        public function deleteUserFunc($userID) {
            $this -> initializeSessionUserArray();

            try {
                if ($this -> registrationModel -> deleteRegistration($userID)) {
                    echo "User deleted successfully in HeidiSQL.";
                }

                else {
                    echo "Failed to delete user in HeidiSQL.";
                }
            }
            catch(PDOException $ex) {
                http_response_code(500);
                echo $ex->getMessage();
                exit;
            }
        }

        public function getUser(){
            $response = $this -> registrationModel -> readRegistration();
            return $response -> fetchAll(PDO::FETCH_ASSOC);
        }

        public function getDepartments() {
            $response = $this -> registrationModel -> readDepartments();
            return $response -> fetchAll(PDO::FETCH_ASSOC);
        }

        public function loginUserFunc($email, $password) {
            $this -> initializeSessionUserArray();

            $admin = $this -> registrationModel -> getAdminByEmail($email);

            if (!$admin || !isset($admin['PasswordHash'])) {
                return false;
            }

            if (!password_verify($password, $admin['PasswordHash'])) {
                return false;
            }

            $_SESSION['loggedInAdmin'] = [
                'Employee_ID' => $admin['Employee_ID'],
                'Department_Id' => $admin['Department_Id'],
                'FirstName' => $admin['FirstName'],
                'MiddleName' => $admin['MiddleName'],
                'LastName' => $admin['LastName'],
                'Email' => $admin['Email']
            ];

            return true;
        }

        public function getAllDepartments() {
            $response = $this -> registrationModel -> DepartmentEmployeeCount();
            return $response -> fetchAll(PDO::FETCH_ASSOC);
        }

        
        public function getAllTotalDepartments() {
            $response = $this -> registrationModel -> cardTotalDepartments();
            return $response -> fetch(PDO::FETCH_ASSOC);
        }

        public function getAllTotalEmployees() {
            $response = $this -> registrationModel -> cardTotalEmployees();
            return $response -> fetch(PDO::FETCH_ASSOC);
        }

    }

?>
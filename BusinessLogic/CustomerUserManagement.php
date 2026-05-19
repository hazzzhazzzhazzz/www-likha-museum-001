<?php

    require_once __DIR__ . '/../Model/Customers/CustomerDatabase.php';
    require_once __DIR__ . '/../Model/Customers/CustomerRegistrationModel.php';

// Fallback stub to satisfy static analyzers and prevent fatal error if the real
// CustomerDatabase class is not available at analysis time. At runtime the
// real class from the required file will be used when present.
if (!class_exists('CustomerDatabase')) {
    class CustomerDatabase {
        public function connect() {
            throw new Exception('CustomerDatabase class is not available.');
        }
    }
}

if (!class_exists('CustomerRegistrationModel')) {
    class CustomerRegistrationModel {
        public function __construct($db) {}
    }
}

    class CustomerUserManagement {

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

            $database = new CustomerDatabase();
            $db = $database -> connect();
            
            $this -> registrationModel = new CustomerRegistrationModel($db);
        }

        public function proceedPaymentUserFunc($firstName, $middleName, $lastName, $customerTypesID, $email, $contactNumber, $birthDate, $scheduledDate) {
        
            try {
                
                if($this -> registrationModel -> createRegistration($firstName, $middleName, $lastName, $email, $contactNumber,
                $birthDate, $customerTypesID, $scheduledDate)) {
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

        public function updateUserFunc($firstName, $middleName, $lastName, $userID, $email, $contactNumber, $birthDate, $scheduledDate, $customerTypesID) {
            $this -> initializeSessionUserArray();

            try {
                if ($this -> registrationModel -> updateRegistration($firstName, $middleName, $lastName, $email, $contactNumber, $birthDate, $userID, $customerTypesID, $scheduledDate)) {
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



        public function getCustomers() {
            $response = $this -> registrationModel -> readCustomers();
            return $response -> fetchAll(PDO::FETCH_ASSOC);
        }
/*
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
        }*/

    }

?>
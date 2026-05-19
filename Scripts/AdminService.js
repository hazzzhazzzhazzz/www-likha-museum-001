// datatables bootstrap 5
$(document).ready(function () {
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#myTable')) {
            $('#myTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100, 200],
                order: [[0, 'asc']],
                language: {
                    search: 'Search user:',
                    emptyTable: 'No users found.'
                }
            });
        }
    });
     
    /* Chart JS */
    const barCtx = document.getElementById('EmployeeBarChart');

    new Chart(barCtx, {
        type: 'bar',
        data: {
        labels: window.EmployeeBarChart.labels,
        datasets: [{
            label: '# of Employees',
            data: window.EmployeeBarChart.data,
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });


    const pieCtx = document.getElementById('EmployeePieChart');

    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: window.EmployeePieChart.labels, 
            datasets: [{
                label: 'Employees Joined',
                data: window.EmployeePieChart.data, 
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(153, 102, 255)'
                ],
                borderWidth: 1
            }]
        }
    });

    const lineCtx = document.getElementById('EmployeeLineChart');

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: window.EmployeeLineChart.labels,
            datasets: [{
                label: 'Admin Logins',
                data: window.EmployeeLineChart.data,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.3,
                pointBackgroundColor: 'rgb(255, 99, 132)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });



    /* NUMBER ONLY VALIDATION */
    const InputNumber = document.getElementById("txtContactNumber");
    if (InputNumber) {
        InputNumber.addEventListener("input", function() {
            AllowOnlyNumbers(this);
        });
    }

    function AllowOnlyNumbers(element) {
        element.value = element.value.replace(/[^0-9]/g, '');
        //hindi kana maka-type ng letters
    }


    /* MINIMUM AGE IS 18 KASI BAKIT NAMAN MAY <18 NA MAGTRABAHO? */
    const BirthDateInput = document.getElementById("dateBirthDate");
    if (BirthDateInput) {
        BirthDateInput.setAttribute("max", getMinimumBirthDateISO(18));
    }

    function getMinimumBirthDateISO(minimumAge) {
        var minimumBirthDate = new Date();
        minimumBirthDate.setFullYear(minimumBirthDate.getFullYear() - minimumAge);
        return minimumBirthDate.toISOString().split("T")[0];
    }

    initializeCurrentDateTime();

    function initializeCurrentDateTime() {
        var currentDateElement = document.getElementById("currentDate");
        var currentTimeElement = document.getElementById("currentTime");

        if (!currentDateElement && !currentTimeElement) {
            return;
        }

        function updateCurrentDateTime() {
            var now = new Date();

            if (currentDateElement) {
                currentDateElement.textContent = now.toLocaleDateString("en-PH", {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric"
                });
            }

            if (currentTimeElement) {
                currentTimeElement.textContent = now.toLocaleTimeString("en-PH", {
                    hour: "2-digit",
                    minute: "2-digit",
                    second: "2-digit"
                });
            }
        }

        updateCurrentDateTime();
        setInterval(updateCurrentDateTime, 1000);
    }

    /* PROBABLY WILL BE DELETED */
    function submitFunc() {
        var firstNameValue = document.getElementById("txtFirstName").value;
        var middleNameValue = document.getElementById("txtMiddleName").value;
        var lastNameValue = document.getElementById("txtLastName").value;
        var emailValue = document.getElementById("txtEmail").value;
        var contactNumberValue = document.getElementById("txtContactNumber").value;
        var birthDateValue = document.getElementById("dateBirthDate").value;
        var passwordValue = document.getElementById("hiddenSetPassword").value;

        $.ajax({
            url: "../../Controllers/AdminUserController.php", 
            type: "POST", 
            
            data: {
                fName: firstNameValue,
                mName: middleNameValue,
                lName: lastNameValue,
                email: emailValue,
                contactNumber: contactNumberValue, 
                birthDate: birthDateValue,
                password: passwordValue
            }, 

            success: function(returnData){
                location.reload(true);
            }, 

            error: function(xhr, status, error){
                alert("\nStatus : " + xhr.status + " Error message : " + xhr.responseText + "\n");
            }

        });

    }

    //

    /* KUNG EMPTY SILA HINDI SIYA MAG-ADD SA DATABASE */
    function validateFields() {
        var deptIDValue = document.getElementById("selDepartment").value;
        var firstNameValue = document.getElementById("txtFirstName").value.trim();
        var middleNameValue = document.getElementById("txtMiddleName").value.trim();
        var lastNameValue = document.getElementById("txtLastName").value.trim();
        var emailValue = document.getElementById("txtEmail").value.trim();
        var contactNumberValue = document.getElementById("txtContactNumber").value.trim();
        var birthDateValue = document.getElementById("dateBirthDate").value.trim();
        var passwordValue = document.getElementById("hiddenSetPassword").value.trim();
        var confirmPasswordValue = document.getElementById("hiddenConfirmPassword").value.trim();

        if (!deptIDValue || deptIDValue === "Select Department*") {
            Swal.fire({
                title: "Validation Error",
                text: "Please select a department.",
                icon: "warning",
                theme: 'bootstrap-5',
                confirmButtonText: "OK", 
                confirmButtonColor: "#3085d6", 
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }                
            });
            return false;
        }

        /* Name is <99 based on the database schema */
        if (firstNameValue.length > 99 || middleNameValue.length > 99 || lastNameValue.length > 99) {
            Swal.fire({
                title: "Validation Error",
                text: "Names must be 99 characters or less.",
                icon: "warning",
                theme: 'bootstrap-5',
                confirmButtonText: "OK", 
                confirmButtonColor: "#3085d6", 
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }
            });
            return false;
        }

        if (emailValue.length > 149) {
            Swal.fire({
                title: "Validation Error",
                text: "Email is too long.",
                icon: "warning",
                theme: 'bootstrap-5',
                confirmButtonText: "OK", 
                confirmButtonColor: "#3085d6", 
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }
            });
            return false;
        }

        if (!emailValue.includes("@") || !emailValue.includes(".") || emailValue.startsWith("@") || emailValue.endsWith("@") || emailValue.startsWith(".") || emailValue.endsWith(".")) {
            Swal.fire({
                title: "Invalid Email",
                text: "Email is not valid.",
                icon: "warning",
                theme: 'bootstrap-5',
                confirmButtonText: "OK", 
                confirmButtonColor: "#3085d6",
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }
            });
            return false;
        }

        if (contactNumberValue.length !== 9) {
            Swal.fire({
                title: "Invalid Contact Number",
                text: "Contact Number is too short or too long.",
                // 11 lahat kapag 09 or sa +63, pero kasi ang + bawal sa input, so 9 lang yung number na-insert 
                icon: "warning",
                theme: 'bootstrap-5',
                confirmButtonText: "OK",
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }
            });
            return false;
        }

        if (contactNumberValue.startsWith("0") || contactNumberValue.startsWith("1") || contactNumberValue.startsWith("2") || 
            contactNumberValue.startsWith("3") || contactNumberValue.startsWith("4") || contactNumberValue.startsWith("5") || 
            contactNumberValue.startsWith("6") || contactNumberValue.startsWith("7") || contactNumberValue.startsWith("8")) {
            Swal.fire({
                title: "Invalid Contact Number",
                text: "Contact Number must start with '9'.",
                // +63 9XX XXX XXXX yung format ng contact number 
                icon: "warning",
                theme: 'bootstrap-5',
                confirmButtonText: "OK",
                confirmButtonColor: "#3085d6", 
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }
            });
            return false;
        }

        if (passwordValue.length < 8 || passwordValue.length > 255) {
            Swal.fire({
                title: "Validation Error",
                text: "Password must be at least 8 characters long.",
                icon: "warning",
                theme: 'bootstrap-5',
                confirmButtonText: "OK",
                confirmButtonColor: "#3085d6",
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }
            });
            return false;
        }

        //bakit naman maging empty lahat mga ito? kailangan talaga ng laman lahat ng fields para makapag-add or update ng user sa database
        if (!firstNameValue || !middleNameValue || !lastNameValue || !emailValue || !contactNumberValue || !birthDateValue || !passwordValue || !confirmPasswordValue) {
            Swal.fire({
                title: "Validation Error",
                text: "All fields are required. Please fill in all fields.",
                icon: "warning",
                theme: 'bootstrap-5', 
                confirmButtonText: "OK",
                confirmButtonColor: "#3085d6", 
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }
            });
            return false;
        }

        var minimumBirthDate = new Date(getMinimumBirthDateISO(18) + "T00:00:00");
        var selectedBirthDate = new Date(birthDateValue + "T00:00:00");

        if (selectedBirthDate > minimumBirthDate) {
            Swal.fire({
                title: "Invalid Date",
                text: "User must be at least 18 years old.",
                icon: "warning",
                theme: 'bootstrap-5',
                confirmButtonText: "OK",
                confirmButtonColor: "#3085d6", 
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }
            });
            return false;
        }

        if (passwordValue !== confirmPasswordValue) {
            Swal.fire({
                title: "Password Mismatch",
                text: "Set Password and Confirm Password must match.",
                icon: "warning",
                theme: 'bootstrap-5',
                confirmButtonText: "OK",
                confirmButtonColor: "#3085d6",
                showClass: { popup: `
                    animate__animated
                    animate__headShake
                ` },
                hideClass: { popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                ` }
            });
            return false;
        }

        return true;
    }

    function addFunc(){
        if (!validateFields()) {
            return;
        }

        var deptIDValue = document.getElementById("selDepartment").value;
        var firstNameValue = document.getElementById("txtFirstName").value;
        var middleNameValue = document.getElementById("txtMiddleName").value;
        var lastNameValue = document.getElementById("txtLastName").value;
        var emailValue = document.getElementById("txtEmail").value;
        var contactNumberValue = document.getElementById("txtContactNumber").value;
        var birthDateValue = document.getElementById("dateBirthDate").value;
        var passwordValue = document.getElementById("hiddenSetPassword").value;

        $.ajax({
            
            url: "../../Controllers/AdminUserController.php", 
            type: "POST", 
            
            data: {
                fName: firstNameValue,
                mName: middleNameValue,
                lName: lastNameValue,
                deptID: deptIDValue,
                email: emailValue,
                contactNumber: contactNumberValue, 
                birthDate: birthDateValue,
                password: passwordValue

            }, 

            success: function(returnData){
                if ((returnData || '').toLowerCase().includes('successfully')) {
                    Swal.fire({
                            title: "User Created!",
                            text: "Account created successfully.",
                            theme: 'bootstrap-5',
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                                location.reload();
                        });
                }
                else {
                    Swal.fire({
                        title: "Creation Failed",
                        text: returnData || "Could not create account.",
                        icon: "error",
                        theme: 'bootstrap-5'
                    });
                }

            }, 

            error: function(xhr, status, error){
                alert("\nStatus : " + xhr.status + " Error message : " + xhr.responseText + "\n");
            }

        });

    }

    function updateFunc(userID){
        if (!validateFields()) {
            return;
        }
        
        var deptIDValue = document.getElementById("selDepartment").value;
        var firstNameValue = document.getElementById("txtFirstName").value;
        var middleNameValue = document.getElementById("txtMiddleName").value;
        var lastNameValue = document.getElementById("txtLastName").value;
        var emailValue = document.getElementById("txtEmail").value;
        var contactNumberValue = document.getElementById("txtContactNumber").value;
        var birthDateValue = document.getElementById("dateBirthDate").value;
        var passwordValue = document.getElementById("hiddenSetPassword").value;
        $.ajax({
            
            url: "../../Controllers/AdminUserController.php", 
            type: "POST", 
            
            data: {
                uFName: firstNameValue,
                uMName: middleNameValue,
                uLName: lastNameValue,
                uID : userID,
                deptID: deptIDValue,
                email: emailValue,
                contactNumber: contactNumberValue, 
                birthDate: birthDateValue,
                password: passwordValue
            }, 

            success: function(returnData){
                if ((returnData || '').toLowerCase().includes('successfully')) {
                    Swal.fire({
                            title: "User Updated!",
                            text: "Please wait for a while...",
                            icon: "info", 
                            timer: 2500,
                            theme: 'bootstrap-5', 
                            showConfirmButton: false
                        }).then(() => {
                                location.reload();
                                redirectFunc(2);
                        });
                }
                else {
                    Swal.fire({
                        title: "Update Failed",
                        text: returnData || "Could not update user.",
                        icon: "error",
                        theme: 'bootstrap-5', 
                    showClass: { popup: `
                        animate__animated
                        animate__headShake
                    ` },
                    hideClass: { popup: `
                        animate__animated
                        animate__fadeOutDown
                        animate__faster
                    ` }
                    });
                }

            }, 

            error: function(xhr, status, error){
                alert("\nStatus : " + xhr.status + " Error message : " + xhr.responseText + "\n");
            }

        });

    }

    function deleteFunc(userID){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            theme: 'bootstrap-5', 
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../Controllers/AdminUserController.php",
                    type: "POST",
                    data: {
                        dID : userID
                        //ito lang ang needed sa delete as the logic itself said na hahanapin lang ang userID index
                        //hmm sa sql like where Employee_ID = $userID?? para hindi ma-delete lahat
                    }, 

                    success: function(returnedData) {
    
                const BirthDateInput = document.getElementById("dateBirthDate");
                if (BirthDateInput) {
                    BirthDateInput.setAttribute("max", getMinimumBirthDateISO(18));
                }
                        if ((returnedData || '').toLowerCase().includes('successfully')) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "User has been deleted.",
                                icon: "success", 
                                theme: 'bootstrap-5', 
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                        else {
                            Swal.fire({
                                title: "Delete Failed",
                                text: returnedData || "Could not delete user.",
                                icon: "error",
                                theme: 'bootstrap-5'
                            });
                        }
                    },

                    error: function(xhr, status, error){
                        alert("\nStatus : " + xhr.status + " Error message : " + xhr.responseText + "\n");
                    }
                });
            }
        });
    }

    function loginFunc(){
        var emailValue = document.getElementById("loginEmail").value;
        var passwordValue = document.getElementById("loginPassword").value;

        $.ajax({
            url: "../../Controllers/AdminUserController.php",
            type: "POST",
            data: {
                lEmail: emailValue,
                lPassword: passwordValue
            },

            success: function(returnData){
                if (returnData == true) {
                    Swal.fire({
                        icon: "success",
                        title: "Login Successful!",
                        showConfirmButton: false,
                        theme: 'bootstrap-5',
                        timer: 2000
                    }).then(() => {
                        return Swal.fire({
                            title: "Loading",
                            html: "",
                            theme: 'bootstrap-5',
                            timer: 1500,
                            timerProgressBar: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    }).then(() => {
                        redirectFunc(2);
                    });
                }

                else {
                    Swal.fire({
                        title: "Login Failed!",
                        text: "Invalid credentials.",
                        icon: "error",
                        timer: 2500,
                        theme: 'bootstrap-5',
                        showConfirmButton: false, 
                        showClass: { popup: `
                            animate__animated
                            animate__headShake
                        ` },
                        hideClass: { popup: `
                            animate__animated
                            animate__fadeOutDown
                            animate__faster
                        ` }                        
                    });
                }
            },

            error: function(xhr, status, error){
                alert("\nStatus : " + xhr.status + " Error message : " + xhr.responseText + "\n");
            }
        });

    }

    function logoutFunc(){
        $.ajax({
            url: "../../Controllers/AdminUserController.php", 
            type: "POST",
            data: {
                logout: true
            },
            success: function(){
                Swal.fire({
                    icon: "success",
                    title: "Logout Successful!",
                    text: "Redirecting to the login page...",
                    showConfirmButton: false,
                    theme: 'bootstrap-5',
                    timer: 2500,
                    timerProgressBar: true
                }).then(() => {
                    redirectFunc(1);
                });
            },
            error: function(xhr, status, error){
                alert("\nStatus : " + xhr.status + " Error message : " + xhr.responseText + "\n");
            }
        });
    }

    function redirectFunc(redirectID, userID = null){
        if(redirectID === 1){
            window.location.href = "../../View/AdminSide/LoginPage.php";
        }
        
        else if(redirectID === 2){
            window.location.href = "../../View/AdminSide/Dashboard.php";
        }

        else if(redirectID === 3){
            window.location.href = "../../View/AdminSide/RegistrationPage.php";
        }

        else if(redirectID === 4){
            if(userID) {
                window.location.href = "../../View/AdminSide/UpdateUsersPage.php?userID=" + userID;
            } else {
                window.location.href = "../../View/AdminSide/UpdateUsersPage.php";
            }
        }

        else if(redirectID === 5){
            window.location.href = "../../View/AdminSide/ViewAllTablesPage.php";
        } //Hindi pa siya existing pero listahan ng lahat tables ito from the db
    
    }
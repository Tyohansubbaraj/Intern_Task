$(document).ready(function () {
    // Function to validate password format
    function validatePassword() {
        const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        let password = $("#inputPassword").val();
        if (!strongRegex.test(password)) {
            $("#password-valid-error").text("Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one number, and one special character.");
            return false;
        } else {
            $("#password-valid-error").text("");
            return true;
        }
    }

    // Function to cross-check passwords
    function crossCheckPassword() {
        let confirmPassword = $("#inputPasswordConfirm").val();
        let password = $("#inputPassword").val();
        if (password == confirmPassword) {
            $("#confirm-error-message").text("");
            return true;
        } else {
            $("#confirm-error-message").text("Passwords do not match.");
            return false;
        }
    }

    // Live password validation
    $("#inputPassword").on("input", function () {
        validatePassword(); // Invoke the function here
    });

    // Live password cross-checking
    $("#inputPasswordConfirm").on("input", function () {
        crossCheckPassword(); // Invoke the function here
    });

    // Form submission
    $("#input-form").on("submit", function (event) { // Change this to match the ID of your form
        event.preventDefault();

        // Perform live password validation and cross-checking before submitting the form
        if (!validatePassword() || !crossCheckPassword()) {
            return;
        }

        // Construct form data as a JavaScript object
        var formData = {
            first_name: $("#inputFirstName").val(),
            middle_name: $("#inputMiddleName").val(),
            last_name: $("#inputLastName").val(),
            mobile_no: $("#inputMobileNo").val(),
            dob: $("#inputDateofBirth").val(),
            email: $("#inputEmail").val(),
            password: $("#inputPassword").val(),
            confirm_password: $("#inputPasswordConfirm").val()
        };

        // Convert form data to JSON string
        var jsonData = JSON.stringify(formData);

        // Your AJAX code for form submission goes here
        $.ajax({
            type: "POST",
            url: "php/register.php",
            data: jsonData,
            contentType: "application/json", // Specify content type as JSON
            dataType: "json",
            success: function (response) {

                if (response.status==="error")
                    {
                        alert(response.message);
                    }
                else{
                    window.location.href = '/GUVI/login.html';
                    alert(response.message);
                }
                
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    });
});

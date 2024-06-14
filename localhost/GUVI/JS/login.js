$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault();

        // Get the values from the form
        var email = $("#inputEmail").val();
        var password = $("#inputPassword").val();


        // Send the login credentials to the server using AJAX
        $.ajax({
            type: "POST",
            url: "php/login.php",
            data: { email: email, password: password },
            dataType: "json",
            success: function(response) {
                if (response.status==='success') {
                    // Store the session token in localStorage
                    localStorage.setItem("email", email);
                    // Redirect to the dashboard page
                    window.location.href = "/GUVI/profile.html";
                } else {
                    // Display an error message if authentication fails
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // console.error("AJAX Error:", textStatus, errorThrown);
                alert("An error occurred. Please try again later.");
            }
        });
    });
});

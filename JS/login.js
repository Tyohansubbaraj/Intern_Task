$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault();

        var submitButton = $("#submit-button");
        var originalButtonHtml = submitButton.html();


        submitButton.prop('disabled', true).html('<div class="spinner-border" style="width: 1.5rem; height: 1.5rem;" role="status"><span class="sr-only"></span></div>');

        var email = $("#inputEmail").val();
        var password = $("#inputPassword").val();

        $.ajax({
            type: "POST",
            url: "/php/login.php",
            data: JSON.stringify({ email: email, password: password }),
            contentType: "application/json",
            success: function(response) {
                submitButton.html(originalButtonHtml).prop('disabled', false);
                
                if (response.status === 'success') {
                    localStorage.setItem("email", email);
                    window.location.href = "/GUVI/profile.html";
                } else {
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                submitButton.html(originalButtonHtml).prop('disabled', false);
                alert("An error occurred. Please try again later.");
            }
        });
    });
});

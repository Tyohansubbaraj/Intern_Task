$(document).ready(function() {
    // Assume the user is already logged in and we have the user's email stored in localStorage
    const email = localStorage.getItem('email');

    if (email) {

        // Fetch user details
        $.ajax({
            url: 'php/profile.php',
            type: 'POST',
            data: JSON.stringify({ email: email, action: 'getProfile' }),
            contentType: 'application/json',
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 'error') {
                    alert(response.message);
                } else {
                    $('#email').val(response.data.email);
                    $('#firstName').val(response.data.first_name);
                    $('#middleName').val(response.data.middle_name);
                    $('#lastName').val(response.data.last_name);
                    $('#mobileNo').val(response.data.mobile_no);
                    $('#dob').val(response.data.dob);
                }
            },
            error: function() {
                alert('Error fetching profile data');
            }
        });

        // Update profile details
        $('#profile-form').on('submit', function(event) {
            event.preventDefault();
            const updatedDetails = {
                email: email,
                first_name: $('#firstName').val(),
                middle_name: $('#middleName').val(),
                last_name: $('#lastName').val(),
                mobile_no: $('#mobileNo').val(),
                dob: $('#dob').val(),
                action: 'updateProfile'
            };

            $.ajax({
                url: 'php/profile.php', // Assuming a single PHP file handles both actions
                type: 'POST',
                data: JSON.stringify(updatedDetails),
                contentType: 'application/json',
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        alert('Profile updated successfully');
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Error updating profile');
                }
            });
        });
    } else {
        alert('No user logged in');
        window.location.href = "/GUVI/login.html";
    }

    $('#logoutBtn').click(function() {
        const email = localStorage.getItem('email');
        const data = {
            email : email,
            action : 'logout'
        };
        $.ajax({
            url: 'php/profile.php', // Assuming a single PHP file handles both actions
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    alert('Profile updated successfully');
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error updating profile');
            }
        });
        localStorage.removeItem('email');

        window.location.href = 'login.html'; // Redirect to login page
    });

});

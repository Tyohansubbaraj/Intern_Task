document.addEventListener('DOMContentLoaded',function() {
    const inputPassword = document.getElementById('inputPassword');
    const confirmPasswordInput = document.getElementById('inputPasswordConfirm');
    const passwordValidError = document.getElementById('password-valid-error');
    const confirmErrorMessage = document.getElementById('confirm-error-message');
    const inputForm = document.getElementById('input-form');

    inputPassword.addEventListener('input',function() {
        validatePassword();
    });

    confirmPasswordInput.addEventListener('input', function(){
        crosscheckPassword();
});

    inputForm.addEventListener('submit',function()
{
    e.preventDefault();
    if (validatePassword() && crosscheckPassword())
        {
            alert('Registered');
        }
    else{
        alert('Invalid/Incorrect Password');
    }
});
function validatePassword()
{
    
    const strongregex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    let password = inputPassword.value
    if (strongregex.test(password)==false){
        passwordValidError.textContent='Invalid Password';
        return false;
    }
    else{
        passwordValidError.textContent='';
        return true;
    }
}

function crosscheckPassword()
{
    let confpass = confirmPasswordInput.value;
    let password = inputPassword.value;
    if (password==confpass)
        {
            confirmErrorMessage.textContent = '';
            return true;
        }
    else{
            confirmErrorMessage.textContent = 'Passwords Do Not Match';
            return false;
        }
}

});

function retrieveDetails()
{

    let fname = document.getElementById('inputFirstName');
    let mname = document.getElementById('inputMiddleName');
    let lname = document.getElementById('inputLastName');
    let contact = document.getElementById('inputMobileNo');
    let dob = document.getElementById('inputDateOfBirth');
    let email = document.getElementById('inputEmail');
    let password = document.getElementById('inputPassword');
    let confirm_password = document.getElementById('inputPasswordConfirm'); 
    
    
}


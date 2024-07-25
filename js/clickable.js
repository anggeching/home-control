document.getElementById('signUpBtn').addEventListener('click', function() {
    document.getElementById('signUpForm').style.display = 'block';
    document.getElementById('logInForm').style.display = 'none';
});

document.getElementById('logInBtn').addEventListener('click', function() {
    document.getElementById('logInForm').style.display = 'block';
    document.getElementById('signUpForm').style.display = 'none';
});

document.getElementById('signUpFormContent').addEventListener('submit', function(e) {
    e.preventDefault();
    document.getElementById('signUpForm').style.display = 'none';
    document.getElementById('logInForm').style.display = 'block';
});

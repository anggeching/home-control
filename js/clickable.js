document.addEventListener('DOMContentLoaded', function() {
    const signUpBtn = document.getElementById('signUpBtn');
    const logInBtn = document.getElementById('logInBtn');
    const dialogBox = document.getElementById('dialogBox');
    const userBtn = document.getElementById('userBtn');
    const adminBtn = document.getElementById('adminBtn');
    const signUpForm = document.getElementById('signUpForm');
    const logInForm = document.getElementById('logInForm');
    let currentAction = ''; // Keeps track of whether "Sign Up" or "Login" was clicked

    // Function to show the dialog box
    function showDialog(action) {
        currentAction = action;
        dialogBox.style.display = 'block';
        signUpForm.style.display = 'none';
        logInForm.style.display = 'none';
    }

    // Function to hide the dialog box
    function hideDialog() {
        dialogBox.style.display = 'none';
    }

    // Event listeners for "Sign Up" and "Login" buttons
    signUpBtn.addEventListener('click', function(event) {
        event.preventDefault();
        showDialog('signUp');
    });

    logInBtn.addEventListener('click', function(event) {
        event.preventDefault();
        showDialog('logIn');
    });

    userBtn.addEventListener('click', function() {
        hideDialog();
        if (currentAction === 'signUp') {
            signUpForm.style.display = 'block';
        } else if (currentAction === 'logIn') {
            logInForm.style.display = 'block';
        }
    });

    adminBtn.addEventListener('click', function() {
        hideDialog();
        if (currentAction === 'signUp') {
            signUpForm.style.display = 'block';
        } else if (currentAction === 'logIn') {
            logInForm.style.display = 'block';
        }
    });
});



document.getElementById('signUpBtn').addEventListener('click', function() {
    document.getElementById('signUpForm').style.display = 'block';
    document.getElementById('logInForm').style.display = 'none';
});

document.getElementById('logInBtn').addEventListener('click', function() {
    document.getElementById('logInForm').style.display = 'block';
    document.getElementById('signUpForm').style.display = 'none';
});

// Handle Sign Up Form Submission
document.getElementById('signUpFormContent').addEventListener('submit', function(e) {
    e.preventDefault();
    // Here, you would typically send the form data to the server to create a new user
    alert('Sign Up Successful!'); // Replace with actual sign up logic
    document.getElementById('signUpForm').style.display = 'none';
    document.getElementById('logInForm').style.display = 'block'; // Show login form after signup
});

// Handle Log In Form Submission
document.getElementById('logInFormContent').addEventListener('submit', function(e) {
    e.preventDefault();
    // Here, you would typically send the form data to the server to authenticate the user
    alert('Login Successful!'); // Replace with actual login logic

    // Create a temporary link element and trigger a click event to redirect
    const tempLink = document.createElement('a');
    tempLink.href = 'front-end/home.php';
    tempLink.style.display = 'none'; // Hide the link element
    document.body.appendChild(tempLink); // Append it to the body
    tempLink.click(); // Trigger the click event
    document.body.removeChild(tempLink); // Clean up by removing the link
});

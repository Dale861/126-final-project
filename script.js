// Function to display the sign-up form when the button is clicked
function openForm() {
    document.getElementById("signup").style.display = "block";  // Show the signup form
    document.getElementById("signIn").style.display = "none";  // Hide the sign-in form
}

// Switch to the sign-up form when the 'Sign Up' button is clicked from the Sign-In form
document.getElementById("signUpButton").addEventListener("click", function() {
    document.getElementById("signup").style.display = "block";  // Show the signup form
    document.getElementById("signIn").style.display = "none";  // Hide the sign-in form
});

// Switch to the sign-in form when the 'Sign In' button is clicked from the Sign-Up form
document.getElementById("signInButton").addEventListener("click", function() {
    document.getElementById("signIn").style.display = "block";  // Show the sign-in form
    document.getElementById("signup").style.display = "none";  // Hide the signup form
});

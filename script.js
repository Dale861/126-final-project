function openForm() {
    document.getElementById("signup").style.display = "block";
}

console.log("hello");

// const openSignUp=document.getElementById('openSignUp');
const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signup');

// openSignUp.addEventListener('click',function(){
//     signInForm.style.display="none";
//     signUpForm.style.display="block";
//     console.log("form opened");
// })

function showNav() {
    document.getElementById("nav").style.display = "flex";
}

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
    console.log("1234");
})

signInButton.addEventListener('click', function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
    console.log("abcd");
})

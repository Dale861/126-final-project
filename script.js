function openForm() {
    document.getElementById("myForm").style.display = "block";
}
  
console.log("hello world");

function openForm() {
    document.getElementById("signup").style.display = "block";
}

const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signup');

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


function increaseQuantity() {
  const qty = document.getElementById("quantity");
  qty.value = parseInt(qty.value) + 1;
}

function decreaseQuantity() {
  const qty = document.getElementById("quantity");
  if (parseInt(qty.value) > 1) {
    qty.value = parseInt(qty.value) - 1;
  }
}
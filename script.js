function openForm() {
    document.getElementById("myForm").style.display = "block";
}
  
function closeForm() {
    document.getElementById("myForm").style.display = "none";
}

function Login(event){
  event.preventDefault();
  document.getElementById("nav").style.display = "flex";
  document.getElementById("SignUp").style.display = "none";
  closeForm();
}
function validateEmail(inputText)
{
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(!inputText.value.match(mailformat))
{
document.getElementById("errEmail").innerHTML = "Invalid email format!";
document.getElementById("email").focus();
return false;
}
}
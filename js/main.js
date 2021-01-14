$('#security-question').click(function(){
    var value=$(this).val();
    if (value!="Please select security question")
    {
        $('#answer-signup').show();
    }
    else{
        $('#answer-signup').hide();
    }
});
$('#password').focus(function(){
    $('#error-password').show().fadeOut(7000);
});
function validateForm(){
    var name=($('#name').val()).trim();
    var email=($('#email').val()).trim();
    var mobile=($('#mobile').val()).trim();
    var security_question=($('#security-question').val()).trim();
    var answer=($('#answer').val()).trim();
    var password=($('#password').val()).trim();
    var repassword=($('#repassword').val()).trim();
    var regName=/^([a-zA-Z]+\s?)*$/;
    var regPassword=/^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{8,16}$/;
    var regMobile=/^(0)?[1-9]{1}[0-9]{9}$/;
    var regEmail=/^[a-zA-Z0-9.-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/;
    if (name=="" || email=="" || mobile=="" || security_question=="" || answer=="" || password=="" || repassword=="") {
        alert("all fields are mandatory including security question and answer kindly choose one question and answer that!");
        return false;
    }
    else if (!(name.match(regName))){
        alert("Please enter valid name");
        return false;
    }
    else if (!(password.match(regPassword))) {
        alert("password criteria does not matched");
        return false;
    }
    else if (!(email.match(regEmail))) {
        alert("email criteria doesn't match");
        return false;
    }
    else if (!(mobile.match(regMobile))) {
        alert("Please enter valid mobile number");
        return false;
    }
    else if (password!=repassword) {
        alert("please enter same password and repassword");
        return false;
    }
    else if (!isNaN(answer)) {
        alert("please enter valid answers i.e, only digits are not allowed");
        return false;
    }
    return true;
}
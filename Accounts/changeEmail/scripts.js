//sending data to the server to change email
function changeEmail(){
    //get the password and emails
    var password = document.getElementById('password').value;
    var newemail = document.getElementById('newemail').value;
    //get the span that will show the result
    var submitResult = document.getElementById('submitResult');
    //this clears the warning from previous attempt
    submitResult.innerHTML = "please wait ...";
    submitResult.style.color = "black";
    
    //do some checking here to reduce the load on the server
    //validate password
    if (invalidPassword(password)){
        submitResult.innerHTML = invalidPassword(password);
        submitResult.style.color = "red";
        return;
    }
    if (invalidEmail(newemail)){
        submitResult.innerHTML = invalidEmail(newemail) + " (new)";
        submitResult.style.color = "red";
        return;
    }
    
    //creating new http xml request
    var xmlrequest = new XMLHttpRequest();
    //show the result when availale
    xmlrequest.onload = function() {
        submitResult.innerHTML = this.responseText;
        if (this.responseText == "email updated successfully") {
            submitResult.style.color = "LimeGreen";
        }else {
            submitResult.style.color = "red";
        }
    };
    //send the request to the server
    xmlrequest.open("POST", "changeEmail.php");
    xmlrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlrequest.send("password=" + password + 
                    "&newemail=" + newemail);
}

//this functions validate data here to reduce the load on the server
function invalidPassword(password){
    if (password == ""){
        return "password required";
    }
    if (/^ +/.test(password)) {
        return "password shouldn't begin with spaces";
    }
    if (password.length < 8 || password.length > 30){
        return "password should be 8 to 30 characters";
    }
}
function invalidEmail(email){
    if (email == ""){
        return "email required";
    }
    if (/^ +/.test(email)) {
        return "remove spaces";
    }
    if (email.length < 7 || email.length > 255){
        return "wow! what is this email?";
    }
    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        return "wrong email!";
    }
}

//this function is called when the button next to input is clicked
function showPassword(id,button){
    //get the input we want to change
    var input = document.getElementById(id);
    //check if it is password or text
    if (input.type == "password"){
        input.type = "text";
        button.innerHTML = "(x)";
    }else{
        input.type = "password";
        button.innerHTML = "(o)";
    }
}
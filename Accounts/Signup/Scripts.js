
//sending the data to the server when Register button is clicked
function sendData(){
    //get values
    let password = document.getElementById("password").value;
    let repassword = document.getElementById("repassword").value;
    let email = document.getElementById("email").value;
    //get the span that will show the result
    let submit_result = document.getElementById("submit_result");
    let password_result = document.getElementById("password_result");
    
    //do some checking here to reduce the load on the server
    //validate password
    if (password != repassword){
        password_result.innerHTML = "passwords don't match";
        password_result.style.color = "red";
        return;
    }else {
        //this clears the warning from previous attempt
        password_result.innerHTML = "";
    }
    if (invalid_password(password)){
        submit_result.innerHTML = invalid_password(password);
        submit_result.style.color = "red";
        return;
    }
    //validate email
    if (invalid_email(email)){
        submit_result.innerHTML = invalid_email(email);
        submit_result.style.color = "red";
        return;
    }
    
    //initiate http request to the server
    let xmlrequest = new XMLHttpRequest();
    //show the result when availale
    xmlrequest.onload = function() {
        submit_result.innerHTML = this.responseText;
        if (this.responseText == "registered successifully") {
            submit_result.style.color = "LimeGreen";
        }else {
            submit_result.style.color = "red";
        }
    };
    //send the request to the server
    xmlrequest.open("POST", "Register.php");
    xmlrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlrequest.send("password=" + password + 
                    "&repassword=" + repassword + "&email=" + email);
}

//this functions validate data here to reduce the load on the server
function invalid_password(password){
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
function invalid_email(email){
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

//toggle show password
function show_password(button){
    let password = document.getElementById("password");
    let repassword = document.getElementById("repassword");
    if (password.type == "password"){
        password.type = "text";
        repassword.type = "text";
        button.innerHTML = "hide password";
    }else {
        password.type = "password";
        repassword.type = "password";
        button.innerHTML = "show password";
    }
}
function login(){
    //get the values
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    //get the span that will show errors
    let resultSpan = document.getElementById('result');

    //validate the data
    if(invalidData(email, password)){
        resultSpan.innerHTML = invalidData(email, password);
        return;
    }

    //connect to the server
    let xmlrequest = new XMLHttpRequest();
    //show the result when available
    xmlrequest.onload = function(){
        let responseObj = JSON.parse(this.responseText);
        if (responseObj.message == "success"){
            window.location.href = responseObj.redirect;
        }else {
            resultSpan.innerHTML = responseObj.message;
        }
    }
    xmlrequest.open('POST', 'login.php');
    xmlrequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlrequest.send('email=' + email + '&password=' + password);
    
}

//function to validate data
function invalidData(email, password){
    if (email =="" || password == "") {
        return "fill in empty feilds";
    }
    if(/^ +/.test(email) || /^ +/.test(password)){
        return "password or username can't start with spaces";
    }
    if (email.length < 7 || email.length > 255){
        return "email should be 7 to 255 characters";
    }
    if (password.length < 8 || password.length > 30){
        return "password should be 8 to 30 characters";
    }
    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        return "wrong email!";
    }
}
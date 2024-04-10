function login(){
    //get the values
    let name = document.getElementById('name').value;
    let password = document.getElementById('password').value;
    //get the span that will show errors
    let resultSpan = document.getElementById('result');

    //validate the data
    if(invalidData(name, password)){
        resultSpan.innerHTML = invalidData(name, password);
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
    xmlrequest.send('name=' + name + '&password=' + password);
    
}

//function to validate data
function invalidData(name, password){
    if (name =="" || password == "") {
        return "fill in empty feilds";
    }
    if(/^ +/.test(name) || /^ +/.test(password)){
        return "password or username can't start with spaces";
    }
    if (name.length < 4 || name.length > 30){
        return "name should be 4 to 30 characters";
    }
    if (password.length < 8 || password.length > 30){
        return "password should be 8 to 30 characters";
    }
    //added space to the regex to allow spaces
    if (!/^[a-zA-Z0-9- _@.]*$/.test(name)) {
        return "this must be invalid name";
    }
}
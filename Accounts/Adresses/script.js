//some global variables to be saved througout functions
var adressId = "";

function editAdress(id, name, phone, adress){
    //get elements
    let nameInput = document.getElementById("adressName");
    let phoneInput = document.getElementById("phone");
    let adressInput = document.getElementById("adress");

    //prepare values
    adressId = id;
    nameInput.value = name;
    phoneInput.value = phone;
    adressInput.value = adress;

    //show the edit fields
    document.getElementById("editAdress").style.display = "block";
}

//this function is called when the user click cancel button on edit div
function cancelEdit(){
    document.getElementById("editAdress").style.display = "none";
}

//function to send the data to the server
function saveAdress(){
    //get data
    let name = document.getElementById("adressName").value;
    let phone = document.getElementById("phone").value;
    let adress = document.getElementById("adress").value;
    //prepare result span
    let resultSpan = document.getElementById("result");

    //validate data
    let invalid= invalidData(adressId, name, phone, adress);
    if (invalid){
        resultSpan.innerHTML = invalid;
        return
    }

    //initiate request
    let xmlrequest = new XMLHttpRequest();
    //show the result when available
    xmlrequest.onload = function(){
        if (this.responseText == "success"){
            window.location.reload(true);
        }else {
            resultSpan.innerHTML = this.responseText;
        }
    }
    xmlrequest.open('POST', 'updateAdress.php');
    xmlrequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlrequest.send('adressId=' + adressId + '&name=' + name
                    + '&phone=' + phone + '&adress=' + adress);
    
}

//todo remove adress
function removeAdress(id){
    //validate (i think it is not required on client side)
    if (id == "" || /^ +/.test(id) || !/^[0-9.]*$/.test(id)){
        alert ("don't play with item id");
        return;
    }

    //confirm deletion 
    if (!confirm("Are you sure you want to delete this adress?")){
        return;
    }

    //initiate request
    let xmlrequest = new XMLHttpRequest();
    //show the result when available
    xmlrequest.onload = function(){
        if (this.responseText == "success"){
            window.location.reload(true);
        }else {
            alert(this.responseText);
        }
    }
    xmlrequest.open('POST', 'remove.php');
    xmlrequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlrequest.send("adressId=" + id);
}

//function to validate data on client side
function invalidData(id, name, phone, adress){
    if (name == "" || phone == "" || adress == ""){
        return "fill in empty fields";
    }
    if (id =="") {
        return "hmm where is item Id?";
    }
    if(/^ +/.test(id) || /^ +/.test(phone) || /^ +/.test(name)){
        return "remove spaces";
    }
    if (name.length < 5 || name.length > 100){
        return "name is too short.. or too long!";
    }
    if (phone.length < 4 || phone.length > 30){
        return "phone is too short.. or too long!";
    }
    if (adress.length < 10 || adress.length > 255){
        return "adress is too short.. or too long!";
    }
    if (!/^[0-9.]*$/.test(id) || !/^[0-9.]*$/.test(phone)) {
        return "this must be invalid phone";
    }
}

function loadReturns(){
    //prepare variables
    let returnId = document.getElementById("returnId").value;
    let phone = document.getElementById("phone").value;
    let status = document.getElementById("status").value;
    let sort = document.getElementById("sort").value;
    let orderBy = document.getElementById("orderBy").value;

    //prepare result table
    let result = document.getElementById("result");

    //prepare form data
    let formData = new FormData();
    formData.append("returnId", returnId);
    formData.append("phone", phone);
    formData.append("status", status);
    formData.append("sort", sort);
    formData.append("orderBy", orderBy);

    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function(){
        result.innerHTML = this.responseText;
    }
    xhr.open("POST", "loadReturns.php");
    xhr.send(formData);
}

function changeStatus(returnId) {
    //get status
    let newStat = document.getElementById("status").value;
    //prepare result
    let resultSpan = document.getElementById("statusResult");

    //initiate request
    let xhr = new XMLHttpRequest();
    xhr.onload = function(){
        if (this.responseText == "success"){
            window.location.reload(true);
        }else {
            resultSpan.innerHTML = this.responseText;
        }
    }
    xhr.open('POST', 'changeStatus.php');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('returnId=' + returnId + '&newStat=' + newStat);
}
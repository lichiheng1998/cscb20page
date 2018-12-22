function submitRemark(id){
    let workid = id;
    let description = document.getElementById(id+'reason').value;
    let markerid = document.getElementById('sentTo').value;
    console.log(markerid);
    let jsonString = JSON.stringify({"workID": workid, "description": description, "markerID": markerid});
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == 'true') {
                alert("Request submitted!");
                location.reload();
            } else {
                alert("Failed!\n" + this.responseText );
            }
        }
    };
    xhttp.open("POST", "validate/remark_request.php?user=" + jsonString, true);
    xhttp.send();
}


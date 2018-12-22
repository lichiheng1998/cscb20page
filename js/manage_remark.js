/**
 * Created by lichi on 2018/4/6.
 */
function updateMark(el, studentID, workID){
    console.log("fuck");
    let form = el.parentNode;
    if(form.checkValidity()){
        let mark = form.elements.namedItem("mark").value;
        let jsonString = JSON.stringify({"userid": studentID,
            "workid": workID, "mark": mark});
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                let arr = JSON.parse(this.responseText);
                let comp = get_component(el);
                let hint = comp.querySelector(".hint");
                if (arr["result"]) {
                    setHint(hint, true);
                    removeFadeOut(comp, 1000);
                } else {
                    setHint(hint, false);
                }
            }
        };
        xhttp.open("POST", "validate/update_mark.php?remark=true&&mark=" + jsonString, true);
        xhttp.send();
    }
}
function setHint(el, correct){
    if(correct){
        el.style.color = "green";
        el.innerHTML = "Remark Succeed";
    } else {
        el.style.color = "red";
        el.innerHTML = "Remark Failed";
    }
}
function get_component(el){
    let need = el;
    for(let i = 0; i < 4; i++){
        need = need.parentNode;
    }
    return need
}
function removeFadeOut( el, speed ) {
    var seconds = speed/1000;
    el.style.transition = "opacity "+seconds+"s ease";
    el.style.opacity = 0;
    setTimeout(function() {
        el.parentNode.removeChild(el);
    }, speed);
}
function queryRemarkReq(id){
    clearRemark();
    let date = document.getElementById("date").value;
    let limit = document.getElementById("limit").value;
    let jsonString = JSON.stringify({"date": date, "limit": limit});
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let arr = JSON.parse(this.responseText);

            if (arr.length == 0) {
                document.getElementById("hint").innerText = "There is no" +
                    " feedback at that day";
            } else {
                document.getElementById("hint").innerText = "";
                let feedback = arr[id];
                var result = arr[id] === undefined;
                if (result){
                    feedback = [];
                }
                for(let b = 0; b < feedback.length; b++){
                    uploadRemark(feedback[b], true);
                }
                for (let key in arr) {
                    // check if the property/key is defined in the object itself, not in parent
                    if (arr.hasOwnProperty(key) && key != id) {
                        for (let a = 0; a < arr[key].length; a++){
                            uploadRemark(arr[key][a], false);
                        }
                    }
                }

            }
        }
    };
    xhttp.open("POST", "validate/remark_query.php?query=" + jsonString, true);
    xhttp.send();
}
function uploadRemark(remarkDict, isMe){
    let href = "html_templates/remark.html";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", href, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let newContent = generateRemark(remarkDict, htmlToElement(this.responseText));
            newContent.style.opacity = '0';
            newContent.classList.add('opacity_animated');
            if(isMe){
                document.getElementById("myReq").insertAdjacentElement('afterend', newContent);
            }else{
                document.getElementById("otherReq").insertAdjacentElement('afterend', newContent);
            }
            window.setTimeout( function() {
                newContent.style.opacity = '1';
            }, 100);
        }
    };

}
function htmlToElement(html) {
    var template = document.createElement('template');
    html = html.trim(); // Never return a text node of whitespace as the result
    template.innerHTML = html;
    return template.content.firstChild;
}

function generateRemark(remarkDict, template){
    let answers = template.querySelectorAll(".nec");
    answers[0].innerText = "From " + remarkDict["StudentID"];
    answers[1].innerText = remarkDict["WorkID"];
    answers[2].innerText = remarkDict["Percentage"];
    answers[3].addEventListener("click", function(){
        updateMark(answers[3], remarkDict["StudentID"], remarkDict["WorkID"]);
    });
    answers[4].innerText = remarkDict["Description"];
    answers[5].innerText = "Posted on " + remarkDict["UpdateDate"];
    return template;
}
function clearRemark(){
    let remark = document.getElementsByClassName("remarkreq");
    for (let i = 0; i < remark.length; i++){
        removeFadeOut(remark[i], 1000)
    }
}
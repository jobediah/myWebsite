var pswdCheck = function() {
    var pswd1 = document.getElementById("password").value;
    var pswd2 = document.getElementById("confirm").value;
    
    if(pswd1 === pswd2){
        document.getElementById("checkMark").innerHTML="Passwords match!";
    }
    else{
        document.getElementById("checkMark").innerHTML="Warning! Passwords don't match.";
    }
}

function login(account_type) {
    var usrnm = document.getElementById("username").value;
    var pswd = document.getElementById("password").value;
    console.log(account_type);
    
    var email = "true";
    
    if(pswd.length < 5){
        document.getElementById("checkMark").innerHTML="Password needs to be at least six characters long";
        return;
    }
    
    if(account_type == "true"){
        email = document.getElementById("email").value;
    }
    
    if(usrnm && pswd && email){
        
        var httpRequest = new XMLHttpRequest();
        httpRequest.open("POST", "http://web.engr.oregonstate.edu/~hansejod/finalproject/login.php", true);
        httpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        httpRequest.send("username="+usrnm+"&password="+pswd+"&email="+email+"&account="+account_type);
    
    
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            console.log("Connection successful");
            document.getElementById("myDiv").innerHTML=httpRequest.responseText;
            }
        }
    }
    
    else{
        document.getElementById("myDiv").innerHTML="Please fill out all forms correctly.";
    }
}
window.onload = function(){
    console.log("I am working");
    serverRequest();
    
};

var deleteMeetup = function(id){
   	var httpRequest = new XMLHttpRequest();
    httpRequest.open("POST", "http://web.engr.oregonstate.edu/~hansejod/finalproject/usercontent.php", true);
    httpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    httpRequest.send("deleteId="+id);
    httpRequest.onreadystatechange = function(){
        console.log("Success");
        if (httpRequest.readyState === 4) {
            if (httpRequest.status === 200) {
                console.log("Deleted");
                serverRequest();
            }
            else { console.log("Sorry, something didn't work")}
        }
        
        else {console.log("Not ready");}
    }
};

function createMeeting(name){
    var date = document.getElementById("date").value;
    var time = document.getElementById("time").value;
    var location = document.getElementById("location").value;
    var zipcode = document.getElementById("zipcode").value;
    var description = document.getElementById("description").value;
    
    /*if(+(date.slice(0,4)) < 2015){
        document.getElementById("myDiv").innerHTML="Please enter a date for 2015.";
        return;
    }*/
    
    console.log(date, time, location, zipcode, description);
    
   	//Request to server for database
    var httpRequest = new XMLHttpRequest();
    httpRequest.open("POST", "http://web.engr.oregonstate.edu/~hansejod/finalproject/usercontent.php", true);
    httpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    httpRequest.send("date="+date+"&time="+time+"&location="+location+"&zipcode="+zipcode+"&description="+description);
    
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            console.log("Connection successful");
            document.getElementById("myDiv").innerHTML=httpRequest.responseText;
            serverRequest();
        }
    }
};

var serverRequest = function(){
   	//Request to server for database
   	console.log("SERVER was called");
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function(){
        console.log("Success");
        if (httpRequest.readyState === 4) {
            if (httpRequest.status === 200) {
                var data = JSON.parse(httpRequest.responseText);
                console.log(data);
                calendar(data);
            }
            
            else { console.log("Sorry, something didn't work")}
        }
        
        else {console.log("Not ready");}
        
    }
    
    httpRequest.open('GET', 'http://web.engr.oregonstate.edu/~hansejod/finalproject/data.php', true);
    httpRequest.send();
};

var calendar = function(data){
    var div = document.getElementById("calendar");
    
    while (div.firstChild){
        div.removeChild(div.firstChild);
    }
    
    if(data.length < 1){
        var p = document.createElement("p");
        var pText = document.createTextNode("You have no events");
        p.appendChild(pText);
        div.appendChild(p);
        return;
    }
    
    var table = document.createElement("table");
    table.setAttribute("border", "2", "2");
    var tHead = document.createElement("thead");
    var tRow = document.createElement("tr");
    
    var tH2 = document.createElement("th");
    var tHeadText2 = document.createTextNode("DATE");
    tH2.appendChild(tHeadText2);
    
    var tH3 = document.createElement("th");
    var tHeadText3 = document.createTextNode("TIME");
    tH3.appendChild(tHeadText3);
    
    var tH4 = document.createElement("th");
    var tHeadText4 = document.createTextNode("LOCATION");
    tH4.appendChild(tHeadText4);
    
    var tH5 = document.createElement("th");
    var tHeadText5 = document.createTextNode("DESCRIPTION");
    tH5.appendChild(tHeadText5);
    
    var tH6 = document.createElement("th");
    var tHeadText6 = document.createTextNode("DELETE");
    tH6.appendChild(tHeadText6);
    
    tRow.appendChild(tH2);
    tRow.appendChild(tH3);
    tRow.appendChild(tH4);
    tRow.appendChild(tH5);
    tRow.appendChild(tH6);
    
    tHead.appendChild(tRow);
    table.appendChild(tHead);
    
    var tBody = document.createElement("tbody");
    
    // creating all cells of table
    for (var i = 0; i < data.length; i++) {
        var mainRows = document.createElement("tr");
            
        var cell = document.createElement("td");
        var cellText = document.createTextNode(data[i].date);
        cell.appendChild(cellText);
        mainRows.appendChild(cell);
            
        var cell1 = document.createElement("td");
        var cellText1 = document.createTextNode(data[i].time);
        cell1.appendChild(cellText1);
        mainRows.appendChild(cell1);
            
        var cell2 = document.createElement("td");
        var cellText2 = document.createTextNode(data[i].location+", "+data[i].zipcode);
        cell2.appendChild(cellText2);
        mainRows.appendChild(cell2);
            
        var cell3 = document.createElement("td");
        var cellText3 = document.createTextNode(data[i].description);
        cell3.appendChild(cellText3);
        mainRows.appendChild(cell3);
        
        var cell4 = document.createElement("td");
        cell4.innerHTML = "<input type='button' name='"+data[i].id+"' id='deleteButton' value='Delete' onclick='deleteMeetup(this.name)'>";
        mainRows.appendChild(cell4);
        
        tBody.appendChild(mainRows);
    }
   
    table.appendChild(tBody);
    div.appendChild(table);
}

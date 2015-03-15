window.onload = function(){
    console.log("I am working");
    serverRequest("true");
    
};

var filterResults = function(name){
    var zipcode = document.getElementById("filters").value;
    if(!zipcode || !(+zipcode) || zipcode.length > 5){
        serverRequest("true");
        return;
    }
    console.log(zipcode);

    var httpRequest = new XMLHttpRequest();
    
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            var data = JSON.parse(httpRequest.responseText);
            data = data.results;
            console.log(data);
            var filter = new Array();
            for(var i = 0; i < data.length; i++){
                filter.push(data[i].zip)
            }
            serverRequest(filter);
        }
    }
    httpRequest.open("GET", "https://www.zipwise.com/webservices/radius.php?key=tkwfkgyz2ee8ya72&zip="+zipcode+"&radius=5&format=json", true);
    httpRequest.send();
}

var serverRequest = function(filter){
   	//Request to server for database
   	var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function(){
        console.log("Success");
        if (httpRequest.readyState === 4) {
            if (httpRequest.status === 200) {
                var data = JSON.parse(httpRequest.responseText);
                console.log(data);
                calendar(data, filter);
            }
            
            else { console.log("Sorry, something didn't work")}
        }
        
        else {console.log("Not ready");}
        
    }
    
    httpRequest.open('GET', 'http://web.engr.oregonstate.edu/~hansejod/finalproject/meetups.php', true);
    httpRequest.send();
};

var calendar = function(data, filter){
    console.log(filter);
    if(filter == "true"){
        var flag = true;
    }
    
    var div = document.getElementById("meetups");
    
    while (div.firstChild){
        div.removeChild(div.firstChild);
    }
    
    var table = document.createElement("table");
    table.setAttribute("id", "table");
    
    var tHead = document.createElement("thead");
    tHead.setAttribute("class", "headerrow");
    var tRow = document.createElement("tr");
    
    var tH0 = document.createElement("th");
    var tHeadText0 = document.createTextNode("");
    tH0.appendChild(tHeadText0);

    var tH1 = document.createElement("th");
    var tHeadText1 = document.createTextNode("OWNER");
    tH1.appendChild(tHeadText1);
    
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
    
    tRow.appendChild(tH0);
    tRow.appendChild(tH1);
    tRow.appendChild(tH2);
    tRow.appendChild(tH3);
    tRow.appendChild(tH4);
    tRow.appendChild(tH5);
    
    tHead.appendChild(tRow);
    table.appendChild(tHead);
    
    var tBody = document.createElement("tbody");
    
    var flag2 = false;
    
    // creating all cells of table
    for (var i = 0; i < data.length; i++) {
        for(var j = 0; j<filter.length; j++){
            if(data[i].zipcode == filter[j]){
                flag2 = true;
            }
        }
        
        if(flag2 == true || flag == true){
        var mainRows = document.createElement("tr");
        mainRows.setAttribute("class", "row");
        
        var cell7 = document.createElement("td");
        cell7.setAttribute("class", "cell");
        var picture = document.createElement("img");
        var url = "http://web.engr.oregonstate.edu/~hansejod/finalproject/"+data[i].picture;
        console.log(url);
        picture.setAttribute("src", url);
        picture.setAttribute("height", 50);
        picture.setAttribute("width", 50);
        cell7.appendChild(picture);
        mainRows.appendChild(cell7);
            
        var cel = document.createElement("td");
        cel.setAttribute("class", "cell");
        var celText = document.createTextNode(data[i].owner);
        var email = document.createElement("a");
        email.setAttribute("href", "mailto:"+data[i].email+"?Subject="+data[i].description);
        email.setAttribute("target", "_top");
        email.appendChild(celText);
        cel.appendChild(email);
        mainRows.appendChild(cel);
            
        var cell = document.createElement("td");
        cell.setAttribute("class", "cell");
        var cellText = document.createTextNode(data[i].date);
        cell.appendChild(cellText);
        mainRows.appendChild(cell);
            
        var cell1 = document.createElement("td");
        cell1.setAttribute("class", "cell");
        var cellText1 = document.createTextNode(data[i].time);
        cell1.appendChild(cellText1);
        mainRows.appendChild(cell1);
            
        var url = data[i].location.split(' ').join('+')
        
        var cell2 = document.createElement("td");
        cell2.setAttribute("class", "cell");
        var cellText2 = document.createTextNode(data[i].location+", "+data[i].zipcode);
        var link = document.createElement("a");
        link.setAttribute("href", "https://www.google.com/maps/place/"+url+"+"+data[i].zipcode);
        link.setAttribute("target", "_blank");
        link.appendChild(cellText2);
        cell2.appendChild(link);
        mainRows.appendChild(cell2);
            
        var cell3 = document.createElement("td");
        cell3.setAttribute("class", "cell");
        var cellText3 = document.createTextNode(data[i].description);
        cell3.appendChild(cellText3);
        mainRows.appendChild(cell3);
        
        tBody.appendChild(mainRows);
        flag2 = false;
        
    }
   
    table.appendChild(tBody);
    div.appendChild(table);
    }
}
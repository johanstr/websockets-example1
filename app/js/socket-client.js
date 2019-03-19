var conn = new WebSocket('ws://localhost:8080');

conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
    var workshops = JSON.parse(e.data);

    for(var i = 0; i < workshops.length; i++) {
        var obj = workshops[i];
        var liTag = document.getElementById('workshop-' + obj.id);

        liTag.innerHTML =   "<span class='workshop-title'>"+ obj.titel +"</span>\n" +
                            "<span class='workshop-places'>"+ obj.plaatsen +"</span>\n";
    }
};

window.onload = function() {
    var submitButton = document.getElementById('submit-btn');


    submitButton.addEventListener('click', function(e) {
        var workshopSelection = document.getElementById('workshop-select');
        var selectedWorkshopId = workshopSelection.options[workshopSelection.selectedIndex].value;

        conn.send(selectedWorkshopId);
    });
};

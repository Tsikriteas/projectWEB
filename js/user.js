var username = sessionStorage.getItem("user_name");
document.getElementById("welcome").innerHTML = "Welcome " + username;
if (sessionStorage.getItem("user_name") == null){
    location.replace("index.html");
}

let mymap = L.map('mapid').setView([38.230462,21.753150], 1);
L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=H4YYIrADBiPJ65kRGBVc',
  {attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>'
  }).addTo(mymap);

let cfg = {"radius": 40,
    "maxOpacity": 0.8,
    "scaleRadius": false,
    "useLocalExtrema": false,
    latField: 'lat',
    lngField: 'lng',
    valueField: 'count'};

let heatmapLayer = new HeatmapOverlay(cfg);
mymap.addLayer(heatmapLayer); 


$.getJSON("queries.php?query=heatmap",function(resp){

    const data = resp.points;
    const max = resp.max;      
    heatmapLayer.setData({
        max,
        data,
    });
}); 


$.getJSON("queries.php?query=stats",function(data){

    function loadTableData(items) {
        const table = document.getElementById("testBody");
    
        let row = table.insertRow();
        let entries = row.insertCell(0);
        entries.innerHTML = items.entries;
        let last_upload = row.insertCell(1);
        last_upload.innerHTML = items.last_upload;
  }
  loadTableData(data);
});

let jsonFile;

    if (window.FileList && window.File && window.FileReader) {
            document.getElementById('myfile').addEventListener('change', event => {
            const file = event.target.files[0];
            filename = file.name;
            const reader = new FileReader();
            reader.addEventListener('load', event => {
                jsonFile = JSON.parse(event.target.result)
                function trimJSON(jsonFile, propsToRemove, propsINSremove, prostime, prosreq, prosresponse) {
                    propsToRemove.forEach((propName) => {
                        delete jsonFile.log[propName];
                        }
                        );
                    var i;
                    propsINSremove.forEach((prosins) => { 
                        for (i = 0; i < jsonFile.log['entries']['length']; i++){
                            delete jsonFile.log['entries'][i][prosins];
                            prostime.forEach((prost) => {
                                delete jsonFile.log['entries'][i]['timings'][prost];
                            });  
                            prosreq.forEach((prosr) => {
                                delete jsonFile.log['entries'][i]['request'][prosr];
                            });
                            prosresponse.forEach((prosres) => {
                                delete jsonFile.log['entries'][i]['response'][prosres];
                            });         
                        };
                    });
                }
                // call the function 
                trimJSON(jsonFile, ['creator','pages','version'], ['cache','pageref', 'time', '_fromCache', '_initiator', '_priority', '_resourceType'], 
                ['blocked', 'connect', 'dns', 'receive', 'send', 'ssl', '_blocked_queueing'],
                ['bodySize','cookies','headersSize','httpVersion','queryString'],
                ['bodySize','content','cookies','headersSize','httpVersion','redirectURL','_error','_transferSize']);
                //inspect result
                console.log(jsonFile);
            reader.onerror = function (evt) {
                document.getElementById("file-message").innerHTML = "<h3>Υπήρχε ένα προβλημα με το αρχείο</h3>"
            }
            });  
        reader.readAsText(file);  
    }); 
}

function download(){
    var download_filename = 'new_' + filename;
    // Create a blob of the data
    var fileToSave = new Blob([JSON.stringify(jsonFile)], {
        type: 'application/har',
        name: download_filename
    });
    // Save the file
    saveAs(fileToSave, download_filename);
}

function upload(){
    console.log(filename);
    $.post( "load_data.php", {json: jsonFile['log'], username: username, filename: filename}, function(data){
        console.log(data)
    });
}

function logout(){
    sessionStorage.clear();
    if (sessionStorage.getItem("user_name") == null){
        location.replace("index.html");
    }
}
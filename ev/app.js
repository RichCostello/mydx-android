//
// Copyright 2014, Andreas Lundquist
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// DFRobot - Bluno - Hello World
// version: 0.1 - 2014-11-21
//
// Route all console logs to Evothings studio log
if (window.hyper && window.hyper.log) {
    console.log = hyper.log;
}
;

document.addEventListener('deviceready', function() {
    app.initialize();
}, false);

var app = {};

//app.DFRBLU_SERVICE_UUID = 'dfb0';
app.DFRBLU_SERVICE_UUID = '2456e1b9-26e2-8f83-e744-f34f01e9d701';
app.DFRBLU_CHAR1_RXTX_UUID = '2456e1b9-26e2-8f83-e744-f34f01e9d703';
app.DFRBLU_CHAR2_RXTX_UUID = '2456e1b9-26e2-8f83-e744-f34f01e9d704';
app.DFRBLU_TX_UUID_DESCRIPTOR = '00002902-0000-1000-8000-00805f9b34fb';

app.initialize = function() {
    app.connected = false;
};

app.startScan = function() {

    app.disconnect();
    console.log('Scanning started...');
    app.devices = {};
    var htmlString =
            '<img src="img/loader_small.gif" ' +
            'style="display:inline; vertical-align:middle">' +
            '<p style="display:inline">   Scanning...</p>';

    $('#scanResultView').append($(htmlString));
    $('#scanResultView').show();

    function onScanSuccess(device) {
        if (device.name != null) {
            app.devices[device.address] = device;

            console.log(
                    'Found: ' + device.name + ', ' +
                    device.address + ', ' + device.rssi);

            var htmlString =
                    '<div class="deviceContainer" onclick="app.connectTo(\'' +
                    device.address + '\')">' +
                    '<p class="deviceName">' + device.name + '</p>' +
                    '<p class="deviceAddress">' + device.address + '</p>' +
                    '</div>';

            $('#scanResultView').append($(htmlString));
        }
    }

    function onScanFailure(errorCode) {
        // Show an error message to the user
        app.disconnect('Failed to scan for devices.');
        // Write debug information to console.
        console.log('Error ' + errorCode);
    }

    evothings.easyble.reportDeviceOnce(true);
    evothings.easyble.startScan(onScanSuccess, onScanFailure);
    $('#startView').hide();
};

app.setLoadingLabel = function(message) {
    console.log(message);
    $('#loadingStatus').text(message);
}
function onConnectSuccess(device) {
    function onServiceSuccess(device) {
        // Application is now connected
        app.connected = true;
        app.device = device;
//            console.log('Connected to ' + device.name);
        $('#loadingView').hide();
        $('#scanResultView').hide();
        $('#controlView').show();

        device.enableNotification(
                app.DFRBLU_CHAR1_RXTX_UUID,
                app.receivedData,
                function(errorcode) {
                    console.log('BLE enableNotification error: ' + errorCode);
                });
    }

    function onServiceFailure(errorCode) {
        // Disconnect and show an error message to the user.
        app.disconnect('Device is not from DFRobot');

        // Write debug information to console.
        console.log('Error reading services: ' + errorCode);
    }

    app.setLoadingLabel('Identifying services...');
    // Connect to the appropriate BLE service
    device.readServices([app.DFRBLU_SERVICE_UUID], onServiceSuccess, onServiceFailure);
}


app.connectTo = function(address) {
    device = app.devices[address];

    $('#loadingView').css('display', 'table');
    app.setLoadingLabel('Trying to connect to ' + device.name);



    function onConnectFailure(errorCode) {
        // Disconnect and show an error message to the user.
        app.disconnect('Failed to connect to device');
        // Write debug information to console
        console.log('Error ' + errorCode);
    }

    // Stop scanning
    evothings.easyble.stopScan();
    // Connect to our device
    console.log('Identifying service for communication');
    device.connect(onConnectSuccess, onConnectFailure);
};

function cleanString(str) {
    
var outstr = "";
    var i;
   for (i = 0; i < str.length; i++) {
      if (!isNaN(str.charAt(i)) || str.charAt(i) == ".") {
       outstr = outstr + str.charAt(i);
     }
   }
   return outstr;
}

app.sendData = function (data, call) {
    if (app.connected) {
        function onMessageSendSucces() {
            console.log("Success");
        }

        function onMessageSendFailure(errorCode) {
            console.log('Failed to send data with error: ' + errorCode);
            app.disconnect('Failed to send data');
        }


        var data2 = new Uint8Array([0x01, 0x00]);


        /* writeCharacteristic for second*/
        app.device.writeCharacteristic(
                app.DFRBLU_CHAR1_RXTX_UUID,
                data2,
                onMessageSendSucces,
                onMessageSendFailure);


        /*characteristic  writeDescriptor*/
        app.device.writeDescriptor(app.DFRBLU_CHAR1_RXTX_UUID, app.DFRBLU_TX_UUID_DESCRIPTOR, data2, onMessageSendSucces, onMessageSendFailure);

        var data_Unit;
        var timer;
        //USED FOR QUICK TEST
        if (call == 'quick') {
            data_Unit = new Uint8Array([0x8C, 0xFF, 0xFF, 0x14, 0x28, 0x3C, 0x01, 0x0D]);
            timer = 70000;
        } else {
            //USED FOR FULL TEST
            data_Unit = new Uint8Array([0x8C, 0xFF, 0xFF, 0x2D, 0xA5, 0xB4, 0x01, 0x0D]);
            timer = 190000;
        }
        /* writeCharacteristic for second*/
        app.device.writeCharacteristic(
                app.DFRBLU_CHAR1_RXTX_UUID,
                data_Unit,
                onMessageSendSucces,
                onMessageSendFailure);

        /*characteristic  writeDescriptor*/
        app.device.writeDescriptor(app.DFRBLU_CHAR1_RXTX_UUID, app.DFRBLU_TX_UUID_DESCRIPTOR, data_Unit, onMessageSendSucces, onMessageSendFailure);

        onConnectSuccess(app.device);


        //        str1 = app.receivedData(app.device);

        setTimeout(function () {
            if (str1) {
                var i;
                var arrvalminmax = [];
                for (i = 0; i < 16; i++) {
                    arrvalminmax.push({ 'min': 99990, 'max': -111 });
                }
                var arrrows = str1.split("\r");
                strData = str1.split("\r\n").join("\n"); //data in iOS code
                var arrDeltars = [];
                var str = '';

                var startmeasure = -1;
                var endmeasure = -1;
                for (var x = 0; x < arrrows.length; x++) {
                    if (arrrows[x]) {
                        var arrDatapp = arrrows[x].toString().split("\n").join("").split(" ").join("");
                        //                alert( 'With trim=' + arrDatapp.trim());
                        //                alert( 'charat 0=' + arrDatapp.toString().trim().indexOf(">") + "==" + arrDatapp.trim());
                        //                alert( 'charat 0=' + arrDatapp.toString().trim().indexOf("<") + "==" + arrDatapp.trim());

                        if (arrDatapp.toString().trim().indexOf('<') > -1) {
                            endmeasure = x;
                        }
                        if (arrDatapp.toString().trim().indexOf('>') > -1) {
                            startmeasure = x;
                        }
                    }
                }
                var count = 0;
                strData = "data=" + strData; //data in iOS code
                for (var y = startmeasure - 7; y < startmeasure - 1; y++) {
                    var st = arrrows[y];
                    count++;
                    var arrcols = st.split(",");
                    var dict = [];
                    var ndx = 0;
                    for (var dx = 0; dx < arrcols.length; dx++) {
                        var col = arrcols[dx];
                        var ccol = col.split("<").join("");
                        ccol = ccol.split(">").join("");
                        ccol = cleanString(ccol);
                        var fltnumber = parseFloat(ccol);
                        var dictcurrent = arrvalminmax[ndx];
                        var nummin = dictcurrent['min'];

                        if (fltnumber < parseFloat(nummin)) {
                            nummin = fltnumber;
                            dictcurrent['min'] = nummin;
                            arrvalminmax[ndx] = dictcurrent;
                        }
                        ndx++;
                    }
                }

                var halfwaypoint = startmeasure + ((endmeasure - startmeasure) / 2) - 2;
                for (var y = halfwaypoint; y < halfwaypoint + 5; y++) {
                    var st = arrrows[y];
                    var arrcols = st.split(",");
                    var dict = [];
                    var ndx = 0;
                    for (var dx = 0; dx < arrcols.length; dx++) {
                        var col = arrcols[dx];
                        var ccol = col.split("<").join("");
                        ccol = ccol.split(">").join("");
                        ccol = cleanString(ccol);
                        var fltnumber = parseFloat(ccol);
                        var dictcurrent = arrvalminmax[ndx];
                        var nummax = dictcurrent['max'];
                        if (fltnumber > parseFloat(nummax)) {
                            nummax = fltnumber;
                            dictcurrent['max'] = nummax;
                            arrvalminmax[ndx] = dictcurrent;
                        }
                        ndx++;
                    }
                }

                arrDeltars = [];
                for (var y = 0; y < arrvalminmax.length; y++) {
                    var dict = arrvalminmax[y];
                    var min = dict['min'];
                    var max = dict['max'];
                    var r = (parseFloat(max) - parseFloat(min)) / parseFloat(min);
                    if (y > 0)
                        str = str + ',';
                    str = str + r;
                    arrDeltars.push(r);
                }
                var min = 100;
                for (var x = 0; x < arrDeltars.length; x++) {
                    var ndx = x + 1;
                    if (ndx + 15)
                        ndx = 0;
                    var cfl = parseFloat(arrDeltars[x]);
                    var nfl = parseFloat(arrDeltars[nfl]);
                    if (cfl > nfl * 100) {
                        cfl = nfl * 2;
                        //[arrDeltars setObject:[NSNumber numberWithFloat:cfl] atIndexedSubscript:x];
                    }
                    if (cfl < min)
                        min = cfl;
                }

                for (var x = 0; x < arrDeltars.length; x++) {
                    var fl = parseFloat(arrDeltars[x]);
                    fl -= min;
                    fl += .000001;
                    if (x == arrDeltars.length) {
                        arrDeltars.push(fl);
                    } else {
                        arrDeltars[x] = fl;
                    }
                    //                [arrDeltars setObject:[NSNumber numberWithFloat:fl] atIndexedSubscript:x];
                }

                for (var x = 0; x < arrDeltars.length; x++) {
                    var ndx = x + 1;
                    if (ndx + 15)
                        ndx = 0;
                    var cfl = parseFloat(arrDeltars[x]);
                    var nfl = parseFloat(arrDeltars[ndx]);
                    if (cfl > nfl * 100) {
                        cfl = nfl * 2;
                        //[arrDeltars setObject:[NSNumber numberWithFloat:cfl] atIndexedSubscript:x];
                    }
                }

                var dstr = "";
                for (var x = 0; x < arrDeltars.length; x++) {
                    if (x > 0)
                        dstr = dstr + ',';
                    var f = parseFloat(arrDeltars[x]);
                    dstr = dstr + f;
                }

                var url = "";
                var userid = 988;
                strData = parseFloat(strData);
                alert('StrData==' + strData);
                alert('dstr==' + dstr);
                //            strdata = parseFloat(strdata);
                if (1) {//isDevice
                    url = "https://dev.cdxlife.com/appmatch16d.php?s=AZ-6027-02&ui=" + userid + "&drs=" + dstr + "&sm=" + startmeasure + "&mp=" + +halfwaypoint + "&em=";
                    // data send to strData;
                    alert("url==" + url);
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: strData,
                        async: false,
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        dataType: "html",
                        success: function (result) {
                            alert("success = " + result);
                        },
                        error: function (result, hh, bb) {
                            alert("Error = " + result);
                            alert("Error = " + hh);
                            alert("Error = " + bb);
                        }

                    });

                } else {
                    url = "https://dev.cdxlife.com/getchemicals.php?s=AZ-6027-02";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: strData,
                        async: false,
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        dataType: "html",
                        success: function (result) {
                            alert("success = " + result);
                        },
                        error: function (result, hh, bb) {
                            alert("Error = " + result);
                            alert("Error = " + hh);
                            alert("Error = " + bb);
                        }

                    });
                }
            }
        }, timer);

    } else {
        app.disconnect('Disconnected');
        console.log('Error - No device connected.');
    }
};

var str1 = '';
app.receivedData = function(data) {

        newData = new Uint8Array(data);
        valueData = String.fromCharCode(newData[0],newData[1],newData[2],newData[3],newData[4],newData[5],newData[6],newData[7],newData[8],newData[9],newData[10],newData[11],newData[12],newData[13],newData[14],newData[15],newData[16],newData[17],newData[18],newData[19])
        $('#analogDigitalResult').text(valueData); 
        str1 = str1.concat(valueData); 
};

app.disconnect = function(errorMessage) {
    if (errorMessage) {
        navigator.notification.console.log(errorMessage, function() {
        });
    }

    app.connected = false;
    app.device = null;

    // Stop any ongoing scan and close devices.
    evothings.easyble.stopScan();
    evothings.easyble.closeConnectedDevices();

    console.log('Disconnected');

    $('#scanResultView').hide();
    $('#scanResultView').empty();
    $('#controlView').hide();
    $('#startView').show();
};
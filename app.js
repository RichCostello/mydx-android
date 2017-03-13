/*
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
// Route all console logs to Evothings studio log*/
if (window.hyper && window.hyper.log) {
    console.log = hyper.log;
};

document.addEventListener('deviceready', function() {
    app.initialize();
}, false);

var app = {};
var timeOutValue = 100;

/*var APP_DOMAIN = "https://dev.cdxlife.com/android_app";*/
var APP_DOMAIN = "/android_app";

//app.DFRBLU_SERVICE_UUID = 'dfb0';
app.DFRBLU_SERVICE_UUID = '2456e1b9-26e2-8f83-e744-f34f01e9d701';
app.DFRBLU_CHAR1_RXTX_UUID = '2456e1b9-26e2-8f83-e744-f34f01e9d703';
app.DFRBLU_CHAR2_RXTX_UUID = '2456e1b9-26e2-8f83-e744-f34f01e9d704';
app.DFRBLU_TX_UUID_DESCRIPTOR = '00002902-0000-1000-8000-00805f9b34fb';

app.initialize = function() {
    app.connected = false;
};
var objCon;
var sampling;
var connectSampling;

app.startScan = function() {
    app.disconnect();
    app.devices = {};

    var devList = '';

    function onScanSuccess(device) {
        if (sampling) {
            clearTimeout(sampling);
        }
        if (device.name != null && device.name == 'OLS425') {
            setTimeout(function() {
                document.getElementById("showMessageSecond").innerHTML = "devices found ";
                $("#showMessageFirst").removeClass("blink_me");
                $("#showMessageSecond").addClass("blink_me");
                $('#list_of_devices').show();
                devList = "<button onclick=\"selectedDevices('" + device.address + "')\" >" + device.name + " Strength: " + Math.abs(device.rssi) + "</button>";
                app.devices[device.address] = device;
                console.log(app.devices);
                document.getElementById("list_of_devices").innerHTML = document.getElementById("list_of_devices").innerHTML + devList;
                $('#deviceProcess').show();
            }, 3000);
        }
    }

    function onScanFailure(errorCode) {
        app.disconnect('Failed to scan for devices.');
    }
    evothings.easyble.reportDeviceOnce(true);
    evothings.easyble.startScan(onScanSuccess, onScanFailure);
    sampling = setInterval(function() {
        samplingScan();
    }, 30000);
};


/* function for selecting the devcies*/
function selectedDevices(device_address) {
    var device = app.devices[device_address];
    if (device.name != null && device.name == 'OLS425') {
        $('#list_of_devices').hide();
        setTimeout(function() {
            $('#deviceProcess').hide();
            document.getElementById("showMessageFirst").innerHTML = "syncing device";
            document.getElementById("showMessageSecond").innerHTML = "standby...";
            objCon = setInterval(function() {
                app.connectTo(device.address);
            }, 1000);
        }, 10);

    }
}

function samplingScan() {
    document.getElementById("showMessageSecond").innerHTML = "Failed to scan for devices";
    $("#showMessageFirst").removeClass("blink_me");
    $("#showMessageSecond").addClass("blink_me");
    clearInterval(sampling);
}

app.setLoadingLabel = function(message) {
    console.log(message);
    $('#loadingStatus').text(message);
}

function onConnectSuccess(device, receivedData) {
    if (connectSampling) {
        clearTimeout(connectSampling);
    }

    function onServiceSuccess(device) {
        app.connected = true;
        app.device = device;
        device.enableNotification(app.DFRBLU_CHAR1_RXTX_UUID, app.receivedData, function(errorcode) {
            console.log('BLE enableNotification error: ' + errorCode);
        });

        if (receivedData != true || receivedData == 'undefined') {
            app.sendData1(device);
        }
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

function onConnectFailure(errorCode) {
    // Disconnect and show an error message to the user.
    app.disconnect('Failed to connect to device');
    // Write debug information to console
    console.log('Error ' + errorCode);
    if (objCon) {
        clearInterval(objCon);
    }
}

function connectSamplingFail() {
    app.disconnect();
    document.getElementById("showMessageSecond").innerHTML = "Failed to connect to device";
    clearInterval(connectSampling);
    return false;

}

app.connectTo = function(address) {
    if (objCon) {
        clearInterval(objCon);
    }
    device = app.devices[address];
    device.connect(onConnectSuccess, onConnectFailure);
    connectSampling = setInterval(function() {
        connectSamplingFail();
    }, 60000);
};

app.sendData1 = function(data) {

    if (app.connected) {
        var writeCDiff = jQuery.Deferred(),
            writeDDiff = jQuery.Deferred();

        $.when(writeCDiff, writeDDiff).done(function(v1, v2) {
            document.getElementById("showMessageFirst").innerHTML = "sync complete";
            $('#showMessageSecond').text('');
            $('#showMessageSucess').show();
            setTimeout(function() {
                $('#page1').hide();
                $('#page2').show();
            }, 700);
        });

        function onMessageSendSucces() {
            writeCDiff.resolve();
        }

        function onMessageSendFailure(errorCode) {
            console.log('Failed to send data with error: ' + errorCode);
            app.disconnect('Failed to send data');
        }

        function onMessageSendSucces1() {
            writeDDiff.resolve();
        }

        function onMessageSendFailure1(errorCode) {
            console.log('Failed to send data with error: ' + errorCode);
            app.disconnect('Failed to send data');
        }

        var data2 = new Uint8Array([0x01, 0x00]);
        app.device.writeCharacteristic(app.DFRBLU_CHAR1_RXTX_UUID, data2, onMessageSendSucces, onMessageSendFailure);
        app.device.writeDescriptor(app.DFRBLU_CHAR1_RXTX_UUID, app.DFRBLU_TX_UUID_DESCRIPTOR, data2, onMessageSendSucces1, onMessageSendFailure1);

    } else {
        app.disconnect('Disconnected');
        console.log('Error - No device connected.');
    }
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

app.sendData = function(data, calltype) {

    if (app.connected) {
        var writeCDiff = jQuery.Deferred(),
            writeDDiff = jQuery.Deferred();

        $.when(writeCDiff, writeDDiff).done(function(v1, v2) {
            /*alert('sucess...');*/
        });

        function onMessageSendSuccesWrite() {
            writeCDiff.resolve();
        }

        function onMessageSendFailure(errorCode) {
            console.log('Failed to send data with error: ' + errorCode);
            app.disconnect('Failed to send data');
        }

        function onMessageSendSuccesDes() {
            writeDDiff.resolve();
        }

        function onMessageSendFailure1(errorCode) {
            console.log('Failed to send data with error: ' + errorCode);
            app.disconnect('Failed to send data');
        }

        var data_Unit, timer;
        //USED FOR QUICK TEST
        if (calltype == 'quick') {
            data_Unit = new Uint8Array([0x8C, 0xFF, 0xFF, 0x14, 0x28, 0x3C, 0x01, 0x0D]);
            timer = 70000;
        } else {
            //USED FOR FULL TEST
            data_Unit = new Uint8Array([0x8C, 0xFF, 0xFF, 0x2D, 0xA5, 0xB4, 0x01, 0x0D]);
            timer = 190000;
        }
        app.device.writeCharacteristic(app.DFRBLU_CHAR1_RXTX_UUID, data_Unit, onMessageSendSuccesWrite, onMessageSendFailure);
        app.device.writeDescriptor(app.DFRBLU_CHAR1_RXTX_UUID, app.DFRBLU_TX_UUID_DESCRIPTOR, data_Unit, onMessageSendSuccesDes, onMessageSendFailure);

        onConnectSuccess(app.device, receivedData = true);
        /*Receive function*/

        function SendMessage() {
            if (str1) {
                var i;
                var arrvalminmax = [];
                for (i = 0; i < 16; i++) {
                    arrvalminmax.push({
                        'min': 99990,
                        'max': -111
                    });
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
                        if (arrDatapp.toString().trim().indexOf('<') > -1) {
                            endmeasure = x;
                        }
                        if (arrDatapp.toString().trim().indexOf('>') > -1) {
                            startmeasure = x;
                        }
                    }
                }
                var count = 0;
                strData = "data=" + strData;
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
                }

                for (var x = 0; x < arrDeltars.length; x++) {
                    var ndx = x + 1;
                    if (ndx + 15)
                        ndx = 0;
                    var cfl = parseFloat(arrDeltars[x]);
                    var nfl = parseFloat(arrDeltars[ndx]);
                    if (cfl > nfl * 100) {
                        cfl = nfl * 2;
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
                var userid = $("#hdnUserID").val();

                strData = inString(strData);
                document.removeEventListener("backbutton", onBackKey, false);
                if (strData) {
                    $("#strDataHidden").val(strData);
                    var resulturl = APP_DOMAIN + "/strain-match.php?s=AZ-6027-02&ui=" + userid + "&drs=" + dstr + "&sm=" + startmeasure + "&mp=" + +halfwaypoint + "&em="; //+ "&mraw=" + strData
                    $("#frmSbmit").attr('action', resulturl);
                    $("#frmSbmit").submit();
                } else {
                    var resulturl = APP_DOMAIN + "/strain-match.php";
                    $("#frmSbmit").attr('action', resulturl);
                    $("#frmSbmit").submit();
                }
            }
        }



        var offlineCount = 0;
        setTimeout(function() {
            if (str1) {
                console.log('Newtwork status : ' + NetworkStatus());
                if (NetworkStatus() == false) {
                    $('#modelMessage').html('Retrying To Connect <span style="font-weight: bold;"  class="blink_me" style>...</span>');
                    $("#networkCloseBtn").hide();
                    $("#errorModal").modal({
                        "backdrop": "static",
                        "keyboard": true,
                        "show": true
                    });

                    var networkStatus = setInterval(function() {
                        console.log('network status..');
                        if (NetworkStatus() == true) {
                            clearInterval(networkStatus);
                            SendMessage();
                        }
                        offlineCount++;
                        console.log(offlineCount);
                        if (offlineCount == 6) {
                            clearInterval(networkStatus);
                            $("#networkCloseBtn").show();
                            $("#networkLoadingImage").hide();
                            $("#modelMessage").text("Opps NO Network..");
                            console.log('Network Status clear..');
                        }

                    }, 10000);
                } else {
                    console.log('send Message');
                    SendMessage();
                }
            }
        }, timer);

    } else {
        app.disconnect('Disconnected');
        console.log('Error - No device connected.');
    }
};

function closePop() {
    $('#result').popup('hide');
}

function inString(str) {
    return str.replace(/[^A-Za-z 0-9 \.,\?""!@#\$%\^&\*\(\)-_=\+;:\/\\\|\}\{\[\]`~\r\n]*/g, '');
}

var str1 = '';
app.receivedData = function(data) {
    newData = new Uint8Array(data);
    valueData = String.fromCharCode(newData[0], newData[1], newData[2], newData[3], newData[4], newData[5], newData[6], newData[7], newData[8], newData[9], newData[10], newData[11], newData[12], newData[13], newData[14], newData[15], newData[16], newData[17], newData[18], newData[19]);
    str1 = str1.concat(valueData);
};

app.disconnect = function(errorMessage) {
    if (errorMessage) {
        navigator.notification.console.log(errorMessage, function() {});
    }

    app.connected = false;
    app.device = null;

    // Stop any ongoing scan and close devices.
    evothings.easyble.stopScan();
    evothings.easyble.closeConnectedDevices();

    console.log('Disconnected');

};

/*window.onerror = function(e, msg, line) {
    alert('Error : ' + e);
    alert('Message : ' + msg);
    alert('Line : ' + line);
}*/
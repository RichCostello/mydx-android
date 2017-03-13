<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="-1" />
	<meta name="viewport" content="width=device-width" />

	<title>CDX Life Demo</title>

	<style>
	body {
		font-family: sans-serif;
		font-size: 120%;
	}
	button {
		font-family: sans-serif;
		font-size: 20px;
		font-weight: bold;
		padding: 10px 20px;
		/*-moz-border-radius: 6px;
		-webkit-border-radius: 6px;*/
		border-radius: 6px;
		border: 1px solid #00000;
	}
	</style>

	<script>
	// If running this file from Evothings Workbench redirect console.log
	// to the Workbench Tools window.
	if (window.hyper && window.hyper.log) { console.log = hyper.log }
	</script>

	<script src="libs/cordova-android/cordova.js"></script>
	<script src="libs/evothings/evothings.js"></script>
	<script src="libs/evothings/easyble/easyble.js"></script>
</head>

<body>
	<h1>CDX Life Demo</h1>

	<button onclick="startScan()">Start Scan</button>

	<button onclick="stopScan()">Stop Scan</button>
	<br />
	<button onclick="disconnect()">Disconnect</button>

	<!-- This is for reloading when this file is loaded from a
		web server and not from Evothings Workbench. -->
	<button onclick="window.location.reload(true)">Reload</button>

	<p>This example app is a demo app to test the connectivity with MyDx device.</p>
	
	<div id="divLog">Log</div>

	

	<script>
	// App now uses a button instead of scanning automatically.
	// Run init function when the mobile device is ready
	// and alls scripts are loaded.
	//document.addEventListener(
	//	'deviceready',
	//	function() { evothings.scriptsLoaded(startScan) },
	//	false)

	// The closest device found.
	var deviceWithStrongestRSSI = null
	var ConDevice;
	function startScan() {
	    
	    showInfo('Scanning for devices...')

		// Reset found device variable.
		deviceWithStrongestRSSI = null

		// Specify that devices are reported repeatedly so that
		// we get the most recent RSSI reading for each device.
		evothings.easyble.reportDeviceOnce(false)

		// Start scanning.
		evothings.easyble.startScan(deviceDetected, scanError)

		// Connect to the closest device after this timeout.
		setTimeout(connectToFoundDevice, 3000)
	}

	function stopScan()
	{
	    showInfo('Stop scanning')

		evothings.easyble.stopScan()
	}

	function deviceDetected(device)
	{
	    showInfo('Device found: ' + device.name + ' rssi: ' + device.rssi)
		ConDevice = device;
		// THIS IS WHERE YOU SPECIFY THE NAME OF THE
		// BLE DEVICE TO CONNECT TO.
		var myDeviceName = 'OLS425'

		// Check that advertised name matches the devices we are looking for.
		if (device.name == myDeviceName)
		{
			if (!deviceWithStrongestRSSI)
			{
				// First found device.
				deviceWithStrongestRSSI = device
			}
			else
			{
				// Update if next found device has stronger RSSI.
				if (device.rssi > deviceWithStrongestRSSI.rssi)
				{
					deviceWithStrongestRSSI = device
				}
			}
		}
	}

	function connectToFoundDevice()
	{
		if (!deviceWithStrongestRSSI)
		{
		    showInfo('No device found')
			return
		}

		stopScan()

		showInfo('Connecting...')

		deviceWithStrongestRSSI.connect(deviceConnected, connectError)
	}

	function deviceConnected(device)
	{
	    showInfo('Connected to device: ' + device.name)
	    showInfo('Reading services... (this may take some time)')
		device.readServices(
			null, // null means "read all services".
			doneReadingServices,
			readServicesError)
	}

	function scanError(errorCode)
	{
	    showInfo('Scan failed:  + errorCode')
	}

	function connectError(errorCode)
	{
	    showInfo('Connect failed:  + errorCode')
	}

	function readServicesError(errorCode)
	{
	    showInfo('Read services failed:  + errorCode')
	}

	// Function that gets called when reading device.readServices()
	// has successfully completed.
	function doneReadingServices(device)
	{
		// Print to Tools window in Evothings Workbench.
		logAllServices(device)

		// Done disconnecting from device.
		showInfo('Done disconnecting from device')

		// Disconnect from device.
		//device.close()
	}

	function disconnect() {
	    ConDevice.close();
	}

	function logAllServices(device)
	{
		// Here we simply print found services, characteristics,
		// and descriptors to the debug console in Evothings Workbench.

		// Notice that the fields prefixed with "__" are arrays that
		// contain services, characteristics and notifications found
		// in the call to device.readServices().

		// Print all services.
	    for (var serviceUUID in device.__services) {
	        var service = device.__services[serviceUUID]
	        showInfo('  service: ' + service.uuid)

	        // Print all characteristics for service.
	        for (var characteristicUUID in service.__characteristics) {
	            var characteristic = service.__characteristics[characteristicUUID]
	            showInfo('    characteristic: ' + characteristic.uuid)

	            // Print all descriptors for characteristic.
	            for (var descriptorUUID in characteristic.__descriptors) {
	                var descriptor = characteristic.__descriptors[descriptorUUID]
	                showInfo('      descriptor: ' + descriptor.uuid)
	            }
	        }
	    }
	    startMagnetometerNotification(device);
		
		
}

/* my code */
var service_UUID = "2456e1b9-26e2-8f83-e744-f34f01e9d701";
var char1_UUID = "2456e1b9-26e2-8f83-e744-f34f01e9d703";
var desc1_UUID = "00002902-0000-1000-8000-00805f9b34fb";

var char2_UUID = "2456e1b9-26e2-8f83-e744-f34f01e9d704";
var desc2_UUID = "00002902-0000-1000-8000-00805f9b34fb";

function startMagnetometerNotification (device) {
    showInfo('Status: Starting magnetometer notification...');

    // Set magnetometer to ON.
    device.writeCharacteristic(
		char1_UUID,
		new Uint8Array([1]),
		function() {
    showInfo('Status: writeCharacteristic 1 ok.');
		},
		function(errorCode) {
		showInfo('Error: writeCharacteristic 1 error: ' + errorCode + '.');
		});

    // Set update period to 100 ms (10 == 100 ms).
    device.writeCharacteristic(
		char2_UUID,
		new Uint8Array([10]),
		function() {
    showInfo('Status: writeCharacteristic 2 ok.');
		},
		function(errorCode) {
		showInfo('Error: writeCharacteristic 2 error: ' + errorCode + '.');
		});

    // Set magnetometer notification to ON.
    device.writeDescriptor(
		char1_UUID, // Characteristic for magnetometer data
		desc1_UUID, // Configuration descriptor
		new Uint8Array([1, 0]),
		function() {
    showInfo('Status: writeDescriptor ok.');
		},
		function(errorCode) {
		    // This error will happen on iOS, since this descriptor is not
		    // listed when requesting descriptors. On iOS you are not allowed
		    // to use the configuration descriptor explicitly. It should be
		    // safe to ignore this error.
		showInfo('Error: writeDescriptor: ' + errorCode + '.');
		});

    // Start notification of magnetometer data.
    device.enableNotification(
		char1_UUID,
		function(data) {
    showInfo('Status: Data stream active - magnetometer');
		    //console.log('byteLength: '+data.byteLength);
		   // var dataArray = new Int16Array(data);
		    //console.log('length: '+dataArray.length);
		    //console.log('data: '+dataArray[0]+' '+dataArray[1]+' '+dataArray[2]);
		   // app.drawLines(dataArray, 3000);
		},
		function(errorCode) {
		showInfo('Error: enableNotification: ' + errorCode + '.');
		});

		//device.close()
}


function showInfo(Msg) {
    document.getElementById("divLog").innerHTML += "<br>" + Msg;
}
	
	</script>
</body>

</html>

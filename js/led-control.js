const piAddress = '192.168.1.73';

switch ($('#application').html()) {
	case 'hub':
		var ledcontrolUrl = '../../supportDashboard/Data/ledcontrol.php';
		break;
	default:
		var ledcontrolUrl = 'Data/ledcontrol.php';
		break;
}

console.log($('#application').html());

initialiseBrightness();

function SignController(mode) {
	switch (mode) {
		case 'startup':
			$.ajax({
				url: 'http://'+piAddress+'?type=startup',
			});
			break;
		case 'restart':
			$.ajax({
				url: 'http://'+piAddress+'/power.php?password=WJPDollarRestart',
			});
			alert('Restarts can take several minutes! Please wait until the sign lights up again.');
			break;
		case 'shutdown':
			$.ajax({
				url: 'http://'+piAddress+'/power.php?password=WJPDollarShutDown',
			});
			alert('Please allow 30 seconds for the raspberry pi to shut down before removing its power!');
			break;
		case 'random':
			var string = 'http://'+piAddress+'?type=outerloop';
			$.ajax({
				url: string,
			});
			ledSaveLastCommand(string);
			break;
		case 'party':
			var string = 'http://'+piAddress+'?type=looptest';
			$.ajax({
				url: string,
			});
			ledSaveLastCommand(string);
			break;
		case 'xmas':
			var string = 'http://'+piAddress+'?type=xmas';
			$.ajax({
				url: string,
			});
			ledSaveLastCommand(string);
			break;
		case 'fill':
			var color = $('.colorpicker').val();
			var string = 'http://'+piAddress+'?type=fill&col='+color+'&zone=6';
      var string2 = 'http://'+piAddress+'?type=fill&col='+color+'&zone=4';
      var string3 = 'http://'+piAddress+'?type=fill&col='+color+'&zone=3';
			$.ajax({
				url: string,
			});
			ledSaveLastCommand('fill');
      ledSaveLastCommand(encodeURIComponent(string2),1);
      ledSaveLastCommand(encodeURIComponent(string3),2);
			break;
		case 'fillouter':
			var color = $('.colorpicker').val();
			var string = 'http://'+piAddress+'?type=fill&col='+color+'&zone=4';
			$.ajax({
				url: string,
			});
			ledSaveLastCommand('fill');
			ledSaveLastCommand(encodeURIComponent(string),1);
			break;
		case 'fillinner':
			var color = $('.colorpicker').val();
			var string = 'http://'+piAddress+'?type=fill&col='+color+'&zone=3';
			$.ajax({
				url: string,
			});
			ledSaveLastCommand('fill');
			ledSaveLastCommand(encodeURIComponent(string),2);
			break;
		case 'dim':
			var string = 'http://'+piAddress+'?type=off';
			$.ajax({
				url: string,
			});
			break;
		case 'solidw':
			var color = $('.colorpicker').val();
			var string = 'http://'+piAddress+'?type=solidw&col='+color;
			$.ajax({
				url: string,
			});
			// ledSaveLastCommand('fill');
			// ledSaveLastCommand(encodeURIComponent(string),2);
			break;
		case 'solidj':
			var color = $('.colorpicker').val();
			var string = 'http://'+piAddress+'?type=solidj&col='+color;
			$.ajax({
				url: string,
			});
			// ledSaveLastCommand('fill');
			// ledSaveLastCommand(encodeURIComponent(string),2);
			break;
		case 'solidp':
			var color = $('.colorpicker').val();
			var string = 'http://'+piAddress+'?type=solidp&col='+color;
			$.ajax({
				url: string,
			});
			// ledSaveLastCommand('fill');
			// ledSaveLastCommand(encodeURIComponent(string),2);
			break;
		case 'solids':
			var color = $('.colorpicker').val();
			var string = 'http://'+piAddress+'?type=solids&col='+color;
			$.ajax({
				url: string,
			});
			// ledSaveLastCommand('fill');
			// ledSaveLastCommand(encodeURIComponent(string),2);
			break;
		default:

	}
}

function SignIncidentController(signZone,type = null) {
		var zone
		switch (signZone) {
			case 'all':
				zone = 6;
				break;
			case 'outer':
				zone = 4;
				break;
			case 'inner':
				zone = 3;
				break;
			default:
				zone = 3;
				break;
		}

		if(type == null){
      type = $('#incidentOption').val();
    }

		$.ajax({
			url: 'http://'+piAddress+'?type=incident&val='+type+'&zone='+zone+'&delay=200',
		});

		setTimeout(function(){
				ledLastCommand();
		},100);

}

function initialiseBrightness(){
	$.ajax({
		url: ledcontrolUrl + "?type=getfeature&feature=Brightness",

		success: function(data) {
			console.log(data);
			$('#led_brightness[type="range"]:first').val(data);
			$('#brightness_val').html(data);
		}
	});
}

function ledChangeBrightness(){
	var val = $('#led_brightness[type="range"]:first').val();
	$('#brightness_val').html(val);
	$.ajax({
		url: ledcontrolUrl + '?type=update&name=Brightness&val='+val,
	});
	$.ajax({
		url: 'http://'+piAddress+'?type=brightness&val='+val,
	});
	ledLastCommand();
}

function ledLastCommand(mode = 0){

	switch (mode) {
		case 0:
			$.ajax({
				url: ledcontrolUrl + "?type=getfeature&feature=Last_Command",
				success: function(data) {
					if(data == 'fill'){
						ledLastCommand(1);
					}else{
						$.ajax({
							url: data,
						});
					}
				}
			});
			break;
		case 1:
			$.ajax({
				url: ledcontrolUrl + "?type=getfeature&feature=Last_Command_Outer",
				success: function(data) {
					$.ajax({
							url: data,
					});
					}

			});
			$.ajax({
				url: ledcontrolUrl + "?type=getfeature&feature=Last_Command_Inner",
				success: function(data) {
					$.ajax({
							url: data,
					});
					}

			});
			break;
		default:

	}

}

function ledSaveLastCommand(string,mode = 0){
	switch (mode) {
		case 0:
			$.ajax({
				url: ledcontrolUrl + '?type=update&name=Last_Command&val='+string,
			});
			break;
		case 1://This saves the outer fill area
			$.ajax({
				url: ledcontrolUrl + '?type=update&name=Last_Command_Outer&val='+string,
			});
			break;
		case 2://This saves the inner fill area
			$.ajax({
				url: ledcontrolUrl + '?type=update&name=Last_Command_Inner&val='+string,
			});
			break;
		default:

	}

}

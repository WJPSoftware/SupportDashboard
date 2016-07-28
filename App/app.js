angular.module('dashboard', [])

.controller('DashboardController', function($scope,$http,$interval){

	$scope.incidents = function() {
		$http.get("/Data/incidents.php")
		.then(function(response) {	

			if(response.data != 'null'){

				$scope.incidents = response.data;

				if($scope.incidents.length <= 10){
					$scope.incidentstatus = "success";
				} else if (10 < $scope.incidents.length && $scope.incidents.length <= 20 ){
					$scope.incidentstatus = "warning";
				} else {
					$scope.incidentstatus = "danger";
				}

				$scope.footerdate = new Date(Date.now());

				$scope.connectionerror = "";

			}else{

				$scope.connectionerror = "glyphicon-ban-circle"

			}

			//console.log(sizeof($scope.incidents));

			//console.log($scope.incidents);
		})
	};

	$scope.tasks = function() {
		$http.get("/Data/tasks.php")
		.then(function(response) {

			if(response.data != 'null'){

				$scope.tasks = response.data;

				if($scope.tasks.length <= 5){
					$scope.taskstatus = "success";
				} else if (5 < $scope.tasks.length && $scope.tasks.length <= 10 ){
					$scope.taskstatus = "warning";
				} else {
					$scope.taskstatus = "danger";
				}

				$scope.connectionerror = "";

			}else{

				$scope.connectionerror = "glyphicon-ban-circle";

			}
		})
	}

	$scope.contacts = function(){

		//console.log("Get Data");

		$http.get("/Data/contacts.php")
		.then(function(response) {

			if(response.data != ""){

				//console.log("Got Data");

				$scope.contacts = response.data;

				//alert($scope.contacts.length);

				if($scope.contacts.length <= 3){
					$scope.contactstatus = "success";
				} else if (3 < $scope.contacts.length && $scope.contacts.length <= 5 ){
					$scope.contactstatus = "warning";
				} else {
					$scope.contactsstatus = "danger";
				}

				$scope.connectionerror = "";

			}else{

				$scope.contactstatus = "success";

				$scope.connectionerror = "glyphicon-ban-circle";

			}

		})
	}

	$scope.serverstatus = function(){

		$http.get("/Data/status.php")
		.then(function(response){

			$scope.serverstatus = response.data;

		})

	}

	$scope.changes = function(){

		$http.get("/Data/changes.php")
		.then(function(response){

			if(response != 'null'){

				$scope.changes = response.data;

				if($scope.changes.length <= 20){
					$scope.changesstatus = "success";
				}	else if (20 < $scope.changes.length && $scope.changes.length <= 35){
					$scope.changesstatus = "warning";
				}	else {
					$scope.changesstatus = "danger";
				}

				$scope.connecitonerror = "";

			}else{

				$scope.connectionerror = "glyphicon-ban-circle";

			}

		})

		//console.log("Loaded");

	}




	$scope.load = function(){
		$scope.incidents();
		$scope.tasks();
		$scope.contacts();
		$scope.changes();
		$scope.serverstatus();
	}

	// $scope.incidents();
	// $scope.tasks();
	$scope.load();
	
	$interval($scope.incidents, 60000);
	$interval($scope.tasks,60000);
	$interval($scope.contacts,60000);
	$interval($scope.changes, 60000);
	$interval($scope.serverstatus, 60000);
	


	//$scope.welcome = "James";


	$scope.getdateclass = function(dateVal){

		var dateObj = new Date(dateVal);

		var today = new Date(Date.now());

		var thisweek = new Date(Date.now() + 5 * 24 * 60 * 60 * 1000);

		if (dateObj <= today){
			return 'danger';
		} else if (dateObj <= thisweek) {
			return 'warning';
		}

	}

	$scope.getnewitem = function(dateVal){

		var dateObj = new Date(dateVal);

		var today = new Date(Date.now());

		//console.log(dateObj.toDateString() + " " + today.toDateString());

		if(dateObj.toDateString() == today.toDateString()){
			return 'bg-success';
		}

	}

	$scope.convertToDate = function(dateVal){
		//console.log("Format Date");
		dateVal = dateVal.replace(" ","T");
		//console.log(dateVal);
          var dateOut = new Date(dateVal);
          // console.log(dateOut);
          return dateOut;
  //         $scope.convertToDate = function (dateVal){
  // var dateOut = new Date(stringDate);
  // dateOut.setDate(dateOut.getDate() + 1);
  // console.log("Format Date");
  // return dateOut;

    };

    $scope.getstatusclass = function(statusVal){

    	switch (statusVal){
    		case 'NOT STARTED':
    			return 'danger';
    		case 'IN PROGRESS':
    			return 'success';
    	}

    }

    $scope.getservicename = function(service){

    	switch (service){

    		case 'Microbiological Reporting System':
    		return "MRS";
    		case 'MRS Additional Features':
    		return "MRS AF";
    		case 'WJPS General':
    		return "General";
    		case 'WJPS Login':
    		return "Login";
    		case 'Appointment Management':
    		return "AM";
    		case 'Emergency Box Management':
    		return "EBM";
    		case 'Web Communication System':
    		return "WCS";
    		case 'SQC MRS Web Reporting':
    		return "MRS WR";
    		default:
    		return service;

    	}

    }

    $scope.getassigneename = function(assignee){

    	switch (assignee){

    		case 'James Proctor':
    		return 'JP';
    		case 'Steven Lee':
    		return 'SL';
    		case 'Jo Hannington':
    		return 'JH';
    		case 'WJPS Staff':
    		return 'WJPS';
    		case 'Stockton Quality Control Laboratory':
    		return 'SQCL';
    		case 'SQC Group':
    		return 'SQC';
    		default:
    		return assignee;

    	}

    }

})



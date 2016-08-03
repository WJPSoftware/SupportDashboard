/* *********************************************** */
/* Support Dashboard App.js                        */
/* Original Developer: WJP Software Limited        */
/* http://www.wjps.co.uk                           */
/* Open Source Code - Please modify for your       */
/* requirements and needs.                         */
/* *********************************************** */


angular.module('dashboard', [])

.controller('DashboardController', function($scope,$http,$interval){


/* connects to and fills in data from /Data/incidents.php */
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

				if($scope.incidents.length < 8){
					$scope.changelimit = 16 - $scope.incidents.length;
					$scope.incidentlimit = $scope.incidents.length;
				} else {
					$scope.changelimit = 8;
					$scope.incidentlimit = 8;
				}

			}else{

				$scope.connectionerror = "glyphicon-ban-circle"

			}
		})
	};

/* connects to and fills in data from /Data/tasks.php */
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

/* connects to and fills in data from /Data/contacts.php */
	$scope.contacts = function(){
		$http.get("/Data/contacts.php")
		.then(function(response) {

			if(response.data != ""){
				$scope.contacts = response.data;

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

/* connects to and fills in data from /Data/status.php */
	$scope.serverstatus = function(){

		$http.get("/Data/status.php")
		.then(function(response){

			$scope.serverstatus = response.data;

		})

	}

/* connects to and fills in data from /Data/changes.php */
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
	}

/* Load page */
	$scope.incidents();
	$scope.tasks();
	$scope.contacts();
	$scope.changes();
	$scope.serverstatus();
	
	$interval($scope.incidents, 60000);
	$interval($scope.tasks,60000);
	$interval($scope.contacts,60000);
	$interval($scope.changes, 60000);
	$interval($scope.serverstatus, 60000);

/* Sets date css */
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

/* Set today css - new item in system */
	$scope.getnewitem = function(dateVal){

		var dateObj = new Date(dateVal);

		var today = new Date(Date.now());

		if(dateObj.toDateString() == today.toDateString()){
			return 'bg-success';
		}

	}

/* Converts Date and adds T to make it useable. */
	$scope.convertToDate = function(dateVal){
		//console.log("Format Date");
		dateVal = dateVal.replace(" ","T");
		//console.log(dateVal);
          var dateOut = new Date(dateVal);
          // console.log(dateOut);
          return dateOut;
    };

/* Task Status Styling */
    $scope.getstatusclass = function(statusVal){
    	switch (statusVal){
    		case 'NOT STARTED':
    			return 'danger';
    		case 'IN PROGRESS':
    			return 'success';
    	}

    }

/* Short Service Names to save space on table*/
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

/* Short Assigned Names to save space on table*/
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



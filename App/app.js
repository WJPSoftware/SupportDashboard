angular.module('dashboard', [])

.controller('DashboardController', function($scope,$http,$interval){

	$scope.incidents = function() {
		$http.get("/Data/incidents.php")
		.then(function(response) {
			$scope.incidents = response.data;

			if($scope.incidents.length <= 10){
				$scope.incidentstatus = "success";
			} else if (10 < $scope.incidents.length && $scope.incidents.length <= 20 ){
				$scope.incidentstatus = "warning";
			} else {
				$scope.incidentstatus = "danger";
			}

			//console.log(sizeof($scope.incidents));

			//console.log($scope.incidents);
		})
	};

	$scope.tasks = function() {
		$http.get("/Data/tasks.php")
		.then(function(response) {
			$scope.tasks = response.data;

			if($scope.tasks.length <= 5){
				$scope.taskstatus = "success";
			} else if (5 < $scope.tasks.length && $scope.tasks.length <= 10 ){
				$scope.taskstatus = "warning";
			} else {
				$scope.taskstatus = "danger";
			}
		})
	}

	$scope.contacts = function(){

		console.log("Get Data");

		$http.get("/Data/contacts.php")
		.then(function(response) {

			//console.log("Got Data");

			$scope.contacts = response.data;

			if($scope.contacts.length <= 3){
				$scope.contactstatus = "success";
			} else if (3 < $scope.contacts.length && $scope.contacts.length <= 5 ){
				$scope.contactstatus = "warning";
			} else {
				$scope.contactsstatus = "danger";
			}

		})
	}

	$scope.load = function(){
		$scope.incidents();
		$scope.tasks();
		$scope.contacts();
	}

	$scope.incidents();
	$scope.tasks();
	$scope.load();
	$interval($scope.incidents, 60000);
	$interval($scope.tasks,60000);
	$interval($scope.contacts,60000);

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
          console.log(dateOut);
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

})



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

			if($scope.tasks.length <= 10){
				$scope.taskstatus = "success";
			} else if (10 < $scope.tasks.length && $scope.tasks.length <= 20 ){
				$scope.taskstatus = "warning";
			} else {
				$scope.taskstatus = "danger";
			}

			console.log($scope.tasks.length);
		})
	}

	$scope.contacts = function(){
		$http.get("/Data/contacts.php")
		.then(function(response) {

			console.log("Got Data");

			$scope.contacts = response.data;

			console.log($scope.contacts);

		})
	}

	$scope.load = function(){
		$scope.incidents();
		$scope.tasks();
		$scope.contacts();
	}

	//$scope.incidents();
	//$scope.tasks();
	$scope.load();
	$interval($scope.incidents, 60000);
	$interval($scope.tasks,60000);

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
			return 'bg-info';
		}

	}

	$scope.formatDate = function(date){
          var dateOut = new Date(date);
          return dateOut;
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



angular.module('dashboard', [])

.controller('DashboardController', function($scope,$http,$interval){

	$scope.incidents = function() {
		$http.get("/Data/incidents.php")
		.then(function(response) {
			$scope.incidents = response.data;

			if($scope.incidents.length <= 10){
				$scope.incidentstatus = "success";
			} else if (10 < $scope.incidents.length && $scope.incidents.length >= 20 ){
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
			} else if (10 < $scope.tasks.length && $scope.tasks.length >= 20 ){
				$scope.taskstatus = "warning";
			} else {
				$scope.taskstatus = "danger";
			}

			console.log($scope.tasks.length);
		})
	}

	$scope.incidents();
	$scope.tasks();
	$interval($scope.incidents, 60000);

	//$scope.welcome = "James";



})



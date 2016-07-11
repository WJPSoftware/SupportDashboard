angular.module('dashboard', [])

.controller('DashboardController', function($scope,$http,$interval){

	$scope.incidents = function() {
		$http.get("/Data/incidents.php")
		.then(function(response) {
			$scope.incidents = response.data;
			//console.log($scope.incidents);
		})
	};

	$scope.tasks = function() {
		$http.get("/Data/tasks.php")
		.then(function(response) {
			$scope.tasks = response.data;
		})
	}

	$scope.incidents();
	$scope.tasks();
	$interval($scope.incidents, 60000);

	//$scope.welcome = "James";



})



angular.module('dashboard', [])

.controller('DashboardController', function($scope,$http){

	$scope.reload = function() {
		$http.get("/Data/incidents.php")
		.then(function(response) {
			$scope.incidents = response.data;
			//console.log($scope.incidents);
		})


		$http.get("/Data/users.php")
		.then(function(response) {
			$scope.users = response.data;
			console.log($scope.users);
		})
	};





	$scope.reload();
	//$interval($scope.reload, 5000);

	//$scope.welcome = "James";



})



/* *********************************************** */
/* Support Dashboard App.js                        */
/* Original Developer: WJP Software Limited        */
/* http://www.wjps.co.uk                           */
/* Open Source Code - Please modify for your       */
/* requirements and needs.                         */
/* *********************************************** */

var incidentRunCounter = 0;

var signPowered = true;

angular.module('dashboard', [])

  .controller('DashboardController', function($scope, $http, $interval) {

    /* connects to and fills in data from /Data/incidents.php */
    $scope.incidents = function() {
      $http.get("Data/incidents.php")
        .then(function(response) {

          if (response.data != 'null') {

            if(signPowered && incidentRunCounter > 0 && $scope.incidents.toString() != response.data.toString()){

              if($scope.incidents.length < response.data.length){
                var priority;
                var rawPriority;
                switch (response.data[0].priority.description.toLowerCase()) {
                  case 'cosmetic':
                    priority = 'project';
                    break;
                  case 'v. important':
                    priority = 'vimportant';
                    break;
                  default:
                    priority = response.data[0].priority.description.toLowerCase();
                    break;
                }

                //SignIncidentController(3,priority);
              }
            }

            var time = new Date();

            // if(TurnOffCheck(time) == true){
            //   SignController('dim');
            //   signPowered = false;
            // }else if(TurnOnCheck(time)){
            //   SignController('startup');
            //   signPowered = true;
            // }

            $scope.incidents = response.data;

            incidentRunCounter++;


            if ($scope.incidents.length <= 20) {
              $scope.incidentstatus = "success";
            } else if (20 < $scope.incidents.length && $scope.incidents.length <= 25) {
              $scope.incidentstatus = "warning";
            } else {
              $scope.incidentstatus = "danger";
            }

            $scope.footerdate = new Date(Date.now());

            $scope.connectionerror = "";

            if ($scope.incidents.length < 8) {
              $scope.changelimit = 16 - $scope.incidents.length;
              $scope.incidentlimit = $scope.incidents.length;
            } else {
              $scope.changelimit = 8;
              $scope.incidentlimit = 8;
            }

            $scope.incidentcounter = 0;

          } else {

            $scope.incidentcounter = 1;
            console.error("Incidents Failed to Load At:" + Date.now());

          }
        })
    };

    /* connects to and fills in data from /Data/tasks.php */
    $scope.tasks = function() {
      $http.get("Data/tasks.php")
        .then(function(response) {

          if (response.data != 'null') {

            $scope.tasks = response.data;

            if ($scope.tasks.length <= 5) {
              $scope.taskstatus = "success";
            } else if (5 < $scope.tasks.length && $scope.tasks.length <= 10) {
              $scope.taskstatus = "warning";
            } else {
              $scope.taskstatus = "danger";
            }

            $scope.taskscounter = 0;

          } else {

            $scope.taskscounter = 1;
            console.error("Tasks Failed to Load At:" + Date.now());

          }
        })
    }

    $scope.activities = function() {
      $http.get("Data/togglController.php")
        .then(function(response) {

          if (response.data) {

            $scope.activities = response.data;

            if ($scope.activities.IsCurrent == 1) {
              $scope.activitystatus = "success";
            }

          } else {

            console.error("Activities Failed to Load At:" + Date.now());

          }
        })
    }

    $scope.projects = function() {
      $http.get("Data/togglProjectsController.php")
        .then(function(response) {

          if (response.data) {

            $scope.projects = response.data;
						// console.log(response.data);

          } else {

            console.error("Projects Failed to Load At:" + Date.now());

          }
        })
    }

    $scope.activitiesSimple = function() {
      $http.get("Data/togglController.php")
        .then(function(response) {

          if (response.data) {

            $scope.togglSL = $.grep(response.data, function(e) {
              return e.Username == "Steven Lee"
            })[0];
            $scope.togglJP = $.grep(response.data, function(e) {
              return e.Username == "James Proctor"
            })[0];
            // $scope.togglLJ = $.grep(response.data, function(e) {
            //   return e.Username == "Lee Jones"
            // })[0];
            $scope.togglSH = $.grep(response.data, function(e) {
              return e.Username == "Sam Horner"
            })[0];
            $scope.togglBK = $.grep(response.data, function(e) {
              return e.Username == "Brandon Kyaw"
            })[0];

          } else {

            console.error("Activities Failed to Load At:" + Date.now());

          }
        })
    }

    /* connects to and fills in data from /Data/contacts.php */
    $scope.contacts = function() {
      $http.get("Data/contacts.php")
        .then(function(response) {

          if (response.data != "") {
            $scope.contacts = response.data;

            if ($scope.contacts.Count <= 3) {
              $scope.contactstatus = "success";
            } else if (3 < $scope.contacts.Count && $scope.contacts.Count <= 5) {
              $scope.contactstatus = "warning";
            } else {
              $scope.contactsstatus = "danger";
            }

            if ($scope.contacts.Count == "") {
              $scope.contacts.Count = "*";
            }

            $scope.contactcounter = 0;

          } else {

            $scope.contacts.Count = "-";
            $scope.contactstatus = "default";
            $scope.contactcounter = 1;

          }

        })
    }

    /* connects to and fills in data from /Data/status.php */
    $scope.serverstatus = function() {

      $http.get("Data/status.php")
        .then(function(response) {

          $scope.serverstatus = response.data;

          var i = 0;

          $scope.serverstatus.forEach(function(statusresponse) {
            if (statusresponse.Status == "FALSE") {
              i++;
            }
            return;
          });

          if (i == 0) {
            $scope.allserverstatus = "success";
          } else {
            $scope.allserverstatus = "danger";
          }

        })

    }

    /* connects to and fills in data from /Data/WCSstatus.php */
    $scope.wcsserverstatus = function() {

      $http.get("Data/WCSstatus.php")
        .then(function(response) {

          $scope.wcsserverstatus = response.data;

          var i = 0;

          $scope.wcsserverstatus.forEach(function(wcsstatusresponse) {
            if (wcsstatusresponse.Status == "FALSE") {
              i++;
            }
            return;
          });

          if (i == 0) {
            $scope.allserverstatus = "success";
          } else {
            $scope.allserverstatus = "danger";
          }




        })

    }

    /* connects to and fills in data from /Data/changes.php */
    $scope.changes = function() {

      $http.get("Data/changes.php")
        .then(function(response) {

          if (response.data != "") {

            $scope.changes = response.data;

            if ($scope.changes.length <= 100) {
              $scope.changesstatus = "success";
            } else if (100 < $scope.changes.length && $scope.changes.length <= 135) {
              $scope.changesstatus = "warning";
            } else {
              $scope.changesstatus = "danger";
            }

            $scope.changescounter = 0;

          } else {

            $scope.changescounter = 1;
            console.error("Changes Failed to Load At:" + Date.now());

          }



        })
    }

    $scope.connectionstatus = function() {

      $scope.counter = $scope.incidentcounter + $scope.taskscounter + $scope.changescounter + $scope.contactcounter;

      if ($scope.counter > 0) {
        $scope.connectionerror = "glyphicon-ban-circle";
      } else {
        $scope.connecitonerror = "";
      }

    }

    /* Load page */
    $scope.incidents();
    $scope.tasks();
    $scope.activities();
		$scope.projects();
    $scope.activitiesSimple();
    $scope.contacts();
    $scope.changes();
    $scope.serverstatus();
    $scope.connectionstatus();
    $scope.wcsserverstatus();

    $scope.incidentcounter = 0;
    $scope.taskscounter = 0;
    $scope.contactcounter = 0;
    $scope.changescounter = 0;

    var delay1 = 60000;
    var delay2 = 250000;
    var delay3 = 30000;

    $interval($scope.incidents, delay1);
    $interval($scope.tasks, delay1);
    $interval($scope.contacts, delay1);
    $interval($scope.changes, delay1);
    $interval($scope.activities, delay1);
		$interval($scope.projects, delay1);
    $interval($scope.activitiesSimple, delay1);
    $interval($scope.serverstatus, delay2);
    $interval($scope.wcsserverstatus, delay2);
    $interval($scope.connectionstatus, delay3);

    /* Sets date css */
    $scope.getdateclass = function(dateVal) {

      var dateObj = new Date(dateVal);

      var today = new Date(Date.now());

      var thisweek = new Date(Date.now() + 5 * 24 * 60 * 60 * 1000);

      if (dateObj <= today) {
        return 'danger';
      } else if (dateObj <= thisweek) {
        return 'warning';
      }

    }

    /* Set today css - new item in system */
    $scope.getnewitem = function(dateVal) {

      var dateObj = new Date(dateVal);

      var today = new Date(Date.now());

      if (dateObj.toDateString() == today.toDateString()) {
        return 'bg-success';
      }

    }

    /* Converts Date and adds T to make it useable. */
    $scope.convertToDate = function(dateVal) {
      //console.log("Format Date");
      dateVal = dateVal.replace(" ", "T");
      //console.log(dateVal);
      var dateOut = new Date(dateVal);
      // console.log(dateOut);
      return dateOut;
    };

    /* Task Status Styling */
    $scope.getstatusclass = function(statusVal) {
      switch (statusVal) {
        case 'NOT STARTED':
          return 'danger';
        case 'IN PROGRESS':
          return 'success';
      }

    }

    /* Short Service Names to save space on table*/
    $scope.getservicename = function(service) {

      switch (service) {
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
    $scope.getassigneename = function(assignee) {

      switch (assignee) {

        case 'James Proctor':
          return 'JP';
        case 'Steven Lee':
          return 'SL';
        case 'Jo Hannington':
          return 'JH';
        case 'Lee Jones':
          return 'LJ';
        case 'Sam Horner':
          return 'SH';
        case 'Brandon Kyaw':
          return 'BK';
        case 'WJPS Staff':
          return 'WJPS';
        case 'WJPS Support Staff':
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


  // function TurnOffCheck(time){
  //   if(time.getDay() == 5){
  //     if((time.getHours() >= 16 || time.getHours() < 8) && signPowered  ){
  //       console.log('Friday after 4');
  //       return true;
  //     }
  //   }
  //   if((time.getHours() >= 17 || time.getHours() < 8) && signPowered){
  //     console.log('Week day after 5');
  //     return true;
  //   }
  //   return false;
  // }

  // function TurnOnCheck(time){
  //   if(time.getDay() > 0 && time.getDay < 6){
  //     if((time.getHours() >= 8 && time.getMinutes() >= 55 && time.getHours() < 12) && !signPowered){
  //       return true;
  //     }
  //     return false;
  //   }else{
  //     return false;
  //   }
  //
  // }

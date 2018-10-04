var i = 0;
var j = 0;
PanelLoop();

function PanelLoop(){
  setTimeout(function(){    
    PanelStatus();
    PanelLoop();  
    i++;
    if(i==300){
      i = 0;
      j++;
    }  
    if(j == 4){
      j = 0;
    }
  },1000);
}

function PanelStatus(){
  $.getJSON("/Data/panelStatus.php", function(status){
  		
      switch (status.Status) {
        case "0":
          changeLoop();
          break;
        case "1":        
            $("#toggleablearea_tasks").show();
            $("#toggleablearea_toggl").hide();
            $("#toggleablearea_alfie").hide();
            $("#toggleablearea_WJPS").hide();
            $("#toggleablearea_WCSStatus").hide();
          break;
        case "2":
            $("#toggleablearea_tasks").hide();
            $("#toggleablearea_toggl").show();
            $("#toggleablearea_alfie").hide();
            $("#toggleablearea_WJPS").hide();
            $("#toggleablearea_WCSStatus").hide();
          break;
        case "3":        
            $("#toggleablearea_tasks").hide();
            $("#toggleablearea_toggl").hide();
            $("#toggleablearea_alfie").show();
            $("#toggleablearea_WJPS").hide();
            $("#toggleablearea_WCSStatus").hide();
          break;
        case "4":        
            $("#toggleablearea_tasks").hide();
            $("#toggleablearea_toggl").hide();
            $("#toggleablearea_alfie").hide();
            $("#toggleablearea_WJPS").show();
            $("#toggleablearea_WCSStatus").hide();
          break;
        case "5":        
            $("#toggleablearea_tasks").hide();
            $("#toggleablearea_toggl").hide();
            $("#toggleablearea_alfie").hide();
            $("#toggleablearea_WJPS").hide();
            $("#toggleablearea_WCSStatus").show();
          break;
        default:
            $("#toggleablearea_tasks").hide();
            $("#toggleablearea_toggl").show();
            $("#toggleablearea_alfie").hide();
            $("#toggleablearea_WJPS").hide();
            $("#toggleablearea_WCSStatus").hide();
            break;
      }
      
  	});
}

function changeLoop(){
    switch (j) {
      case 1:          
          $("#toggleablearea_tasks").show();
          $("#toggleablearea_toggl").hide();
          $("#toggleablearea_alfie").hide();
          $("#toggleablearea_WJPS").hide();
          $("#toggleablearea_WCSStatus").hide();
        break;
      case 2:
          $("#toggleablearea_tasks").hide();
          $("#toggleablearea_toggl").show();
          $("#toggleablearea_alfie").hide();
          $("#toggleablearea_WJPS").hide();
          $("#toggleablearea_WCSStatus").hide();
        break;
      case 3:      
          $("#toggleablearea_tasks").hide();
          $("#toggleablearea_toggl").hide();
          $("#toggleablearea_alfie").hide();
          $("#toggleablearea_WJPS").hide();
          $("#toggleablearea_WCSStatus").show();
        break;     
    }        
    
}
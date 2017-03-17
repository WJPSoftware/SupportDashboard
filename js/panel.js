PanelLoop();

function PanelLoop(){
  setTimeout(function(){    
    PanelStatus();
    PanelLoop();    
  },1000);
}

function PanelStatus(){
  $.getJSON("/Data/panelStatus.php", function(status){
  		
      switch (status.Status) {
        case "1":        
            $("#toggleablearea_tasks").show();
            $("#toggleablearea_toggl").hide();
            $("#toggleablearea_alfie").hide();
            $("#toggleablearea_WJPS").hide();
          break;
        case "2":
            $("#toggleablearea_tasks").hide();
            $("#toggleablearea_toggl").show();
            $("#toggleablearea_alfie").hide();
            $("#toggleablearea_WJPS").hide();
          break;
        case "3":        
            $("#toggleablearea_tasks").hide();
            $("#toggleablearea_toggl").hide();
            $("#toggleablearea_alfie").show();
            $("#toggleablearea_WJPS").hide();
          break;
        case "4":        
            $("#toggleablearea_tasks").hide();
            $("#toggleablearea_toggl").hide();
            $("#toggleablearea_alfie").hide();
            $("#toggleablearea_WJPS").show();
          break;
        default:
            $("#toggleablearea_tasks").hide();
            $("#toggleablearea_toggl").show();
            $("#toggleablearea_alfie").hide();
            $("#toggleablearea_WJPS").hide();
            break;
      }
      
  	});
}
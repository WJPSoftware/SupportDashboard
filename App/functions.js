getdateclass = function(dateVal){

	console.log("getdateclass");

	var dateObj = new Date(dateVal);

	var today = new Date();

	if (dateObj >= today){
		return 'danger';
	}

}
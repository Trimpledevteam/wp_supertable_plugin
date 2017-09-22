/*
* App.js
*/
jQuery(function($) {

	var table_id =  "#"+ my_script.table_id+" tr";
	var table_id_vis =  "#"+ my_script.table_id+" tr:visible";
	var limit = my_script.table_limits;
	var trs = $(table_id);
	var btnMore = $("#seeMoreRecords");
	var btnLess = $("#seeLessRecords");
	var trsLength = trs.length;
	var currentIndex = parseInt(limit);

	trs.hide();
	trs.slice(0, parseInt(limit)).show(); 
	checkButton();

	btnMore.click(function (e) { 
	    e.preventDefault();
	    $(table_id).slice(currentIndex, currentIndex + parseInt(limit)).show();
	    currentIndex += parseInt(limit);
	    checkButton();
	});

	btnLess.click(function (e) { 
	    e.preventDefault();
	    $(table_id).slice(currentIndex - parseInt(limit), currentIndex).hide();          
	    currentIndex -= parseInt(limit);
	    checkButton();
	});

	function checkButton() {
	    var currentLength = $(table_id_vis).length;
	    
	    if (currentLength >= trsLength) {
	        btnMore.hide();            
	    } else {
	        btnMore.show();   
	    }
	    
	    if (trsLength > parseInt(limit) && currentLength > parseInt(limit)) {
	        btnLess.show();
	    } else {
	        btnLess.hide();
	    }
	    
	}
});	
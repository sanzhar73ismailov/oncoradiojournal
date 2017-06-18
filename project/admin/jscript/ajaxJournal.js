/*
$(document).ready(function(){ 
//$("#search_results").slideUp(); 
    $("#search_button").click(function(e){ 
        e.preventDefault(); 
        ajax_search(); 
    }); 
  ; 

});

function ajax_search(){ 
	alert("From ajax_search");
	
	  $("#search_results").show(); 
	  var search_val=$("#search_term").val(); 
	  $.post("./find.php", {search_term : search_val}, function(data){
	   if (data.length>0){ 
	     $("#search_results").html(data); 
	   } 
	  })
	 
	}
	
	 */
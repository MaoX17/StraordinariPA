$(document).ready(function() { 
        $('#FormProfessionista').ajaxForm(function() { 
                alert("Thank you for your submitting form 1 FormProfessionista"); 
        });
        $('#FormCategorie').ajaxForm(function() { 
                alert("Thank you for your submitting form 2 FormCategorie"); 
        });

        $("#submitEverything").click(function(){
            $("#FormProfessionista").submit();
            $("#FormCategorie").submit();
        	return false;
        	}); 


    		
}); 

  var xmlhttp; 
  function createXHR(){  
    if(window.ActiveXObject){ 
      xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
    }else if(window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest(); 
    } 
  }

function $(id){
	return document.getElementById(id);
}

// check whether email and password are valid
function login_in() {
    var email = $("logemail").value;
    var password = $("logpwd").value;
    
 
    if (email == "" || password == "") {
        $('show').innerHTML = "<font color=red>The email or password is empty</font>";
    }
 	else{
	    createXHR();
	    // connect login_dbchk.php to select corresponding data to match
	    xmlhttp.open('get','login_dbchk.php?logemail='+email+"&logpwd="+password,true);  
	    xmlhttp.onreadystatechange = function(){  
	        if(xmlhttp.readyState == 4){  
	          	if(xmlhttp.status == 200){ 
	      			var msg = xmlhttp.responseText;
	             	if (msg == 1) {
	               		$("login_form").submit();
	         		} else {
	             	    $("show").innerHTML = '<font color=red>The email does not exist or passowrd is incorrect</font>';
	                }
	            }
			} 
		}
		xmlhttp.send(null);
	}
	
}		

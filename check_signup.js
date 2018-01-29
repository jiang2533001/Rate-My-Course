var xmlhttp;
var cfname, clname, cemail1, cemail2, cpwd1, cpwd2; 
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

window.onload = function(){
    // check whether email address is valid 
    $('regemail').onkeyup = function () {
         regemail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
        if ($('regemail').value.match(regemail) == null) {
            $('emaildiv').innerHTML = '<font color=red>*Invalid Email type</font>';
            cemail1 = null;
        } else {
            cemail1 = 'yes';
        }
        email = $('regemail').value;  
        if (cemail1 == 'yes') { 
            createXHR();
            // connect a php file to check whether email address exists
            xmlhttp.open('get', 'signup_dbchk.php?email='+email, true);     
            xmlhttp.onreadystatechange = function () {  
                if (xmlhttp.readyState == 4) {  
                    if (xmlhttp.status == 200) { 
                        var msg = xmlhttp.responseText;  
                        if (msg == 1) {  
                            $('emaildiv').innerHTML = "<font color=green>Valid</font>";
                            cemail2 = 'yes';
                        } else if (msg == 0) { 
                            $('emaildiv').innerHTML = "<font color=red>This email has been existed</font>";
                            cemail2 = '';
                        }                      
                    }
                }
            }
            xmlhttp.send(null);
        }
    }

    // check whether first name is valid 
    $('regfname').onkeyup = function () {    
        regfname = /^[a-zA-Z]+$/;
        fname = $('regfname').value;  //gain username
        if (fname.match(regfname) == null) {
            $('namediv1').innerHTML = '<font color=red>*Invalid symbol</font>';
            cfname = '';
        } else if (fname.length < 0 || fname.length > 30) {
            $('namediv1').innerHTML = '<font color=red>*Length between 1~30 </font>';
            cfname = '';
        } else {
            $('namediv1').innerHTML = '<font color=green>Valid</font>';
            cfname = 'yes';
        }
    }

    // check whether last name is valid
    $('reglname').onkeyup = function () {    
        reglname = /^[a-zA-Z]+$/;
        lname = $('reglname').value;  //gain username
        if (lname.match(reglname) == null) {
            $('namediv2').innerHTML = '<font color=red>*Invalid symbol</font>';
            clname = '';
        } else if (lname.length < 0 || lname.length > 30) {
            $('namediv2').innerHTML = '<font color=red>*Length between 1~30 </font>';
            clname = '';
        } else {
            $('namediv2').innerHTML = '<font color=green>Valid</font>';
            clname = 'yes';
        }
    }

    // check whether password is valid
    $('regpwd1').onkeyup = function () {
        pwd = $('regpwd1').value;
        pwd2 = $('regpwd2').value;
        if (pwd.length < 6 || pwd.length > 12) {
            $('pwddiv1').innerHTML = '<font color=red>*Length between 6~12"</font>';
            cpwd1 = '';
        } else if (pwd.match(/^[a-zA-Z]*/) == '') {
            $('pwddiv1').innerHTML = '<font color=red>*Fisrt value must be a character</font>';
            cpwd1 = '';
        } else {
            $('pwddiv1').innerHTML = '<font color=green>Valid</font>';
            cpwd1 = 'yes';
        }
        if (pwd2 != '' && pwd2 != pwd) {
            $('pwddiv2').innerHTML = '<font color=red>*Passwords do not matched</font>';
            cpwd2 = '';
        } else if (pwd2 != '' && pwd == pwd2) {
            $('pwddiv2').innerHTML = '<font color=green>Valid</font>';
            cpwd2 = 'yes';
        }
    }    

    // check whether re-password is valid
    $('regpwd2').onkeyup = function () {
        pwd1 = $('regpwd1').value;
        pwd2 = $('regpwd2').value;
        if (pwd1 != pwd2) {
            $('pwddiv2').innerHTML = '<font color=red>Passwords do not matched</font>';
            cpwd2 = '';
        } else {
            $('pwddiv2').innerHTML = '<font color=green>Valid</font>';
            cpwd2 = 'yes';
        }    
    }    
}

// if all information are valid, the submit button will be available    
function set_up() {
    if ((cfname == 'yes') && (clname == 'yes') && (cemail2 == 'yes') && (cpwd1 == 'yes') && (cpwd2 == 'yes'))
        $('signup_form').submit();
    else
        return;
}    


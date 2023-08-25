var username = sessionStorage.getItem("user_name");

function updatePassword() {

    var username1 = null;  
    var password = document.getElementById('current_password').value;
    var pwd1 = document.getElementById('password').value;
    var pwd2 = document.getElementById('confirm_password').value;


    if(pwd1=="" && pwd2=="" && password==""){
        window.alert("fill the fields");
     }else if( pwd1==pwd2 ){
            $.post("login.php",{'username':username,'password':password},function(data){
                if(data == "1" ){
                     // update user data
                    if (confirm("Are you sure you want to proceed?")) {
                        $.post("update_user_info.php",{username1:username, password:password, pwd1:pwd1, pwd2:pwd2}, function(resp) {
                            console.log(resp);
                            if (resp.status === 200) {
                            //clear the form data
                            }
                            location.replace("index.html");
                            //session clear
                        });
                    }
                }else if (data == "2"){
                    window.alert("Λάθος όνομα χρήστη");
                        //wrong username
                } else if(data == "0"){
                    //wrong password
                    window.alert("Λάθος κωδικός");
                }
            });
    } 
}

function updateName() {

    var username1 = document.getElementById('username').value;
    var password = document.getElementById('current_password2').value;
    var pwd1 = null;
    var pwd2 = null;


    if (username1.length < 5) {
         window.alert("Missing username");
    }
    //check password gia sunexeia
    if(username1=="" && password==""){
        window.alert("fill the fields");
      }else{
        $.post("login.php",{'username':username,'password':password},function(data){
        if(data == "1" ){
               // update user data
            if (confirm("Are you sure you want to proceed?")) {
                $.post("update_user_info.php",{username1:username1, password:password, pwd1:pwd1, pwd2:pwd2}, function(resp) {
                if (resp.status === 200) {
                 //clear the form data
                }
                location.replace("index.html");
                //session clear
            });
    }
        }else if (data == "2"){
          window.alert("Λάθος όνομα χρήστη");
          //wrong username
        } else if(data == "0"){
          //wrong password
          window.alert("Λάθος κωδικός");
        }
      });
    } 
}

var myInput = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
            
// When the user types on the password field, show the message box
myInput.oninput = function() {
    document.getElementById("message").style.display = "block";
}
            
// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
}
// When the user starts to type something inside the password field
myInput.onkeyup = function() {
// Validate lowercase letters
var lowerCaseLetters = /[#?!@$%^&*-]/g;
if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
} else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
}
              
// Validate capital letters
var upperCaseLetters = /[A-Z]/g;
if(myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
} else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
}
            
// Validate numbers
var numbers = /[0-9]/g;
if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
} else {
    number.classList.remove("valid");
    number.classList.add("invalid");
}
              
// Validate length
if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
} else {
    length.classList.remove("valid");
    length.classList.add("invalid");
}
}


function register(){

    var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/; //pattern
    //check if values are accepited
    if (document.getElementById("letter").classList.contains("valid") && document.getElementById("capital").classList.contains("valid") && document.getElementById("number").classList.contains("valid") && document.getElementById("length").classList.contains("valid")) {
        var password = document.getElementById('password').value
        var email = document.getElementById('email').value
        var username = document.getElementById('username').value
        
        if (username!= "" && password !="" && email.match(emailPattern)){
	        $.post( "register.php", { username: username, email: email, password: password }, function(data){
                if (data == "1"){
                    window.alert("Η Εγγραφή ολοκληρώθηκε με επιτυχία");
                    location.replace("index.html")
                }else if (data == "2"){
                    document.getElementById("message").innerHTML = "<h3 class='wrong_message'>To Όνομα χρήστη ή το E-mail υπάρχει ήδη.</h3>"
                    document.getElementById("message").style.display = "block"
                }else{
                    //location.replace("error.html");
                    window.alert(data);
                }            
            } );
        }
    } else {
        document.getElementById("message").innerHTML = "<h3 class='wrong_message'>Συμπληρώστε όλα τα πεδία σωστά</h3>"
        document.getElementById("message").style.display = "block"
    } 
}



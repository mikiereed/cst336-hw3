var zipCodeValid = false;

//displaying city from API after typing a zip code
$("#zipCode").on("change", function() {
    //alert($("#zipCode").val());
    $("#cityState").html("");
    $.ajax({
        method: "GET",
        url: "https://cst336.herokuapp.com/projects/api/cityInfoAPI.php",
        dataType: "json",
        data: { "zip": $("#zipCode").val() },
        success: function(result,status) {
            alert(result.city);
            $("#cityState").html(result.city);
        }
    }); //ajax
}); //zip
            
            $("#state").on("change", function() {
                //alert($("#state").val());
                $.ajax({
                    method: "GET",
                    url: "https://cst336.herokuapp.com/projects/api/countyListAPI.php",
                    dataType: "json",
                    data: { "state": $("#state").val() },
                    success: function(result,status) {
                        //alert(result[0].county);
                        $("#county").html("<option> Select one </option>");
                        for (let i=0; i < result.length; i++) {
                            $("#county").append("<option>" + result[i].county + "</option>");    
                        }
                    }
                }); //ajax
            }); //state
            
            $("#username").change(function() {
                //alert($("#username").val());
                $.ajax({
                    method: "GET",
                    url: "https://cst336.herokuapp.com/projects/api/usernamesAPI.php",
                    dataType: "json",
                    data: { "username": $("#username").val() },
                    success: function(result,status) {
                        if(result.available) {
                            $("#usernameError").html("Username is available!");
                            $("#usernameError").css("color", "green");
                            usernameAvailable = true;
                        } else {
                            $("#usernameError").html("Username is unavailable!");
                            $("#usernameError").css("color", "red");
                            usernameAvailable = false;
                        }
                    }
                }); //ajax
            }); //username
            
            $("#password").change(function() {
                if ($("#password").val().length < 6) {
                    $("#passwordTooShort").html("Password Must be at least 6 characters");
                    $("#passwordTooShort").css("color", "red");
                } else {
                    $("#passwordTooShort").html("");
                }
            })
            
            $("#username").on("submit", function(e) {
                alert("Submitting form...")
                if (!isFormValid()) {
                    e.preventDefault();
                }; //isFormValid
            }); //submit
            
            function isFormValid() {
                isValid = true;
                if (!usernameAvailable) {
                    isValid = false;
                }
                if ($("#username").val().length == 0) {
                    isValid = false;
                    $("#usernameError").html("Username is required");
                }
                if ($("#password").val() != $("#passwordAgain").val()) {
                    $("#passwordAgainError").html("Retype Password");
                    isValid = false;
                }
                if ($("#latitude").val() == "") {
                    isValid = false;
                }
                return isValid;
            }
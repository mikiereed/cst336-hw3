<!DOCTYPE html>
<html>
    <head>
        <title> Weather App </title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <h1 class="jumbotron"> Weather Update </h1>
        <form id="weatherUpdate" method="post">
            <h4>Street: <input type="text" name="street"/> (Optional)</h4> <br>
            <h4>Zip Code: <input type="text" name="zipCode" id="zipCode"/></h4>
            <h5 id="invalidZipCode"></h5><br>
            <h4>City, State: <span id="cityState"></span></h4><br>
            <h4>Current Temperature: <span id="currentTemp"></span></h4><br>
            <input type="submit" value="Thanks">
        </form>
        <script type="text/javascript">
            var VALID_ZIPCODE = false;
            $("#zipCode").on("change", function() {
                //alert($("#zipCode").val());
                if ($("#zipCode").val().length !== 5) {
                    $("#invalidZipCode").html("Zipcodes Are 5 Characters Long");
                    $("#invalidZipCode").css("color", "red");
                    VALID_ZIPCODE = false;
                } else {
                    $("#invalidZipCode").html("");
                    var zipCodeAndUs = $("#zipCode").val() + ",us"
                    $.ajax({
                        method: "GET",
                        url: "https://openweathermap.org/data/2.5/weather/",
                        dataType: "json",
                        data: { "zip": zipCodeAndUs,
                                "appid": "7bb5a850f3770a94f8fcad304c173fc5"},
                        success: function(result,status) {
                                $("#currentTemp").html(result.temp);
                                alert("hi");
                        }
                    }); //ajax get city info
                    $.ajax({
                        method: "GET",
                        url: "https://cst336.herokuapp.com/projects/api/cityInfoAPI.php",
                        dataType: "json",
                        data: { "zip": $("#zipCode").val() },
                        success: function(result,status) {
                            //alert(result.city);
                            // check if zip code is legit
                            if (!result) {
                                $("#cityState").html("Zip Code Not Found!");
                                $("#currentTemp").html("");
                                VALID_ZIPCODE = false;
                            } else {
                                $("#cityState").html(result.city + ", " + result.state);
                                VALID_ZIPCODE = true;
                            }
                        }
                    }); //ajax get city info
                    
                }
            }); //zip
            
            $("#weatherUpdate").on("submit", function(e) {
                //alert("Submitting form...")
                if (!isFormValid()) {
                    e.preventDefault();
                }; //isFormValid
            }); //submit
            
            function isFormValid() {
                isValid = true;
                if (!VALID_ZIPCODE) {
                    isValid = false;
                    $("#invalidZipCode").html("Zip Code is required");
                    $("#invalidZipCode").css("color", "red");
                }
                return isValid;
            }
        </script>
    </body>
</html>
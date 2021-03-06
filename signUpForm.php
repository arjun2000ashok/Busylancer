<?php
    include("includes/db.php");


?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/signUpFormCSS.css">
        <script>
            var isEverythingValid = new Array(3);
            var i;
            for(i=0;i<3;i++){
                isEverythingValid[i] = 0;
            }
            
            function validateForm(){
                var i;
                
                for(i=0;i<3;i++){
                    if(isEverythingValid[i] != 1){
                        alert("Please correct the errors in the form and then proceed !");
                        return false;
                    }
                    
                    return true;
                }
            }
            
        </script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
        <script src="includes/validation.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>

        <script>  
        $(document).ready(function(){
            $("#company").hide();
            $('#userType').on('change', function() {
                console.log(this.value);
              if ( this.value === "Employer")
              {
                $("#company").show();
              }
              else
              {
                $("#company").hide();
              }
            });
        });
        </script>
        
        
        
        <script>

            //jQuery time
            $(document).ready(function(){
                var current_fs, next_fs, previous_fs; //fieldsets
                var left, opacity, scale; //fieldset properties which we will animate
                var animating; //flag to prevent quick multi-click glitches

                $(".next").click(function(){
                    if(animating) return false;
                    animating = true;

                    current_fs = $(this).parent();
                    next_fs = $(this).parent().next();

                    //activate next step on progressbar using the index of next_fs
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show(); 
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                        step: function(now, mx) {
                            //as the opacity of current_fs reduces to 0 - stored in "now"
                            //1. scale current_fs down to 80%
                            scale = 1 - (1 - now) * 0.2;
                            //2. bring next_fs from the right(50%)
                            left = (now * 50)+"%";
                            //3. increase opacity of next_fs to 1 as it moves in
                            opacity = 1 - now;
                            current_fs.css({
                        'transform': 'scale('+scale+')',
                        'position': 'absolute'
                      });
                            next_fs.css({'left': left, 'opacity': opacity});
                        }, 
                        duration: 1000, 
                        complete: function(){
                            current_fs.hide();
                            animating = false;
                        }, 
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });

                $(".previous").click(function(){
                    if(animating) return false;
                    animating = true;

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //de-activate current step on progressbar
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show(); 
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                        step: function(now, mx) {
                            //as the opacity of current_fs reduces to 0 - stored in "now"
                            //1. scale previous_fs from 80% to 100%
                            scale = 0.8 + (1 - now) * 0.2;
                            //2. take current_fs to the right(50%) - from 0%
                            left = ((1-now) * 50)+"%";
                            //3. increase opacity of previous_fs to 1 as it moves in
                            opacity = 1 - now;
                            current_fs.css({'left': left});
                            previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
                        }, 
                        duration: 800, 
                        complete: function(){
                            current_fs.hide();
                            animating = false;
                        }, 
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });

                $(".submit").click(function(){
                    return false;
                })

            });
            
        </script>
        
        
        
        <?php include("includeCountries.php"); ?>
        <script type="text/javascript">
            
            function validatePass(){
                var statusElement = document.getElementById("passwordStatus");
                var password = document.getElementById("password").value;
                
                var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
                if(password.match(passw)){
                    statusElement.innerHTML = "Awesome !<br>";
                    isEverythingValid[1] = 1;
                }
                else{
                    statusElement.innerHTML = "Password must be 6 to 20 characters long, must contain one uppercase, one lowercase letter and one number!<br>";
                    isEverythingValid[1] = 0;
                }
                
                
            }
            
            function validateCPass(){
                var statusElement = document.getElementById("cpasswordStatus");
                var password = document.getElementById("cpassword").value;
                var actualpass = document.getElementById("password").value;
                if(password == actualpass && password != ""){
                    statusElement.innerHTML = "Awesome !<br>";
                    isEverythingValid[2] = 1;
                }
                else{
                    statusElement.innerHTML = "Passwords don't match !";
                    isEverythingValid[2] = 0;
                }
                
                
            }
            
            //first name, last name, phone and city validation remaining
        </script>
    </head>
    <body onload="addCountries()">
       <form name="signUp" onsubmit="return validateForm();" action="registerUser.php" method="post" id="msform">
          <!-- progressbar -->
          <ul id="progressbar">
            <li class="active">Account Setup</li>
            <li>Social Details</li>
            <li>Personal Details</li>
          </ul>
          <!-- fieldsets -->
          <fieldset>
            <h2 class="fs-title">Create your account</h2>
          <h3 class="fs-subtitle">Already a user?Click <a href="login.php">here</a> to sign in</h3>

            <input name="email" id="email" type="text" name="email" placeholder="Email" />
            <span class="fs-subtitle" style="color:red" id="emailStatus"></span><br>
            
            <input name="password" onkeyup="validatePass();" id="password" type="password" name="pass" placeholder="Password"/>
            <span class="fs-subtitle" style="color:red" id="passwordStatus"></span>

            <input name="cpassword" id="cpassword" onkeyup="validateCPass();" type="password" name="cpass" placeholder="Confirm Password" />
            <span class="fs-subtitle" style="color:red" id="cpasswordStatus"></span><br>

            <input type="button" name="next" class="next action-button" value="Next" />
          </fieldset>    
          <fieldset>
            <h2 class="fs-title">Social Profiles</h2>
            <h3 class="fs-subtitle">Already a user?Click <a href="login.php">here</a> to sign in</h3>
            
            <input placeholder="Date Of Birth" id="dob" name="dob" type = "date" min = "1900-01-01" max = "2018-12-31" value="2001-01-01">
        

            <select name="userType" id="userType" class = "unibox" >
                    <option value="Employee">Work</option>
                    <option value="Employer">Hire</option>
            </select>  

            <select name="company" id="company" class = "unibox">
                    <?php

                        $query = "SELECT * FROM company";
                        $result = mysqli_query($connection,$query);
                        if(!$result){
                            die("Failed!");
                        }

                        while($row = mysqli_fetch_assoc($result)) {
                    ?>
                         <option value="<?php echo $row["company_name"]?>"> <?php echo $row["company_name"]?> </option>
                    <?php
                        }
                       
                    ?>
            </select> 

            <br>
            

            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />

          </fieldset>
          <fieldset>
            <h2 class="fs-title">Personal Details</h2>
              <h3 class="fs-subtitle">Already a user?Click <a href="login.php">here</a> to sign in</h3>
            <input type="text" name="fname" id="fname" placeholder="First Name" />
            <span class="fs-subtitle" style="color:red" id="fnameStatus"></span>

            <input type="text" name="lname" id="lname" placeholder="Last Name" />
            <span class="fs-subtitle" style="color:red" id="lnameStatus"></span>
            
            <select name="location" id="location">
                <option selected disabled>Location</option>
            </select>
            
            <br>
            
            
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            
            <input type="submit" name="next" class="previous action-button" value="Submit">
          </fieldset>
        </form>
    </body>
</html><!-- multistep form -->

<?php $this->load->view('include/head'); ?>
<style type="text/css">
    .form-option{
        height: 45px;
        border: 1px solid #ddd;
        background-color: #fff;
        font-size: 14px;
        -webkit-transition: all .1s linear;
        -moz-transition: all .1s linear;
        transition: all .1s linear;
        width: 100%;
        margin-bottom: 15px;
    }
    .form-option option{
        font-size: 14px !important;
    }
    .color-blue{
        background-color: #3b5998 !important;
        border-color: #fff!important;
    }
    .color-green{
        background-color: #00a91bba!important;
        border-color: #fff!important;
    }
    .error{
        color: red;
    }

</style>
<body class="login">

    <div id="wrapper">
        <div class="container">
            <div class="row login-wrapper">
                <div class="col-md-6 col-md-offset-3">
                    <div class="logo logo-center">
                        <a href="<?php echo base_url(); ?>">
                            <!--<img  src="<?php //echo LOGO_URL;                                                ?>" alt=""> -->
                            <img src="<?php echo WEBSITE_ASSETS; ?>images/xlogin-logo.png.pagespeed.ic.rk5LaeLYSz.png" alt="">
                        </a>
                    </div>
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="#" class="<?php
                                    if ($tab == "login") {
                                        echo 'active';
                                    }
                                    ?>" id="login-form-link">Login</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#" id="register-form-link" class="<?php
                                    if ($tab != "login") {
                                        echo 'active';
                                    }
                                    ?>">Register</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form class="login_form" id="login-form" action="" method="post" role="form" style="display:<?php
                                if ($tab == "login") {
                                    echo 'block';
                                } else {
                                    echo 'none';
                                }
                                ?>;">
                                    
                                    <div class="col-lg-12">
                                        <span class="login_error error"></span>
                                        <div class="form-group">
                                            <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                            <span class="error"></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="login_password" id="login_password" tabindex="2" class="form-control" placeholder="Password">
                                            <span class="error"></span></div>
                                        <div class="form-group text-center">
                                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                            <label for="remember"> &nbsp; Remember Me</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <!-- <div class="col-sm-12">
                                              <button type="submit" class="form-control btn btn-default color-blue">Login with facebook</button>
                                              </div>
                                              <div class="col-sm-12">
                                              <button type="submit" class="form-control btn btn-default">Login with gmail</button>
                                              </div>
                                              <div class="col-sm-12"> -->
                                                <button type="button" class="form-control btn btn-default color-green login_button">Login Account</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <a href="#" tabindex="5" class="forgot-password">Forgot Password?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form class="register_form" id="register-form" action="" method="post" role="form" style="display:<?php
                                if ($tab == "login") {
                                    echo 'none';
                                } else {
                                    echo 'block';
                                }
                                ?>;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text"  name="first_name" id="first_name" tabindex="1" class="form-control charecter_only" placeholder="First Name" value="">
                                                <span class="error"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="last_name" id="last_name" tabindex="1" class="form-control charecter_only" placeholder="Last Name " value="">
                                                <span class="error"></span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
                                                <span class="error"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" onkeypress="return isNumberKey(event)" name="mobile" autocomplete="off" id="mobile" tabindex="1" class="form-control" placeholder="Mobile Number" value="">
                                                <span class="error"></span></div>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-option state" id="state" name="state_id">
                                                <option value="">State</option>
                                                <option value="1">Delhi</option>
                                                <option value="2">Uttar Pradesh</option>
                                            </select>
                                            <span class="error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-option city" id="city"name="city_id">
                                                <option value="">City</option>
                                                <option value="1">Delhi</option>
                                                <option value="2">Noida</option>
                                            </select>
                                            <span class="error"></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-option edu_type" id="edu_type" name="institution_type">
                                                <option value="">Select </option>
                                                <option value="1">School</option>
                                                <option value="2">Univercity</option>
                                                <option value="3">Coaching</option>
                                            </select>
                                            <span class="error"></span>
                                        </div>
                                    </div>
                                    <div class="row div_1" style="display:none">
                                        <div class="col-md-12">
                                            <select class="form-option" id="school_list" name="school_id">
                                                <option value="">Select School</option>
                                                <option value="1">School A</option>
                                                <option value="2">School B</option>
                                                <option value="3">School C</option>
                                                <option value="4">School D</option>
                                            </select>
                                            <span class="error"></span>
                                        </div>  
                                        <div class="col-md-12">
                                            <div class="row" >
                                                <div class="col-md-6">
                                                    <select class="form-option" id="school_class_list" name="school_class_id" >
                                                        <option value="">Select Class</option>
                                                        <option value="1">Class A</option>
                                                        <option value="2">Class B</option>
                                                        <option value="3">Class C</option>
                                                        <option value="4">Class D</option>
                                                    </select>
                                                    <span class="error"></span>
                                                </div>   
                                                <div class="col-md-6">
                                                    <select class="form-option" id="school_class_section_list" name="school_class_section_id"  >
                                                        <option value="">Select Section</option>
                                                        <option value="1">Section A</option>
                                                        <option value="2">Section B</option>
                                                        <option value="3">Section C</option>
                                                        <option value="4">Section D</option>
                                                    </select> 
                                                    <span class="error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row div_2" style="display:none">
                                        <div class="col-md-12">
                                            <select class="form-option " id="university_list" name="university_id" >
                                                <option value="">Select Univercity</option>
                                                <option value="1">Univercity A</option>
                                                <option value="2">Univercity B</option>
                                                <option value="3">Univercity C</option>
                                                <option value="4">Univercity D</option>
                                            </select>
                                            <span class="error"></span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select class="form-option" id="university_course_list" name="university_course_id">
                                                        <option value="">Select Course</option>
                                                        <option value="1">Course A</option>
                                                        <option value="2">Course B</option>
                                                        <option value="3">Course C</option>
                                                        <option value="4">Course D</option>
                                                    </select>
                                                    <span class="error"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-option " id="university_course_section_list" name="university_course_section_id">
                                                        <option value="">Select Section</option>
                                                        <option value="1">Section A</option>
                                                        <option value="2">Section B</option>
                                                        <option value="3">Section C</option>
                                                        <option value="4">Section D</option>
                                                    </select>
                                                    <span class="error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row div_3" style="display:none">
                                        <div class="col-md-12">
                                            <select class="form-option " id="coaching_list" name="coaching_id">
                                                <option value="">Select Coaching</option>
                                                <option value="1">Coaching A</option>
                                                <option value="2">Coaching B</option>
                                                <option value="3">Coaching C</option>
                                                <option value="4">Coaching D</option>
                                            </select>
                                            <span class="error"></span>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select class="form-option " id="coaching_course_list"  name="coaching_course_id" style="">
                                                        <option value="">Select Course</option>
                                                        <option value="1">Course A</option>
                                                        <option value="2">Course B</option>
                                                        <option value="3">Course C</option>
                                                        <option value="4">Course D</option>
                                                    </select>  
                                                    <span class="error"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-option " id="coaching_course_batch_list" name="coaching_course_batch_id" style="">
                                                        <option value="">Select Batch</option>
                                                        <option value="1">Batch A</option>
                                                        <option value="2">Batch B</option>
                                                        <option value="3">Batch C</option>
                                                        <option value="4">Batch D</option>
                                                    </select> 
                                                    <span class="error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                                <span class="error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="password" name="confirm_password" id="confirm_password" tabindex="2" class="form-control" placeholder="Confirm Password">
                                                <span class="error"></span>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="row">
                                        <div class="form-group">
                                            <button type="button" class="register_button form-control btn btn-default btn-block">Register an Account</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo WEBSITE_ASSETS; ?>js/jquery.min.js.pagespeed.jm.iDyG3vc4gw.js"></script>
<script src="<?php echo WEBSITE_ASSETS; ?>js/bootstrap.min.js%2bretina.js%2bwow.js.pagespeed.jc.pMrMbVAe_E.js"></script><script>eval(mod_pagespeed_gFRwwUbyVc);</script>
<script>eval(mod_pagespeed_rQwXk4AOUN);</script>
<script>eval(mod_pagespeed_U0OPgGhapl);</script>
<script src="<?php echo WEBSITE_ASSETS; ?>js/carousel.js%2bcustom.js.pagespeed.jc.nVhk-UfDsv.js"></script><script>eval(mod_pagespeed_6Ja02QZq$f);</script>
<script>eval(mod_pagespeed_KxQMf5X6rF);</script>

<script>
    $(document).ready(function () { 
        $("#reg_modal").modal("toggle");
        $('.edu_type').on('change', function () {
            //alert(this.value);
            //$('body').scrollTop(200);
            //$('html, body').animate({scrollTop: '-100px'}, 0);
            $('html,body').animate({scrollTop: 130}, 'slow');
            $('.div_1').hide();
            $('.div_2').hide();
            $('.div_3').hide();
            $('.div_' + this.value).show();
        });
    });
    function show_error(id, message) {
        $("#" + id).css('border', '1px solid red');
        $("#" + id).focus();
        $("#" + id).siblings().html(message);
        exit;
    }

    function hide_error() {
        $('.error').siblings().css('border', '1px solid gray');
        //$( "#"+id ).focus();
        $('.error').html('');
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    function validate_edu_type_params(edu_type) {
        if (edu_type == 1) {
            var school_list = $('#school_list').val();
            var school_class_list = $('#school_class_list').val();
            var school_class_section_list = $('#school_class_section_list').val();
            if (school_list == "") {
                show_error("school_list", "Please select your school.");
            }
            if (school_class_list == "") {
                show_error("school_class_list", "Please select your class.");
            }
            if (school_class_section_list == "") {
                show_error("school_class_section_list", "Please select your section.");
            }
        } else if (edu_type == 2) {
            var university_list = $('#university_list').val();
            var university_course_list = $('#university_course_list').val();
            var university_course_section_list = $('#university_course_section_list').val();
            if (university_list == "") {
                show_error("university_list", "Please select your university.");
            }
            if (university_course_list == "") {
                show_error("university_course_list", "Please select your course.");
            }
            if (university_course_section_list == "") {
                show_error("university_course_section_list", "Please select your section.");
            }
        } else if (edu_type == 3) {
            var coaching_list = $('#coaching_list').val();
            var coaching_course_list = $('#coaching_course_list').val();
            var coaching_course_batch_list = $('#coaching_course_batch_list').val();
            if (coaching_list == "") {
                show_error("coaching_list", "Please select your coaching.");
            }
            if (coaching_course_list == "") {
                show_error("coaching_course_list", "Please select your course.");
            }
            if (coaching_course_batch_list == "") {
                show_error("coaching_course_batch_list", "Please select your batch.");
            }
        } else {
            show_error("edu_type", "Please select type of education.");
        }
    }

    function validate_registration_email(email) {
        if (email == "") {
            show_error("email", "Please enter your email id.");
        }
        if (!isEmail(email)) {
            show_error("email", "Please enter valid email id.");
        }
    }
    function validate_registration_mobile(mobile) {
        if (mobile == "") {
            show_error("mobile", "Please enter your mobile number.");
        }
    }
    function validate_password_params(password, confirm_password) {
        if (password == "") {
            show_error("password", "Please enter your password.");
        }
        if (password.length < 8) {
            show_error("password", "Password should be minimum 8 digits.");
        }
        if (confirm_password == "") {
            show_error("confirm_password", "Please confirm your password.");
        }
        if (password != confirm_password) {
            show_error("confirm_password", "Password couldn't match.");
        }
    }
    
    function validate_login_params() {
        var username = $('#username').val();
        var login_password = $('#login_password').val();
        if (username == "") {
            show_error("username", "Please enter your login username.");
        }
        if (login_password == "") {
            show_error("login_password", "Please enter your password.");
        }
    }

    function validate_registration_params() {
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var mobile = $('#mobile').val();
        var email = $('#email').val();
        var state = $('.state').val();
        var city = $('.city').val();
        var edu_type = $('.edu_type').val();
        var password = $('#password').val();
        var c_password = $('#confirm_password').val();
        if (first_name == "") {
            show_error("first_name", "Please enter your first name.");
        }
        if (last_name == "") {
            show_error("last_name", "Please enter your last name.");
        }
        validate_registration_email(email);
        validate_registration_mobile(mobile);
        if (state == "") {
            show_error("state", "Please select your state.");
        }
        if (city == "") {
            show_error("city", "Please select city.");
        }
        //alert(password);alert(c_password);
        validate_edu_type_params(edu_type);
        validate_password_params(password, c_password);

        //
        //alert(city);
        //alert(first_name);alert(last_name);alert(mobile);alert(email);alert(state);
        //alert(city); alert(edu_type);// alert(state);
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (($('#mobile').val().length > 9) && (charCode != 8) && (charCode != 9)) {
            return false;
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $('.charecter_only').keypress(function (event) {
        //return true;
        switch (event.keyCode) {
            case 8:  // Backspace
            case 9:  // Tab
            case 13: // Enter
            case 37: // Left
            case 38: // Up
            case 39: // Right
            case 40: // Down
                break;
            default:
                var regex = new RegExp("^[a-zA-Z ]");
                var key = event.key;
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
                break;
        }
    });

    function register() {
        //$('#register_form').submit();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/Student/ajax_register_a_student',
            type: 'post',
            data: $('.register_form').serialize(),
            success: function (data) {
                $("#reg_modal").modal("toggle");
                alert('You have been registered successfully!');
                window.location.href = '<?php echo base_url(); ?>index.php/Student/login';
                //... do something with the data...
            }
        });
    }
    
    function login() {
                $(".login_error").html("");
                $("#username").css('border', '1px solid gray');
                $("#login_password").css('border', '1px solid gray');
                
        //$('#register_form').submit();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/Student/ajax_student_login',
            type: 'post',
            data: $('.login_form').serialize(),
            success: function (data) {
                alert(data);
                if(data == 'success'){
                    alert('Login successfully!');
                    window.location.href = '<?php echo base_url(); ?>';
                }
                $(".login_error").html("Wrong username or password entered!");
                $("#username").css('border', '1px solid red');
                $("#login_password").css('border', '1px solid red');
                //alert('Wrong username or password entered!');
                
                //$("#reg_modal").modal("toggle");
                
                //... do something with the data...
            }
            //alert('Wrong details!');
        });
    }

    $('.register_button').on('click', function () {
        hide_error();
        validate_registration_params();
        register();
    });
    $('.login_button').on('click', function () {
        validate_login_params();
        login();
    });


</script>
</body>

<!-- Mirrored from templatevisual.com/demo/learnplus/course-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Jun 2018 15:49:06 GMT -->
</html>

<div class="modal-dialog" id="reg_modal1" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h2 class="modal-title">CONGRATULATIONS!!</h2>
        </div>
        <div class="modal-body"><h3>You have been registered sucessfully!</h3></div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            <button class="btn btn-success" type="button">Save changes</button>
        </div>
    </div>
</div>
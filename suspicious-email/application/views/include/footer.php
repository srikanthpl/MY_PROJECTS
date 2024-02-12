<footer class="dark footer section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-md-6 col-xs-12">
                <div class="widget">
                    <div class="widget-title">
                        <h4>About MockTest</h4>
                        <hr>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took...</p>
                    <a href="#" class="btn btn-default">Read More</a>
                </div>
            </div>
            <div class="col-md-3 col-md-6 col-xs-12">
                <div class="widget">
                    <div class="widget-title">
                        <h4>Recent Tweets</h4>
                        <hr>
                    </div>
                    <div class="twitter-widget">
                        <ul class="latest-tweets">
                            <li>
                                <p><a href="#" title="">@Mark</a> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam.</p>
                                <span>2 hours ago</span>
                            </li>
                            <li>
                                <p><a href="#" title="">@Envato</a> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam.</p>
                                <span>2 hours ago</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-6 col-xs-12">
                <div class="widget">
                    <div class="widget-title">
                        <h4>Popular Courses</h4>
                        <hr>
                    </div>
                    <ul class="popular-courses">
                        <li>
                            <a href="single-course.html" title=""><img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_01.png.pagespeed.ic.2iuJZT3CaV.png" alt=""></a>
                        </li>
                        <li>
                            <a href="single-course.html" title=""><img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_02.png.pagespeed.ic.c6RThoxSWC.png" alt=""></a>
                        </li>
                        <li>
                            <a href="single-course.html" title=""><img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_03.png.pagespeed.ic.E_Ew4wn4ZP.png" alt=""></a>
                        </li>
                        <li>
                            <a href="single-course.html" title=""><img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_04.png.pagespeed.ic.NGi9jRXTXk.png" alt=""></a>
                        </li>
                        <li>
                            <a href="single-course.html" title=""><img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_05.png.pagespeed.ic.2iuJZT3CaV.png" alt=""></a>
                        </li>
                        <li>
                            <a href="single-course.html" title=""><img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_06.png.pagespeed.ic.o2Uniwq-y5.png" alt=""></a>
                        </li>
                        <li>
                            <a href="single-course.html" title=""><img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_07.png.pagespeed.ic.H-fRTeeP8u.png" alt=""></a>
                        </li>
                        <li>
                            <a href="single-course.html" title=""><img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_08.png.pagespeed.ic.76ek5JLaEY.png" alt=""></a>
                        </li>
                        <li>
                            <a href="single-course.html" title=""><img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_09.png.pagespeed.ic.FJcG938KC-.png" alt=""></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-md-6 col-xs-12">
                <div class="widget">
                    <div class="widget-title">
                        <h4>Contact Details</h4>
                        <hr>
                    </div>
                    <ul class="contact-details">
                        <li><i class="fa fa-link"></i> <a href="#">www.yoursite.com</a></li>
                        <li><i class="fa fa-envelope"></i> <a href="">info@yoursite.com</a></li>
                        <li><i class="fa fa-phone"></i> +90 123 45 67</li>
                        <li><i class="fa fa-fax"></i> +90 123 45 68</li>
                        <li><i class="fa fa-home"></i> Envato INC 22 Elizabeth Str. Melbourne. Victoria 8777.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<section class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <p>© 2015 MockTest Pty Ltd. by <a href="#">Template Visual</a></p>
            </div>
            <div class="col-md-6 text-right">
                <ul class="list-inline">
                    <li><a href="#">Terms of Usage</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Sitemap</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () { 
       alert('working'); 
    });
        function my_login() {
            $(".my_login_error").html("");
            $("#my_username").css('border', '1px solid gray');
            $("#my_password").css('border', '1px solid gray');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/Student/ajax_student_my_login',
                type: 'post',
                data: $('.my_login_form').serialize(),
                success: function (data) {
                    alert(data);
                    if (data == 'success') {
                        alert('Login successfully!');
                        window.location.href = '<?php echo base_url(); ?>';
                    }
                    $(".my_login_error").html("Wrong username or password entered!");
                    $("#my_username").css('border', '1px solid red');
                    $("#my_password").css('border', '1px solid red');
                }
            });
        }

        function validate_my_login_params() {
            var username = $('#my_username').val();
            var password = $('#my_password').val();
            if (username == "") {
                $('#my_username').css('border', '1px solid red');
                $('#my_username').focus();
                $('.my_username_error').html('Please enter your login username.');
            }
            if (password == "") {
                $('#my_password').css('border', '1px solid red');
                $('#my_password').focus();
                $('.my_password_error').html('Please enter your password.');
            }
        }

        $('.my_login_button').on('click', function () {
            validate_login_params();
            my_login();
        });
    </script>
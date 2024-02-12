<div id="loader">
    <div class="loader-container">
        <img src="<?php echo WEBSITE_ASSETS; ?>images/site.gif" alt="" class="loader-site">
    </div>
</div>
<div id="wrapper">
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-left">
                    <p><i class="fa fa-graduation-cap"></i> Best learning management template for ever.</p>
                </div>
                <div class="col-md-6 text-right">
                    <ul class="list-inline">
                        <li>
                            <a class="social" href="#"><i class="fa fa-facebook"></i></a>
                            <a class="social" href="#"><i class="fa fa-twitter"></i></a>
                            <a class="social" href="#"><i class="fa fa-google-plus"></i></a>
                            <a class="social" href="#"><i class="fa fa-linkedin"></i></a>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-lock"></i> Login & Register</a>
                            <?php if ($this->session->userdata('active_user_flag') == 1) { ?>
                                <div class="dropdown-menu">
                                    <form method="post">
                                        <div class="form-title">
                                            <h4><?php echo $this->session->userdata('active_user_name'); ?></h4>
                                            <hr>
                                        </div>
                                        <a href="<?php echo base_url(); ?>index.php/Student/my_profile" >
                                            <p style="color: #000;">My Profile</p></a>
                                        <br>
                                        <div class="clearfix"></div>
                                        <a href="<?php echo base_url(); ?>index.php/Student/logout" >
                                            <button type="submit" class="btn btn-block btn-primary logout">Logout</button>
                                        </a>
                                        <hr>
                                    </form>
                                </div>
                            <?php } else { ?>
                                <div class="dropdown-menu">
                                    <form method="post" class="my_login_form">
                                        <div class="form-title">
                                            <h4>Login Area</h4>
                                            <hr>
                                            <span class="error my_login_error"></span>
                                        </div>
                                        <input class="form-control my_username" type="text" id="my_username" name="my_username" placeholder="User Name">
                                        <span class="error my_username_error"></span>
                                        <div class="formpassword">
                                            <input class="form-control my_password" type="password" id='my_password' name="my_password" placeholder="Your Password">
                                            <span class="error my_password_error"></span>
                                        </div>
                                        <div class="clearfix"></div>
                                        <button type="button" class="btn btn-block btn-primary my_login_button">Login</button>
                                        <hr>
                                        <h4>
                                            <a href="<?php echo base_url(); ?>index.php/Student/registration">Create an Account</a></h4>
                                    </form>
                                </div> 
                            <?php } ?>


                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <header class="header">
        <div class="container">
            <div class="hovermenu ttmenu">
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="fa fa-bars"></span>
                        </button>
                        <div class="logo">
                            <a class="navbar-brand" href="index.php"><img src="<?php echo WEBSITE_ASSETS; ?>images/xlogo.png.pagespeed.ic.vap6Ukaf0i.png" alt=""></a>
                        </div>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="dropdown ttmenu-half">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Home<b class="fa fa-angle-down"></b></a>
                                <!-- <ul class="dropdown-menu menu-bg wbg">
                                <li>
                                <div class="ttmenu-content">
                                <div class="row">
                                <div class="col-md-6">
                                <div class="box">
                                <ul>
                                <li><a href="index1.php">php Version 1</a></li>
                                <li><a href="index2.php">php Version 2</a></li>
                                <li><a href="index3.php">php Version 3</a></li>
                                <li><a href="index4.php">php Version 4</a></li>
                                <li><a href="index5.php">php Version 5</a></li>
                                <li><a href="index6.php">php Version 6</a></li>
                                <li><a href="index7.php">php Version 7</a></li>
                                </ul>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="box">
                                <ul>
                                <li><a href="index8.php">php Version 8</a></li>
                                <li><a href="index9.php">php Version 9</a></li>
                                <li><a href="index10.php">php Version 10</a></li>
                                </ul>
                                </div>
                                </div>
                                </div>
                                </div>
                                </li>
                                </ul> -->
                            </li>
                            <li><a href="<?php echo base_url(); ?>index.php/Aboutus/index">About</a></li>
                            <li class="dropdown ttmenu-half"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Courses <b class="fa fa-angle-down"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="ttmenu-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <ul>
                                                            <li><a href="course-list.php">Courses List</a></li>
                                                            <li><a href="course-grid.php">Courses Grid</a></li>
                                                            <li><a href="course-filterable.php">Courses Filterable</a></li>
                                                            <li><a href="course-single.php">Single Course</a></li>
                                                            <li><a href="course-quiz.php">Take a Quiz</a></li>
                                                            <li><a href="course-achievements.php">Achievements</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <ul>
                                                            <li><a href="course-instructors.php">Course Instructors</a></li>
                                                            <li><a href="forums.php">Community Forums</a></li>
                                                            <li><a href="login.php">Login & Register</a></li>
                                                            <li><a href="my-profile.php">Edit Your Account</a></li>
                                                            <li><a href="course-testimonials.php">Happy Students</a></li>
                                                            <li><a href="course-faqs.php">Friendly Asked Questions</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-6 nopadding">
                                                    <img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_01.png.pagespeed.ic.2iuJZT3CaV.png" alt="">
                                                </div>
                                                <div class="col-md-3 col-sm-6 nopadding">
                                                    <img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_02.png.pagespeed.ic.c6RThoxSWC.png" alt="">
                                                </div>
                                                <div class="col-md-3 col-sm-6 nopadding">
                                                    <img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_03.png.pagespeed.ic.E_Ew4wn4ZP.png" alt="">
                                                </div>
                                                <div class="col-md-3 col-sm-6 nopadding">
                                                    <img class="img-thumbnail" src="<?php echo WEBSITE_ASSETS; ?>upload/xservice_04.png.pagespeed.ic.NGi9jRXTXk.png" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown ttmenu-half"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Features <b class="fa fa-angle-down"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="ttmenu-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <ul>
                                                            <li><a href="page-services.php">Our Services</a></li>
                                                            <li><a href="page-contact.php">Contact Us</a></li>
                                                            <li><a href="page-pricing.php">Pricing Tables</a></li>
                                                            <li><a href="page-shortcodes.php">Shortcodes</a></li>
                                                            <li><a href="page-typography.php">Typography</a></li>
                                                            <li><a href="page-fullwidth.php">Page Fullwidth</a></li>
                                                            <li><a href="page-sidebar.php">Page Sidebar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <ul>
                                                            <li><a href="page-shop.php">Shop Layout</a></li>
                                                            <li><a href="page-shop-single.php">Shop Single</a></li>
                                                            <li><a href="page-shop-single-alt.php">Shop Single Alt</a></li>
                                                            <li><a href="page-shop-cart.php">Shopping Cart</a></li>
                                                            <li><a href="blog.php">Blog & News</a></li>
                                                            <li><a href="single.php">Single Blog</a></li>
                                                            <li><a href="page-not-found.php">404 - Not Found</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="forums.php">Community</a></li>
                            <li><a href="blog.php">Blog</a></li>
                            <li><a href="page-contact.php">Contact</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/Student/registration"><i class="fa fa-sign-in"></i> Register Now</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
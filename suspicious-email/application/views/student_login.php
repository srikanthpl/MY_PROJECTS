<?php include 'include/head.php'; ?>
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

</style>
<body class="login">
    <div id="loader">
        <div class="loader-container">
            <img src="images/site.gif" alt="" class="loader-site">
        </div>
    </div>
    <div id="wrapper">
        <div class="container">
            <div class="row login-wrapper">
                <div class="col-md-6 col-md-offset-3">
                    <div class="logo logo-center">
                        <a href="index.html"><img src="images/xlogin-logo.png.pagespeed.ic.rk5LaeLYSz.png" alt=""></a>
                    </div>
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="#" class="active" id="login-form-link">Login</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#" id="register-form-link">Register</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="login-form" action="" method="post" role="form" style="display: block;">
                                        <div class="form-group">
                                            <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                        </div>
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
                                                <button type="submit" class="form-control btn btn-default color-green">Login Account</button>
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
                                <form id="register-form" action="http://phpoll.com/register/process" method="post" role="form" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="mobile no" id="mobile" tabindex="1" class="form-control" placeholder="Mobile" value="">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-option">
                                            <option value="volvo">State</option>
                                            <option value="saab">UP</option>
                                            <option value="mercedes">MP</option>
                                            <option value="audi">UK</option>
                                        </select>
                                        <select class="form-option">
                                            <option value="volvo">District</option>
                                            <option value="saab">Luckonw</option>
                                            <option value="mercedes">Delhi</option>
                                            <option value="audi">Noida</option>
                                        </select>
                                        <select class="form-option">
                                            <option value="volvo">State</option>
                                            <option value="saab">UP</option>
                                            <option value="mercedes">MP</option>
                                            <option value="audi">UK</option>
                                        </select>
                                        <select class="form-option">
                                            <option value="volvo">Univercity/School/Coaching</option>
                                            <option value="saab">1</option>
                                            <option value="mercedes">2</option>
                                            <option value="audi">2</option>
                                        </select>
                                        <select class="form-option">
                                            <option value="volvo">Class</option>
                                            <option value="saab">10</option>
                                            <option value="mercedes">11</option>
                                            <option value="audi">12</option>
                                        </select>
                                        <select class="form-option">
                                            <option value="volvo">Section</option>
                                            <option value="saab">A</option>
                                            <option value="mercedes">B</option>
                                            <option value="audi">C</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="submit" class="form-control btn btn-default btn-block">Register an Account</button>
                                            </div>
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
<script src="js/jquery.min.js.pagespeed.jm.iDyG3vc4gw.js"></script>
<script src="js/bootstrap.min.js%2bretina.js%2bwow.js.pagespeed.jc.pMrMbVAe_E.js"></script><script>eval(mod_pagespeed_gFRwwUbyVc);</script>
<script>eval(mod_pagespeed_rQwXk4AOUN);</script>
<script>eval(mod_pagespeed_U0OPgGhapl);</script>
<script src="js/carousel.js%2bcustom.js.pagespeed.jc.nVhk-UfDsv.js"></script><script>eval(mod_pagespeed_6Ja02QZq$f);</script>
<script>eval(mod_pagespeed_KxQMf5X6rF);</script>
</body>

<!-- Mirrored from templatevisual.com/demo/learnplus/course-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Jun 2018 15:49:06 GMT -->
</html>
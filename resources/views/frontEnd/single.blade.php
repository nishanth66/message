<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>land page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{asset('public/css/singlestyle.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div id="preloader"></div>
<!--top bar-->
<div id="home" class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <div class="tphone"><span>Phone:123 456 78900<br>Email:admin@gmail.com</span></div>
                </div>
                <div>
                    <div class="copyright1-text pull-right">
                        <div class="col-md-12">
                            <div class="col-sm-4 col-xs-4 col-md-4">
                                <form action="http://localhost/real/register.php">
                                    <button type="submit" class="registerbtn"><i class="fa fa-pencil"></i>REGISTER</button>
                                </form>
                            </div>
                            <div class="col-sm-4 col-xs-4 col-md-4">
                                    <button type="submit" class="registerbtn break"><i class="fa fa-lock" style="font-size: 19px;"></i> LOGIN</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--top bar end-->
<!--menu bar-->
<div class="menu-area sticky-menu">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <img src="{{asset('public/image/logo.png')}}">
            </div>
            <!-- Navigation starts -->
            <div class="col-md-10 col-sm-10">
                <div class="mainmenu">
                    <div class="navbar navbar-nobg">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse">
                            <nav>
                                <ul class="nav navbar-nav">
                                    <li class="active"><a class="smooth_scroll" href="single.php">HOME</a></li>
                                    <li><a class="smooth_scroll" href="#about">ABOUT</a></li>
                                    <li><a class="smooth_scroll" href="#service">SERVICES</a></li>
                                    <li><a class="smooth_scroll" href="#contact">CONTACT US</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Navigation ends -->
        </div>
    </div>
</div>
<!--end menu bar-->
<!-- Slider area starts -->
<section id="slider">
    <div id="carousel-example-generic" class="carousel slide">
        <div class="carousel-inner" role="listbox">
            <!-- Item 1 -->
            <div class="item active slide1">
                <div class="table">
                    <div class="table-cell">

                        <img src="{{asset('public/images/slide2.PNG')}}" class="immg1">
                    </div>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="item slide2">
                <div class="table">
                    <div class="table-cell">
                        <img src="{{asset('public/images/slide2.PNG')}}" class="immg1">
                    </div>
                </div>
            </div>
            <!-- Item 3 -->
            <div class="item slide3">
                <div class="table">
                    <div class="table-cell">
                        <img src="{{asset('public/images/slide2.PNG')}}" class="immg1">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Wrapper for slides-->
        <!-- Carousel Pagination -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
    </div>
</section>
<!--slider end-->
<section id="about" class="service-area section-big">
    <div class="col-md-12">
        <div class="col-md-6">
            <img src="{{asset('images/slide2.PNG')}}" class="about">
        </div>
        <div class="col-md-6">
            <div class="section-title text-center">
                <h2>About <span>Us</span></h2>
                <p class="color"> Man request adapted spirits set pressed. Up to denoting subjects sensible
                    feelings indul ged directly.
                    We dwelling elegance do shutters appetite yourself diverted. next drewem much you with rank. Tore
                    many
                    held age hold rose than our.</p>
                <h4 class="main"><i class="fa fa-quote-left"></i>Man request adapted spirits set pressed. Up to
                    denoting subjects sensible feelings indl ged directly. We
                    dwelling elegance do shutters appetite yourself diverted literature set any contrasted. Set aware
                    joy
                    sense young now tears china shy.<i class="fa fa-quote-right"></i></h4>
                <p class="color">Man request adapted spirits set pressed. Up to denoting subjects sensible
                    feelings indul ged directly.
                    We dwelling elegance do shutters appetite yourself diverted literature sent any contrasted. Set
                    aware
                    joy sense young now tears china shy.</p>
            </div>
        </div>
    </div>
</section>
<br>
<div class="container">
            <div class="section-title text-center">
                <h2>Pricing <span>Plans</span></h2>
            </div>
    <div class="demo">
        <div class="container" >
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <h3 class="title">Standard</h3>
                            <span class="sub-title">Lorem ipsum</span>
                            <span class="year">Pay only <br>$110/year</span>
                        </div>
                        <div class="price-value">
                            <div class="value">
                                <span class="currency">$</span>
                                <span class="amount">10.<span>99</span></span>
                                <span class="month">/month</span>
                            </div>
                        </div>
                        <ul class="pricing-content">
                            <li><i class="fa fa-check" aria-hidden="true"></i>50GB Disk Space</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>50 Email Accounts</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>50GB Monthly Bandwidth</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>10 Subdomains</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>15 Domains</li>
                        </ul>
                        <a href="#" class="pricingTable-signup">Sign up</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="pricingTable purple">
                        <div class="pricingTable-header">
                            <h3 class="title">Business</h3>
                            <span class="sub-title">Lorem ipsum</span>
                            <span class="year">Pay only <br>$220/year</span>
                        </div>
                        <div class="price-value">
                            <div class="value">
                                <span class="currency">$</span>
                                <span class="amount">20.<span>99</span></span>
                                <span class="month">/month</span>
                            </div>
                        </div>
                        <ul class="pricing-content">
                            <li><i class="fa fa-check" aria-hidden="true"></i>60GB Disk Space</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>60 Email Accounts</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>60GB Monthly Bandwidth</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>15 Subdomains</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>20 Domains</li>
                        </ul>
                        <a href="#" class="pricingTable-signup">Sign up</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="pricingTable blue">
                        <div class="pricingTable-header">
                            <h3 class="title">Business</h3>
                            <span class="sub-title">Lorem ipsum</span>
                            <span class="year">Pay only <br>$220/year</span>
                        </div>
                        <div class="price-value">
                            <div class="value">
                                <span class="currency">$</span>
                                <span class="amount">20.<span>99</span></span>
                                <span class="month">/month</span>
                            </div>
                        </div>
                        <ul class="pricing-content">
                            <li><i class="fa fa-check" aria-hidden="true"></i>60GB Disk Space</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>60 Email Accounts</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>60GB Monthly Bandwidth</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>15 Subdomains</li>
                            <li><i class="fa fa-check" aria-hidden="true"></i>20 Domains</li>
                        </ul>
                        <a href="#" class="pricingTable-signup">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<section id="contact" class="contact-area section-big">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title text-center">
                    <h2>Contact <span>US</span></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12">

            <div class="col-md-4 text-center ">
                <i class="fa fa-home fa1" style="font-size:24px"></i>
                <h2 class="link-2">Visit Us</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <h4>2 Elizabeth,London,UK</h4>
            </div>
            <div class="col-md-4 text-center vl">
                <i class="fa fa-phone fa1" style="font-size:24px"></i>
                <h2 class="link-2">Call Us</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <h4>*042134689</h4>
            </div>
            <div class="col-md-4 text-center vl">
                <i class="fa fa-envelope fa1" style="font-size:24px"></i>
                <h2 class="link-2">Message Us</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <h4>admin@gmail.com</h4>
            </div>
<!--            <div class="col-md-3 text-center">-->
<!--                <i class="fa fa-comment fa1" style="font-size:24px"></i>-->
<!--                <h2 class="link-2">Follow Us</h2>-->
<!--                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>-->
<!--                <a href="#" class="fa fa-facebook fa2"></a>-->
<!--                <a href="#" class="fa fa-twitter fa2"></a>-->
<!--                <a href="#" class="fa fa-google fa2"></a>-->
<!--            </div>-->
        </div>
    </div>
    <br>
<!--    <div class="container">-->
<!--            <div class="section-title text-center">-->
<!--                <h2>Follow US</h2>-->
<!--            </div>-->
<!--        <div class="col-md-12 text-center">-->
<!--            <div class="col-md-3">-->
<!--                <a href="#" class="fa fa-facebook fa2"></a>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <a href="#" class="fa fa-twitter fa2"></a>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <a href="#" class="fa fa-google fa2"></a>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <a href="#" class="fa fa-linkedin fa2"></a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <br>
    <section id="contact" class="contact-area section-big backgroundimg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-form ">
                        <div id="form-messages"></div>
                        <form id="ajax-contact"  method="post">
                            <div class="row backgroundimg">

                                <div class="col-sm-6">
                                    <div class="form-group in_name ficon mt-30">
                                        <span><i class="fa fa-user-o"></i></span>
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="Full Name" required="required">
                                    </div>
                                    <div class="form-group in_email ficon">
                                        <span><i class="fa fa-envelope-o"></i></span>
                                        <input type="email" name="email" class="form-control" id="email"
                                               placeholder="Email Address" required="required">
                                    </div>
                                    <div class="form-group in_subject ficon">
                                        <span><i class="fa fa-phone"></i></span>
                                        <input type="text" name="phone" class="form-control" id="phone"
                                               placeholder="Your Phone Number" required="required">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-30 in_message box-icon">
                                        <span><i class="fa fa-envelope"></i></span>
                                        <textarea name="message" class="form-control" id="message"
                                                  placeholder="Your Message" required="required"></textarea>
                                    </div>
                                    <div class="actions">
                                        <input type="submit" value="Send Message" name="submit" id="submitButton"
                                               class="btn" title="Submit Your Message!">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<br>


<!-- copyright area starts -->
<footer class="copyright-area ">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-12">
                <div class="col-sm-2 col-xs-6 col-md-2">
                    <h4 class="color2">Products</h4>
                    <p class="color1">Lorem</p>
                    <p class="color1">ipsum</p>
                    <p class="color1">dolor</p>
                    <p class="color1">amet</p>
                </div>
                <div class="col-sm-2 col-xs-6 col-md-2">
                    <h4 class="color2">Grooming Tips</h4>
                    <p class="color1">Lorem</p>
                    <p class="color1">ipsum</p>
                    <p class="color1">dolor</p>
                    <p class="color1">amet</p>
                </div>
                <div class="col-sm-2 col-xs-6 col-md-2">
                    <h4 class="color2">Baxter Of Califonia</h4>
                    <p class="color1">Lorem</p>
                    <p class="color1">ipsum</p>
                    <p class="color1">dolor</p>
                    <p class="color1">amet</p>
                </div>
                <div class="col-sm-2 col-xs-6 col-md-2">
                    <h4 class="color2">TERMS AND CONDITIONS</h4>
                </div>
                <div class="col-sm-2 col-xs-6 col-md-2">
                    <h4 class="color2">SECURITY POLICY</h4>
                </div>
                <div class="col-sm-2 col-xs-6 col-md-2">
                    <h4 class="color2">RETURN POLICY</h4>
                </div>
                <div class="col-sm-12 col-xs-12 col-md-12">
                    <div class="contact-form ">
                        <div class="form-group in_email ficon">
                            <span><i class="fa fa-envelope-o envelope1"></i></span>
                            <input type="email" name="email" class="form-control input envelope" id="email"
                                   placeholder="Email Address">
                            <h3 class="color3">Sign Up On Our Email And Get 15% OFF On Your First Purchase</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 col-md-12">
            <div class="col-sm-2 col-xs-2 col-md-2">
                <div class="copyright-text">
                    <p>All Rights Reserved © </p>
                </div>
            </div>
            <div class="col-sm-10 col-xs-10 col-md-10">
                <div class="copyright-text pull-right">
                    <div class="footer-social">
                        <a href=""><i class="fa fa-rss"></i></a>
                        <a href=""><i class="fa fa-twitter"></i></a>
                        <a href=""><i class="fa fa-facebook"></i></a>
                        <a href=""><i class="fa fa-skype"></i></a>
                        <a href=""><i class="fa fa-google-plus"></i></a>
                        <a href=""><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!---- copyright area ends ---->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{asset('public/js/main_script.js')}}"></script>

</body>
</html>
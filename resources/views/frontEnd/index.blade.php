<?php
use App\Models\slideImage;
use App\Models\landing;
$slideImage = slideImage::get();
$count = slideImage::get()->count();
$landing = landing::first();
$packages = \App\Models\packages::inRandomOrder()->limit(3)->get();
?>
<head>
    <title>Messenger | Home</title>
</head>
@include('frontEnd.header')
<style>
    .MultiCarousel { float: left; overflow: hidden; padding: 15px; width: 100%; position:relative;margin-left:-1% }
    .MultiCarousel .MultiCarousel-inner { transition: 1s ease all; float: left; }
    .MultiCarousel .MultiCarousel-inner .item { float: left;}
    .MultiCarousel .MultiCarousel-inner .item > div { text-align: center; padding:10px; margin:10px;}
    .MultiCarousel .leftLst, .MultiCarousel .rightLst { position:absolute; border-radius:50%;top:calc(50% - -3%);background: transparent;font-size: 25px;color: #a11916;margin-top: -2%;margin-left: 1.5%;
    }
    .MultiCarousel .leftLst { left:0; }
    .MultiCarousel .rightLst { right:0; }

    .MultiCarousel .leftLst.over, .MultiCarousel .rightLst.over { pointer-events: none; background:#fff; }


    .sliderHomeImg
    {
        /*height: 250px;*/
        /*width: 217px;*/
    }
    .sliderCart
    {
        font-size: 25px;
        padding-top: 10px;
    }
    .main-header .logo
    {
        padding: 0!important;
    }
    @media only screen and (max-width: 768px) {
        .MultiCarousel { float: left; overflow: hidden; padding: 15px; width: 100%; position:relative;margin-left: 1% }
    }
</style>

<div class="container">
    <div class="slideshow-container">
        <?php
        $i=1;
        ?>
        @foreach($slideImage as $img)
            <div class="mySlides fade1">
                <div class="numbertext table">{{$i}} / {{$count}}</div>
                <img src="{{asset('public/avatars').'/'.''.$img->image.''}}"  class="SliderImg">
            </div>
            <?php
            $i++;
            ?>
        @endforeach

        <a class="prev1" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next1" onclick="plusSlides(1)">&#10095;</a>

    </div>
<!--slider end-->
    <section id="about" class="service-area section-big">
        <div class="row">
            <div class="col-md-6">
                @if($landing->main_image=='' || empty($landing->main_image))
                    <img src="{{asset('public/avatars/default.jpg')}}" class="about">
                @else
                    <img src="{{asset('public/avatars').'/'.''.$landing->main_image.''}}" class="about">
                @endif
            </div>
            <div class="col-md-6">
                <div class="section-title text-center">
                    <h2 class="heading">ABOUT <span>US</span></h2>
                    <p class="color"> <?php echo $landing->main_page_text; ?> </p>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-10 about-text">
            <p class="color"><?php echo $landing->sub_page_text; ?></p>
        </div>


    </section>
</div>
<br>
<div class="container" id="packages">
    <div class="section-title text-center">
        <h2 class="heading">PRICING <span>PLANS</span></h2>
    </div>

    <div class="demo">
        <div class="container" >
            <div class="row">
                <?php
                $i=0;
                ?>
                @foreach($packages as $package)
                    @if($i%2 == 0)
                        <div class="col-md-4 col-sm-4">
                            <div class="pricingTable">
                                <div class="pricingTable-header">
                                    <h4 class="packageName">{{$package->package_name}}</h4>
                                    <span class="year">Initial charge<br>${{$package->initial_setup}}</span>
                                </div>
                                <div class="price-value">
                                    <div class="value">
                                        <span class="currency">$</span>
                                        <span class="amount">{{$package->yearly_subscribe}}</span>
                                        <span class="month">/year</span>
                                    </div>
                                </div>
                                <ul class="pricing-content">
                                    <?php
                                    $features = explode(',', $package->features);
                                    ?>
                                    @foreach($features as $feature)
                                        <li><i class="fa fa-check" aria-hidden="true"></i>{{$feature}}</li>
                                    @endforeach
                                </ul>
                                <a href="{{url('/register'.'/'.$package->id)}}" class="pricingTable-signup">Sign up</a>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4 col-sm-4">
                            <div class="pricingTable purple">
                                <div class="pricingTable-header">
                                    <h4 class="packageName">{{$package->package_name}}</h4>
                                    <span class="year">Initial Charge<br>${{$package->initial_setup}}</span>
                                </div>
                                <div class="price-value">
                                    <div class="value">
                                        <span class="currency">$</span>
                                        <span class="amount">{{$package->yearly_subscribe}}</span>
                                        <span class="month">/year</span>
                                    </div>
                                </div>
                                <ul class="pricing-content">
                                    <?php
                                    $features = explode(',', $package->features);
                                    ?>
                                    @foreach($features as $feature)
                                        <li><i class="fa fa-check" aria-hidden="true"></i>{{$feature}}</li>
                                    @endforeach
                                </ul>
                                <a href="{{url('/register'.'/'.$package->id)}}" class="pricingTable-signup">Sign up</a>
                            </div>
                        </div>
                    @endif
                    <?php
                    $i++;
                    ?>
                @endforeach
            </div>
            <br/>
            <center><a href="{{url('view/packages')}}"><button type="button" class="btn11 btn-primary11">View More</button></a></center>
        </div>
    </div>

</div>
<section id="contact" class="contact-area section-big">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title text-center">
                    <h2 class="heading">CONTACT <span>US</span></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12">

            <div class="col-md-4 text-center vl v3">
                <i class="fa fa-home fa1 faSize"></i>
                <h3 class="link-2">Visit Us</h3>
                <br/><p class="contactDetails"><a class="contactLink" target="_blank" href="http://maps.google.com/?q={{$landing->Address}}"><u><b>{{$landing->Address}}</b></u></a></p>
            </div>
            <div class="col-md-4 text-center vl v3">
                <i class="fa fa-phone fa1 faSize"></i>
                <h3 class="link-2">Call Us</h3>
                <p class="contactDetails"><a class="contactLink" href="tel:{{$landing->Phone}}"><u><b>{{$landing->Phone}}</b></u></a></p>
            </div>
            <div class="col-md-4 text-center vl v2">
                <i class="fa fa-envelope fa1 faSize"></i>
                <h3 class="link-2">Message Us</h3>
                <p class="contactDetails"><a class="contactLink" href="mailto:{{$landing->email}}"><u><b>{{$landing->email}}</b></u></a></p>
            </div>

        </div>
    </div>
    <br>

    <br>
    <section id="contact" class="backgroundimg contact-area section-big">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-form ">
                        <div id="form-messages"></div>
                        <div class="row backgroundimg">
                            <form method="post" action="{{url('send/message')}}">
                                {{csrf_field()}}
                                <div class="col-sm-6">
                                    <div class="form-group in_name ficon mt-30">
                                        <span><i class="fa fa-user-o"></i></span>
                                        <input type="text" name="name" class="form-control2" id="name"
                                               placeholder="Full Name" required="required">
                                    </div>
                                    <div class="form-group in_email ficon">
                                        <span><i class="fa fa-envelope-o"></i></span>
                                        <input type="email" name="email" class="form-control2" id="email"
                                               placeholder="Email Address" required="required">
                                    </div>
                                    <div class="form-group in_subject ficon">
                                        <span><i class="fa fa-phone"></i></span>
                                        <input type="text" name="phone" class="form-control2" id="phone"
                                               placeholder="Your Phone Number" required="required">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mt-30 in_message box-icon">
                                        <span><i class="fa fa-envelope"></i></span>
                                        <textarea name="message" class="form-control2" id="message"
                                                  placeholder="Your Message" required="required"></textarea>
                                    </div>
                                    <div class="actions">
                                        <input type="submit" value="Send Message" name="submit" id="submitButton"
                                               class="submitBtnFront" title="Submit Your Message!">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<br>
<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
    }
</script>
@include('frontEnd.footer')
<script>
    $(document).ready(function () {
        var itemsMainDiv = ('.MultiCarousel');
        var itemsDiv = ('.MultiCarousel-inner');
        var itemWidth = "";

        $('.leftLst, .rightLst').click(function () {
            var condition = $(this).hasClass("leftLst");
            if (condition)
                click(0, this);
            else
                click(1, this)
        });

        ResCarouselSize();


        $(window).resize(function () {
            ResCarouselSize();
        });

        //this function define the size of the items
        function ResCarouselSize() {
            var incno = 0;
            var dataItems = ("data-items");
            var itemClass = ('.item');
            var id = 0;
            var btnParentSb = '';
            var itemsSplit = '';
            var sampwidth = $(itemsMainDiv).width();
            var bodyWidth = $('body').width();
            $(itemsDiv).each(function () {
                id = id + 1;
                var itemNumbers = $(this).find(itemClass).length;
                btnParentSb = $(this).parent().attr(dataItems);
                itemsSplit = btnParentSb.split(',');
                $(this).parent().attr("id", "MultiCarousel" + id);


                if (bodyWidth >= 1200) {
                    incno = itemsSplit[3];
                    itemWidth = sampwidth / incno;
                }
                else if (bodyWidth >= 992) {
                    incno = itemsSplit[2];
                    itemWidth = sampwidth / incno;
                }
                else if (bodyWidth >= 768) {
                    incno = itemsSplit[1];
                    itemWidth = sampwidth / incno;
                }
                else {
                    incno = itemsSplit[0];
                    itemWidth = sampwidth / incno;
                }
                $(this).css({'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers});
                $(this).find(itemClass).each(function () {
                    $(this).outerWidth(itemWidth);
                });

                $(".leftLst").addClass("over");
                $(".rightLst").removeClass("over");

            });
        }


        //this function used to move the items
        function ResCarousel(e, el, s) {
            var leftBtn = ('.leftLst');
            var rightBtn = ('.rightLst');
            var translateXval = '';
            var divStyle = $(el + ' ' + itemsDiv).css('transform');
            var values = divStyle.match(/-?[\d\.]+/g);
            var xds = Math.abs(values[4]);
            if (e == 0) {
                translateXval = parseInt(xds) - parseInt(itemWidth * s);
                $(el + ' ' + rightBtn).removeClass("over");

                if (translateXval <= itemWidth / 2) {
                    translateXval = 0;
                    $(el + ' ' + leftBtn).addClass("over");
                }
            }
            else if (e == 1) {
                var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
                translateXval = parseInt(xds) + parseInt(itemWidth * s);
                $(el + ' ' + leftBtn).removeClass("over");

                if (translateXval >= itemsCondition - itemWidth / 2) {
                    translateXval = itemsCondition;
                    $(el + ' ' + rightBtn).addClass("over");
                }
            }
            $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
        }

        //It is used to get some elements from btn
        function click(ell, ee) {
            var Parent = "#" + $(ee).parent().attr("id");
            var slide = $(Parent).attr("data-slide");
            ResCarousel(ell, Parent, slide);
        }

    });
</script>
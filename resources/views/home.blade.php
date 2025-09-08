<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
  <meta charset="utf-8" />
  <title>EXAM360: How to list products on EXAM360 ?</title>
  <meta name="description" content="Discover EXAM360, your trusted e-commerce online book store! Buy a wide range of books at unbeatable manufacturer prices. Explore affordable options for academic, competitive exams, and more!">
  <meta name="keywords" content="Exam360, online books store, buy books online, books at manufacturer price, cheap books online, academic books, competitive exam books, e-books, school books, college textbooks, affordable books, exam preparation books, study material, reference books, educational books, discount books, book store online, entrance exam books, exam guide books, exam360 books.">
  <meta name="author" content="EXAM360 (INDIA)">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="theme-color" content="#ffd6d6">
  <!--website-favicon-->
  <link rel="shortcut icon" type="image/x-icon" href="assets/images/brand/favicon.ico" />
  <!--plugin-css-->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/plugin.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- template-style-->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">
  <link href="css/darkmode.css" rel="stylesheet">
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>

<body>
  <!--Start Preloader -->
  <div class="onloadpage" id="page_loader">
    <div class="pre-content">
      <div class="logo-pre"><img src="logo.png" alt="Logo" class="img-fluid" /></div>
      <div class="pre-text- text-radius text-light text-animation bg-b">EXAM360 (INDIA) Allows to List Your Product & Grow Your Business with EXAM360’s Supplier Program. Join Now!</div>
    </div>
  </div>
  <!--End Preloader -->
  <!--Start Header -->
  <header class="nav-bg-w main-header navfix fixed-top">
    <div class="container-fluid m-pad">
      <div class="menu-header">
        <div class="dsk-logo"><a class="nav-brand" href="{{ url('/') }}">
            <img src="logo.png" alt="Logo" class="mega-white-logo" />
            <img src="logo.png" alt="Logo" class="mega-darks-logo" width="250px" style="max-width: 70%;max-height: 60%;" />
          </a></div>
        <div class="custom-nav" role="navigation">
          <ul class="nav-list onepge" style='grid-gap:10px;'>
            <li><a href="#home" class="menu-links">Home</a></li>
            <li><a href="#about" class="menu-links">About</a></li>
            <li><a href="#review" class="menu-links">Reviews</a></li>
            <li><a href="#contact" class="menu-links">Contact</a></li>
            <li><a href="https://support.exam360.in/freelance-partner" class="menu-links">FREELANCE</a></li>
            <li><a href="{{ route('register') }}" class="btn-br bg-btn5 btshad-b2 lnk">Signup <span class="circle"></span></a> </li>
            <li><a href="{{ !auth() ->check() ? route('login') : route('dashboard', ['sort' => 'desc', 'tab' => 'unshipped', 'paginate' => 50]) }}" class="btn-br bg-btn5 btshad-b2 lnk">Office Login <span class="circle"></span></a> </li>
          </ul>
        </div>
        <div class="mobile-menu2">
          <ul class="mob-nav2">
            <li><a href="#contact" class="btn-round- trngl btn-br bg-btn btshad-b1"><i class="fas fa-envelope-open-text"></i></a></li>
            <li class="navm-"> <a class="toggle" href="#"><span></span></a></li>
          </ul>
        </div>
      </div>
      <!--Mobile Menu-->
      <nav id="main-nav">
        <ul class="first-nav">
          <li><a href="#home" class="menu-links">Home</a></li>
            <li><a href="#about" class="menu-links">About</a></li>
            <li><a href="#review" class="menu-links">Reviews</a></li>
            <li><a href="#contact" class="menu-links">Contact</a></li>
            <li><a href="https://support.exam360.in/freelance-partner">FREELANCE</a></li>
            <li><a href="{{ route('register') }}" class="btn-br bg-btn5 btshad-b2 lnk">Signup <span class="circle"></span></a> </li>
            <li><a href="{{ !auth() ->check() ? route('login') : route('dashboard', ['sort' => 'desc', 'tab' => 'unshipped', 'paginate' => 50]) }}" class="btn-br bg-btn5 btshad-b2 lnk">Office Login <span class="circle"></span></a> </li>
        </ul>
        <ul class="bottom-nav">
          <li class="prb">
            <a href="tel:+917370005777">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 384">
                <path d="M353.188,252.052c-23.51,0-46.594-3.677-68.469-10.906c-10.719-3.656-23.896-0.302-30.438,6.417l-43.177,32.594
								c-50.073-26.729-80.917-57.563-107.281-107.26l31.635-42.052c8.219-8.208,11.167-20.198,7.635-31.448
								c-7.26-21.99-10.948-45.063-10.948-68.583C132.146,13.823,118.323,0,101.333,0H30.813C13.823,0,0,13.823,0,30.813
								C0,225.563,158.438,384,353.188,384c16.99,0,30.813-13.823,30.813-30.813v-70.323C384,265.875,370.177,252.052,353.188,252.052z" />
              </svg>
            </a>
          </li>
          <li class="prb">
            <a href="mailto:exam360.in@gmail.com">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                <path d="M0 0h24v24H0z" fill="none" />
              </svg>
            </a>
          </li>
          <li class="prb">
            <a href="skype:niwax.company?call">
              <svg enable-background="new 0 0 24 24" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg">
                <path d="m23.309 14.547c1.738-7.81-5.104-14.905-13.139-13.543-4.362-2.707-10.17.352-10.17 5.542 0 1.207.333 2.337.912 3.311-1.615 7.828 5.283 14.821 13.311 13.366 5.675 3.001 11.946-2.984 9.086-8.676zm-7.638 4.71c-2.108.867-5.577.872-7.676-.227-2.993-1.596-3.525-5.189-.943-5.189 1.946 0 1.33 2.269 3.295 3.194.902.417 2.841.46 3.968-.3 1.113-.745 1.011-1.917.406-2.477-1.603-1.48-6.19-.892-8.287-3.483-.911-1.124-1.083-3.107.037-4.545 1.952-2.512 7.68-2.665 10.143-.768 2.274 1.76 1.66 4.096-.175 4.096-2.207 0-1.047-2.888-4.61-2.888-2.583 0-3.599 1.837-1.78 2.731 2.466 1.225 8.75.816 8.75 5.603-.005 1.992-1.226 3.477-3.128 4.253z" />
              </svg>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <!--End Header -->
  <!--Start Hero-->
  <section class="hero-section fl-hero" id="home">
    <div class="text-block">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 v-center">
            <div class="header-heading">
              <span class="title- wow fadeInUp" data-wow-delay=".1s">Become Our Supply Partner</span>
              <h1 class="wow fadeInUp" data-wow-delay=".2s"><span>Want To Highlight</span> Your Products?</h1>
              <p class="wow fadeInUp" data-wow-delay=".4s">✨ Want your products to stand out? Highlight them with Exam360! Just supply us with your items, and we’ll showcase them in front of thousands of eager buyers.</p>
              <a href="#contact" class="btn-main bg-btn lnk wow fadeInUp" data-wow-delay=".6s">Connect with us <i class="fas fa-chevron-right fa-icon"></i><span class="circle"></span></a>
            </div>
          </div>
          <div class="col-lg-6 wow fadeIn" data-wow-delay=".4s">
            <div class="single-image">
              <img src="images/hero/freelancer-mobile.png" alt="service" class="img-fluid" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--End Hero-->
  <!--Start About-->
  <section class="about-freelance pad-tb" id="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="common-heading text-l">
            <span>PARTNERS WITH EXAM360</span>
            <h2 class="mb20">We Care Our Partner's</h2>
            <p>Say goodbye to the hassle of endless policies and frequent penalties from typical e-commerce. Partner with EXAM360 for a seamless, thriving business journey. We focus on supporting your growth and success, creating a win-win situation for both of us. Together, let’s make your business flourish! </p>
            <div class="follow-label mt30">
              <h6>Follow Us</h6>
              <a href="javascript:void(0)" target="blank" class="wow bounceIn" data-wow-delay=".2s"><i class="fab fa-facebook"></i></a>
              <a href="javascript:void(0)" target="blank" class="wow bounceIn" data-wow-delay=".4s"><i class="fab fa-instagram"></i></a>
              <a href="javascript:void(0)" target="blank" class="wow bounceIn" data-wow-delay=".6s"><i class="fab fa-dribbble"></i></a>
              <a href="javascript:void(0)" target="blank" class="wow bounceIn" data-wow-delay=".8s"><i class="fab fa-behance"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="counter-facts">
            <div class="counter-no mb20 wow bounceIn" data-wow-delay=".2s">
              <div class="hexagon hexa1" data-tilt data-tilt-max="20" data-tilt-speed="1000">
                <div class="counter-number">
                  <span class="counter">3</span><span>L</span>
                  <p>Customers Base</p>
                </div>
              </div>
            </div>
            <div class="counter-no mb20  wow bounceIn" data-wow-delay=".4s">
              <div class="hexagon hexa2" data-tilt data-tilt-max="20" data-tilt-speed="1000">
                <div class="counter-number">
                  <span class="counter">100</span><span>+</span>
                  <p>Associate Partners</p>
                </div>
              </div>
            </div>
            <div class="counter-no mt20  wow bounceIn" data-wow-delay=".6s">
              <div class="hexagon hexa3" data-tilt data-tilt-max="20" data-tilt-speed="1000">
                <div class="counter-number">
                  <span class="counter">6</span><span>L</span>
                  <p>Package Shipped</p>
                </div>
              </div>
            </div>
            <div class="counter-no mt20  wow bounceIn" data-wow-delay=".8s">
              <div class="hexagon hexa4" data-tilt data-tilt-max="20" data-tilt-speed="1000">
                <div class="counter-number">
                  <span class="counter">10</span><span>Yrs.</span>
                  <p>E-com Experience</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--End About-->
  <!--Start Service-->
  <!-- <section class="bhv-service bg-gradient3 pad-tb deep-dark" id="services">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="common-heading">
            <span>Service</span>
            <h2 class="mb30">Specializing In</h2>
          </div>
        </div>
      </div>
      <div class="row upset link-hover shape-num justify-content-center">
        <div class="col-lg-3 col-sm-6 mt30 shape-loc  wow fadeIn" data-wow-delay=".2s">
          <div class="s-block" data-tilt data-tilt-max="5" data-tilt-speed="1000">
            <div class="s-card-icon"><img src="images/icons/branding.svg" alt="service" class="img-fluid" /></div>
            <h4>Logo & Branding Service</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <a href="javascript:void(0)">Learn More <i class="fas fa-chevron-right fa-icon"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 mt30 shape-loc  wow fadeIn" data-wow-delay=".5s">
          <div class="s-block" data-tilt data-tilt-max="5" data-tilt-speed="1000">
            <div class="s-card-icon"><img src="images/icons/development.svg" alt="service" class="img-fluid" /></div>
            <h4>Website Design & Development</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <a href="javascript:void(0)">Learn More <i class="fas fa-chevron-right fa-icon"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 mt30 shape-loc  wow fadeIn" data-wow-delay=".8s">
          <div class="s-block" data-tilt data-tilt-max="5" data-tilt-speed="1000">
            <div class="s-card-icon"><img src="images/icons/app.svg" alt="service" class="img-fluid" /></div>
            <h4>Mobile App Development</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <a href="javascript:void(0)">Learn More <i class="fas fa-chevron-right fa-icon"></i></a>
          </div>
        </div>
      </div>
      <div class="-cta-btn mt70">
        <div class="free-cta-title v-center  wow zoomInDown" data-wow-delay="1.1s">
          <p>Let's Start A <span>New Project Together</span></p>
          <a href="#" class="btn-main bg-btn2 lnk">Get A Quote <i class="fas fa-chevron-right fa-icon"></i><span class="circle"></span></a>
        </div>
      </div>
    </div>
  </section> -->
  <!--End Service-->
  <!--Start Portfolio-->
  <!-- <section class="portfolio-section pad-tb" id="work">
    <div class="container">
      <div class="row justify-content-center ">
        <div class="col-lg-8">
          <div class="common-heading">
            <span>Our Work</span>
            <h2 class="mb0">Our Latest Creative Work</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 col-sm-8 mt60 wow fadeInUp" data-wow-delay="0.2s">
          <div class="isotope_item hover-scale">
            <div class="item-image" data-tilt data-tilt-max="2" data-tilt-speed="1000">
              <a href="#"><img src="images/portfolio/image-d.jpg" alt="image" class="img-fluid" /> </a>
            </div>
            <div class="item-info">
              <h4><a href="#">Ecommerce Development</a></h4>
              <p>Web Application</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4 mt60 wow fadeInUp" data-wow-delay="0.4s">
          <div class="isotope_item hover-scale">
            <div class="item-image" data-tilt data-tilt-max="2" data-tilt-speed="1000">
              <a href="#"><img src="images/portfolio/image-1.jpg" alt="image" class="img-fluid" /> </a>
            </div>
            <div class="item-info">
              <h4><a href="#">Creative App</a></h4>
              <p>iOs, Android</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4 mt60 wow fadeInUp" data-wow-delay="0.6s">
          <div class="isotope_item hover-scale">
            <div class="item-image" data-tilt data-tilt-max="2" data-tilt-speed="1000">
              <a href="#"><img src="images/portfolio/image-6.jpg" alt="image" class="img-fluid" /> </a>
            </div>
            <div class="item-info">
              <h4><a href="#">Brochure Design</a></h4>
              <p>Graphic, Print</p>
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-sm-8 mt60 wow fadeInUp" data-wow-delay="0.8s">
          <div class="isotope_item hover-scale">
            <div class="item-image" data-tilt data-tilt-max="2" data-tilt-speed="1000">
              <a href="#"><img src="images/portfolio/image-c.jpg" alt="image" class="img-fluid" /> </a>
            </div>
            <div class="item-info">
              <h4><a href="#">Icon Pack</a></h4>
              <p>iOs, Android</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!--End Portfolio-->
  <!--Start Clients-->
  <section class="clients-section pad-tb" id="clients">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="common-heading">
            <span>Partner's Brand</span>
            <h2>Some of the Top Notch Brands Associated With Us</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="opl">
            <ul>
              <li class=" wow fadeIn" data-wow-delay=".2s">
                <div class="clients-logo"><img src="images/client/clients-1.png" alt="text" class="img-fluid" /></div>
              </li>
              <li class=" wow fadeIn" data-wow-delay=".4s">
                <div class="clients-logo"><img src="images/client/clients-2.png" alt="text" class="img-fluid" /></div>
              </li>
              <li class=" wow fadeIn" data-wow-delay=".6s">
                <div class="clients-logo"><img src="images/client/clients-3.png" alt="text" class="img-fluid" /></div>
              </li>
              <li class=" wow fadeIn" data-wow-delay=".8s">
                <div class="clients-logo"><img src="images/client/clients-4.png" alt="text" class="img-fluid" /></div>
              </li>
              <li class=" wow fadeIn" data-wow-delay="1s">
                <div class="clients-logo"><img src="images/client/clients-5.png" alt="text" class="img-fluid" /></div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--End Clients-->
  <!--Start Testinomial-->
  <section class="testinomial-section pad-tb" id="review">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 v-center">
          <div class="common-heading text-l">
            <span>Our Reviews Are Not Paid !!</span>
            <h2 class="mb0">What Our Genuine & valuable customer's say about us?</h2>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="owl-carousel testimonial-card-a pl25">
            <div class="testimonial-card">
              <div class="t-text">
                <p>I'm a PhD student and this is my genuine review. Exam360 team had genuineness and selling in affordable price. You can 100% believe and go ahead. I purchased three GATE exam related books and I was happy to their service. They are gradually speeding up the delivery service and in future I believe their service will get reputation. (Order Id - 671DEC41645C6665348894, Order Value - 1946, Order Date - 27 Oct 2024 For Future Reference).</p>
              </div>
              <div class="client-thumbs mt30">
                <div class="media v-center">
                  <div class="user-image bdr-radius"><img src="images/user-thumb/girl.jpg" alt="girl" class="img-fluid" /></div>
                  <div class="media-body user-info v-center">
                    <h5>KETHAVATH HEMANTH NAIK</h5>
                    <p>PHD Student, <small>Kerala, India</small></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="testimonial-card">
              <div class="t-text">
                <p>My honest review for this app or Exam360 Company system is above to five Star. Salute to you Sir for this amazing mindset who cares about Students 🙏. ~ 🙌🖤. Note - This Review is given by one of our valuable customers who made a purcase for the very first time from us which is given are as follows - Order Date: 22 July 2024, Order Id: 669E59222B999920508708 For Future Reference.</p>
              </div>
              <div class="client-thumbs mt30">
                <div class="media v-center">
                  <div class="user-image bdr-radius"><img src="images/user-thumb/GirlA.jpg" alt="girl" class="img-fluid" /></div>
                  <div class="media-body user-info">
                    <h5>Sachin Yadav</h5>
                    <p>Student, <small>Rajasthan, India</small></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="testimonial-card">
              <div class="t-text">
                <p>Very cheap and genuine books are available here from ***** and *****. Everything is good here but work will have to be done only on the delivery system. And the packaging of the book will have to be a little advanced. This is a small problem, if you want to solve all these problems then there will be no better app than this. love you For Bengal ♥️.</p>
              </div>
              <div class="client-thumbs mt30">
                <div class="media v-center">
                  <div class="user-image bdr-radius"><img src="images/user-thumb/boyA.png" alt="girl" class="img-fluid" /></div>
                  <div class="media-body user-info">
                    <h5>Rahul Kumar Mandal</h5>
                    <p>Customer <small>West Bengal, India</small></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--End Testinomial-->
  <!--Start Enquire Form-->
  <section class="enquire-form pad-tb" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="common-heading text-l">
            <span>Contact Now</span>
            <h2 class="mt0 mb0">Have Question? Write a Message</h2>
            <p class="mb60 mt20">We will catch you as early as we receive the message</p>
          </div>
          <div class="form-block">
            <form action="#" method="post" name="feedback-form">
              @csrf
              <div class="fieldsets row">
                <div class="col-md-6"><input type="text" placeholder="Full Name" name="name"></div>
                <div class="col-md-6"><input type="email" placeholder="Email Address" name="email"></div>
              </div>
              <div class="fieldsets row">
                <div class="col-md-6"><input type="number" placeholder="Contact Number" name="number"></div>
                <div class="col-md-6"><input type="text" placeholder="Subject" name="subject"></div>
              </div>
              <div class="fieldsets"><textarea placeholder="Message" name="message"></textarea></div>
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1" checked="checked">
                <label class="custom-control-label" for="customCheck">I agree to the <a href="https://support.exam360.in/Page/Terms%20&%20Conditions">Terms &amp; Conditions</a> of EXAM360® (INDIA).</label>
              </div>
              <div class="fieldsets mt20"> <button type="submit" name="submit" class="lnk btn-main bg-btn">Submit <i class="fas fa-chevron-right fa-icon"></i><span class="circle"></span></button> </div>
              <p class="trm"><i class="fas fa-lock"></i>We hate spam, and we respect your privacy.</p>
            </form>
          </div>
        </div>
        <div class="col-lg-6 v-center">
          <div class="enquire-image">
            <img src="images/about/freelancer.png" alt="enquire" class="img-fluid" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--End Enquire Form-->

  <!--Start Footer-->
  <footer>
    <div class="footer-row1">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="email-subs">
              <h3>Get New Insights Weekly</h3>
              <p>Subscribe now for weekly updates! Stay informed with the latest news and insights—don’t miss out. Subscribe today!</p>
            </div>
          </div>
          <div class="col-lg-6 v-center">
            <div class="email-subs-form">
              <form>
                <input type="email" placeholder="Email Your Address" name="emails">
                <button type="submit" name="submit" class="lnk btn-main bg-btn">Subscribe <i class="fas fa-chevron-right fa-icon"></i><span class="circle"></span></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-svg">
      <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        viewBox="0 0 1920 80" style="enable-background:new 0 0 1920 80;" xml:space="preserve">
        <path class="st0" d="M0,27.2c589.2,129.4,1044-69,1920,31v-60H3.2L0,27.2z" />
      </svg>
    </div>
    <div class="footer-row2">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 col-sm-12 text-center">
            <a class="navbar-brand img-ctr" href=""> <img src="logo.png" alt="Logo" width="250" /></a>
            <ul class="footer-link-v2 link-hover mt30">
              <li><a href="https://listing.exam360.in/">Home</a></li>
              <li><a href="https://support.exam360.in/partners_programme">Supply Partner</a></li>
              <li><a href="https://support.exam360.in/Page/Fullfilment%20Partner">Fulfilment Partner</a></li>
              <li><a href="https://support.exam360.in/freelance-partner">Freelance Partner</a></li>
              <li><a href="https://support.exam360.in/Page/Affiliate%20Partner">Affiliate Partner</a></li>
              <li><a href="https://support.exam360.in/">Contact Support</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <hr class="hline">
    <div class="footer-row3">
      <div class="copyright">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="footer-social-media-icons">
                <a href="https://www.facebook.com/exam360.in/" target="blank"><i class="fab fa-facebook"></i></a>
                <a href="https://x.com/exam360official" target="blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/exam360official/" target="blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/exam360/" target="blank"><i class="fab fa-linkedin"></i></a>
                <a href="https://www.youtube.com/channel/UCowbUxJW2_90e7kwHCQCYzQ" target="blank"><i class="fab fa-youtube"></i></a>
                <a href="https://in.pinterest.com/exam360_official/" target="blank"><i class="fab fa-pinterest-p"></i></a>
              </div>
              <div class="footer-">
                <p>© 2015-2025. All Rights Reserved By <a href="https://support.exam360.in/" target="blank">EXAM360® (INDIA)</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--End Footer-->

  <!-- js placed at the end of the document so the pages load faster -->
  <script src="js/vendor/modernizr-3.5.0.min.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/plugin.min.js"></script>
  <script src="js/preloader.js"></script>
  <!--common script file-->
  <script src="js/main.js"></script>
</body>

</html>
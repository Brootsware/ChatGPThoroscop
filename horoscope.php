<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

function generateHoroscope($sign)
{
  // API endpoint and parameters
  $endpoint = 'https://api.openai.com/v1/completions';
  $apiKey = '<PLACE YOUR CHAT GPT API KEY HERE>';
  $model = 'text-davinci-002';
  $text = "Write seperate daily horoscope paragraphs about yesterday, today and tomorrow for $sign each paragraph starts with \"--START--\" and ends with \"--END--\"";
  $parameters = [
    'prompt' => $text,
    'temperature' => 0.7,
    'max_tokens' => 400,
    'n' => 1,
    'stop' => '\n'
  ];

  // Send request to API

  $client = new \GuzzleHttp\Client();
  try {
    $response = $client->post($endpoint, [
      'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $apiKey
      ],
      'json' => [
        'model' => $model,
        'prompt' => $text,
        'temperature' => $parameters['temperature'],
        'max_tokens' => $parameters['max_tokens'],
        'n' => $parameters['n'],
        'stop' => $parameters['stop']
      ]
    ]);
    // Get completion from response
    $completion = json_decode($response->getBody(), true)['choices'][0]['text'];
    // Output completion
    // echo $completion . "<br><br><br><br>";

    // Extract different parts of a string
    $string = $completion;
    $string = str_replace("--END--", "", $string);
    $parts = explode("--START--", $string);

    $last_updated = date('Y-m-d');
    array_unshift($parts, $last_updated);

    // Write parts in a json file as an array
    $data = array(
      'date' => $parts[0],
      'yesterday' =>  $parts[2],
      'today' =>  $parts[3],
      'tomorrow' =>  $parts[4]
    );

    $json_string = json_encode($data);

    // Write the JSON string to a file
    if ((isset($parts[2])) && (isset($parts[3])) && (isset($parts[4]))) {
      file_put_contents("signs/$sign.json", $json_string);
    }
  } catch (Exception $e) {
    // Handle error
    echo 'Error: ' . $e->getMessage();
  }
}





// Get the type of horoscope sign from index.html input
if (isset($_POST["zodiacsign"])) {
  $zodiacsign = $_POST["zodiacsign"];
}

$json_string = file_get_contents("signs/$zodiacsign.json");
$horoscope = json_decode($json_string, true);
//Check the updated date of zodiacsign.json
$lastupdated = $horoscope["date"];
$lastupdated = strtotime($lastupdated);
$lastupdated = date('Y-m-d', $lastupdated); // Output: 2022-04-05


$today = date('Y-m-d');

if ($lastupdated >= $today) {
  // echo "The date in $lastupdated is earlier than or equal today's $today.";
} else {
  // echo "The date in $lastupdated is the same or later than today's $today.";

  // Call function here
  generateHoroscope($zodiacsign);
}





?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Brootsware</title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" /> -->

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet" />
  <style>
    /* CSS for loading gif */
    #loading-gif {
      display: none;
      position: absolute;
      top: 75%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>

</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="logo">
        <h1 class="text-light">
          <a href="index.html"><span>Brootsware</span></a>
        </h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.html">Home</a></li>
          <!-- <li><a class="nav-link scrollto" href="#footer">About Us</a></li>
            <li><a class="nav-link scrollto" href="#services">Services</a></li> -->
          <!-- <li>
              <a class="nav-link scrollto" href="#portfolio">Portfolio</a>
            </li> -->
          <!-- <li><a class="nav-link scrollto" href="#team">Team</a></li> -->
          <!-- <li class="dropdown">
              <a href="#"
                ><span>Drop Down</span> <i class="bi bi-chevron-down"></i
              ></a>
              <ul>
                <li><a href="#">Drop Down 1</a></li>
                <li class="dropdown">
                  <a href="#"
                    ><span>Deep Drop Down</span>
                    <i class="bi bi-chevron-right"></i
                  ></a>
                  <ul>
                    <li><a href="#">Deep Drop Down 1</a></li>
                    <li><a href="#">Deep Drop Down 2</a></li>
                    <li><a href="#">Deep Drop Down 3</a></li>
                    <li><a href="#">Deep Drop Down 4</a></li>
                    <li><a href="#">Deep Drop Down 5</a></li>
                  </ul>
                </li>
                <li><a href="#">Drop Down 2</a></li>
                <li><a href="#">Drop Down 3</a></li>
                <li><a href="#">Drop Down 4</a></li>
              </ul>
            </li> -->
          <li><a class="nav-link scrollto" href="#footer">Contact</a></li>
          <li>
            <a class="getstarted scrollto" href="#MiddleFooter">Get Started</a>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <!-- .navbar -->
    </div>
  </header>
  <!-- End Header -->

  <main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <!-- <section class="breadcrumbs">
        <div class="container">
          <div class="d-flex justify-content-between align-items-center">
            <h2>Home Page</h2>
            <ol>
              <li><a href="index.html">Home</a></li>
              <li>Inner Page</li>
            </ol>
          </div>
        </div>
      </section> -->
    <!-- End Breadcrumbs Section -->

    <section class="inner-page">
      <div class="container">
        <!-- <p>Example inner page template</p> -->

        <!-- First ad -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3623964572767035" crossorigin="anonymous"></script>
        <!-- ad -->
        <ins class="adsbygoogle" style="display: block" data-ad-client="ca-pub-3623964572767035" data-ad-slot="4806588369" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

        <!-- <p></p> -->
      </div>
    </section>


    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Horoscope</h2>
          <p>Your horoscope is here <?= $zodiacsign ?></p>
        </div>

        <div class="row">
          <div class="col-md-4 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
              <!-- <div class="icon"><i class="bx bxl-dribbble"></i></div> -->
              <h4 class="title"><a href="">Yesterday</a></h4>
              <p class="description"><?= $horoscope["yesterday"] ?></p>
            </div>
          </div>

          <div class="col-md-4 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box">
              <!-- <div class="icon"><i class="bx bx-file"></i></div> -->
              <h4 class="title"><a href="">Today</a></h4>
              <p class="description"><?= $horoscope["today"] ?></p>
            </div>
          </div>

          <div class="col-md-4 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box">
              <!-- <div class="icon"><i class="bx bx-tachometer"></i></div> -->
              <h4 class="title"><a href="">Tomorrow</a></h4>
              <p class="description"><?= $horoscope["tomorrow"] ?></p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->


    <footer id="MiddleFooter">

    </footer>
    <div id="loading-gif">
      <img src="assets/img/giphy.gif" alt="Loading...">
    </div>
    <section class="inner-page">
      <div class="container">
        <!-- Second ad -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3623964572767035" crossorigin="anonymous"></script>
        <!-- ad -->
        <ins class="adsbygoogle" style="display: block" data-ad-client="ca-pub-3623964572767035" data-ad-slot="4806588369" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>
    </section>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <!-- <div class="footer-newsletter">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6">
              <h4>Join Our Newsletter</h4>
              <p>
                Tamen quem nulla quae legam multos aute sint culpa legam noster
                magna
              </p>
              <form action="" method="post">
                <input type="email" name="email" /><input
                  type="submit"
                  value="Subscribe"
                />
              </form>
            </div>
          </div>
        </div>
      </div> -->

    <div class="footer-top">
      <div class="container">
        <div class="row">


          <div class="col-lg-6 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li>
                <i class="bx bx-chevron-right"></i> <a href="#">Home</a>
              </li>
              <!-- <li>
                  <i class="bx bx-chevron-right"></i> <a href="#">About us</a>
                </li>
                <li>
                  <i class="bx bx-chevron-right"></i> <a href="#">Services</a>
                </li> -->
              <li>
                <i class="bx bx-chevron-right"></i>
                <a href="terms/terms-and-conditions.html">Terms of service</a>
              </li>
              <li>
                <i class="bx bx-chevron-right"></i>
                <a href="terms/privacy-policy.html">Privacy policy</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Brootsware</h3>
            <!-- <p>
                  A108 Adam Street <br />
                  New York, NY 535022<br />
                  United States <br /><br />
                  <strong>Phone:</strong> +1 5589 55488 55<br /> -->
            <strong>Email:</strong> Brootsware@gmail.com<br />
            </p>
          </div>

          <!-- <div class="col-lg-3 col-md-6 footer-links">
              <h4>Our Services</h4>
              <ul>
                <li>
                  <i class="bx bx-chevron-right"></i> <a href="#">Web Design</a>
                </li>
                <li>
                  <i class="bx bx-chevron-right"></i>
                  <a href="#">Web Development</a>
                </li>
                <li>
                  <i class="bx bx-chevron-right"></i>
                  <a href="#">Product Management</a>
                </li>
                <li>
                  <i class="bx bx-chevron-right"></i> <a href="#">Marketing</a>
                </li>
                <li>
                  <i class="bx bx-chevron-right"></i>
                  <a href="#">Graphic Design</a>
                </li>
              </ul>
            </div> -->

          <!-- <div class="col-lg-3 col-md-6 footer-links">
              <h4>Our Social Networks</h4>
              <p>
                Cras fermentum odio eu feugiat lide par naso tierra videa magna
                derita valies
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"
                  ><i class="bx bxl-instagram"></i
                ></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div> -->
        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span>Brootsware</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Developed by <a href="https://Brootsware.com/" target=”_blank”>Brootsware</a>
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script>
    const form = document.getElementById('username-form');
    const loadingGif = document.getElementById('loading-gif');

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      loadingGif.style.display = 'block';

      // Submit the form using your preferred method, such as fetch or XMLHttpRequest
      // In this example, we're just setting a timeout to simulate a delay
      setTimeout(() => {
        // alert('Form submitted!');
        loadingGif.style.display = 'none';
        form.submit();
      }, 5000);

    });
  </script>
</body>

</html>
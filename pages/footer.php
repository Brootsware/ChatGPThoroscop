<footer id="MiddleFooter">

</footer>
<div id="loading-gif">
    <img src="../assets/img/giphy.gif" alt="Loading...">
</div>

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
                    <strong>Email:</strong> brootsware@gmail.com<br />
                    </p>
                </div>

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

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="../assets/vendor/aos/aos.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="../assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>
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
<!-- footer -->
<!--  data-aos="fade-up" data-aos-duration="1500" -->
<footer id="footer">
    <h1 class="text-center">galaxy</h1>
    <p class="text-center">mlem lêm ẹnib faibibc ybiec yiaea biy fuwwg w f uyrsgf iyr ujdhfignuvh srifguckjhs irufkgc jhvi7rsukfjch</p>
    <div class="icons text-center">
        <i class="bx bxl-twitter"></i>
        <i class="bx bxl-facebook"></i>
        <i class="bx bxl-google"></i>
        <i class="bx bxl-skype"></i>
        <i class="bx bxl-instagram"></i>
    </div>
    <div class="copyright text-center">
        &copy;Copyright <strong>.All rights Reserved</strong>
    </div>
    <div class="credite text-center">
        Designed By <a href="#"><span>Bobu Coding</span></a>
    </div>
</footer>
<!-- footer end -->


<button id="showButton" class="button-48" role="button"><span class="text">ChatBot</span></button>


<script src="script.js"></script>
<script>
    const showButton = document.getElementById('showButton');
    const hiddenDiv = document.getElementById('hiddenDiv');
    const hideButton = document.getElementById('hideButton');

    showButton.addEventListener('click', () => {
        hiddenDiv.style.display = 'block';
    });

    hideButton.addEventListener('click', () => {
        hiddenDiv.style.display = 'none';
    });
</script>
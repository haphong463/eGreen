<!-- footer -->
<!--  data-aos="fade-up" data-aos-duration="1500" -->
<footer id="footer">
    <h1 class="text-center">TEAM TREE</h1>
    <p class="text-center">Trees are our life, let's join hands to protect all trees in the world.</p>
    <div class="icons text-center">
        <i class="bx bxl-twitter"></i>
        <i class="bx bxl-facebook"></i>
        <i class="bx bxl-google"></i>
        <i class="bx bxl-skype"></i>
        <i class="bx bxl-instagram"></i>
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
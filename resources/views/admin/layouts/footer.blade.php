<footer class="footer-main-block">
    <p id="copyright"></p>
</footer>

<script>
    var currentYear = new Date().getFullYear();
    document.getElementById("copyright").innerHTML = "© Copyright " + currentYear + ", All Rights Reserved Version " + "{{ config('app.version') }}";
</script>

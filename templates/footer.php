    <!-- Script 8.3 - footer.php -->
<!-- END CHANGEABLE CONTENT. -->
</main>

        <footer container class="siteFooter">
            <p>Design uses <a href="http://concisecss.com/">Concise CSS Framework</a></p>
            <?php
                date_default_timezone_set('America/Chicago');
                echo "<p align=center>" . date("h:i") . "<br>" . date("m/d/Y") . "</p>";
            ?>
        </footer>
    </body>
</html>

<?php
//sends buffer to browser and turns off buffering
ob_end_flush();
?>
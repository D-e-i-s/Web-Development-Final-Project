<?php // Script 8.4 - index.php
/* This is the home page for this site.
It uses templates to create the layout.
*/

// Include the header:
include('templates/header.php');
// Leave the PHP section to display lots of HTML:
?>

<h2>Welcome to Stephen's Tech-Singularity!</h2>

<p>At Stephen's tech singularity, we discuss, review, and speculate about all of Stephen's favorite tech.  This includes 
    books, devices, games, and more.  Please explore the site and become a member today.</p>

<?php // Return to PHP.

include('templates/footer.php');
date_default_timezone_set("America/Chicago");
// Include the footer.


?>
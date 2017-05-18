<?php
include('templates/header.php');

// reset session array
$_SESSION = [];

// destroy session data on server
session_destroy();

?>
<p> You have been logged out.</p>
<br>
<br>
<a href='index.php'>Return to Techify homepage.</a>

<?php
include('templates/footer.php');
?>
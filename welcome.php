<?php
include 'header.php';
$goHome = "";
// si está logeat mostra un enllaça a home
if (isset($_SESSION['username'])) {

    $goHome = "<a href='home.php'>you are loged, visit the home page</a";

}
?>
<div class="wrapper">
<h1>Welcome to TED Talks<h1>
	<?php echo $goHome; ?>
</div>
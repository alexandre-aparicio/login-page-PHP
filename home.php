<?php
include 'header.php';
echo "<div class='wrapper'>
                  <h1>It is the Home Page<h1>
                  </div>";


$searchErr = "";
if (!isset($_SESSION['username'])) {

    header('location: welcome.php');

} else {

    if (isset($_GET['search'])) {
        // Si no esta buida fa sa recerca, si no, dona error

        if (!empty($_GET["search"])) {
            $wordToSearch = test_input($_GET["search"]);
            $categoryToSearch = test_input($_GET["category"]);
            header('location: results.php?word=' . $wordToSearch . '&category=' . $categoryToSearch);
        } else {
            $searchErr = "No has insertat res, torna provar-ho";
        }
    }
}
?>
<div id="wrapper">
<form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
    <label>Search:</label>
    <input type="text" name="search"> <span class='errorCode'><?php echo $searchErr;?></span>
    <label>What do you search for?:</label>
    <select type="submit" id="category" name="category">
        <option value="title">Title</option>
        <option value="speaker">Speaker</option>
        <option value="event">Event</option>
    </select>
    <input type="submit"  id="submit" />   

</form>
</div>
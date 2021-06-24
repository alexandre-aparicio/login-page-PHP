<?php
include 'header.php';
$session_id = session_id();
$date_now = date("Y-m-d H:i:s");
$conn = connect();
if ($conn !==false) {

        $sql = "UPDATE session SET closed = '$date_now' WHERE id_session = '$session_id'";
        if($conn->query($sql) === true){
            echo "<div class='wrapper'>
<h1>You are Logout. Thanks for your visit. <h1>
</div>";
        } 
$conn->close();
}
session_regenerate_id();
session_destroy();

header("Refresh:2; url=welcome.php");
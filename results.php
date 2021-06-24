<?php
include 'header.php';

echo "<br>";

if (!isset($_SESSION['username'])) {

    header('location: welcome.php');

} else {

    $wordToSearch = $_GET["word"];
    $categoryToSearch = $_GET["category"];
    // Destria quin tipus de recerca ariba
    if ($categoryToSearch == "title") {
        // per fer ses recerques utilitza la funció searchDb

        $sql = searchDb("talk.title", "$wordToSearch");
        $what = "Title: ";

    } elseif ($categoryToSearch == "speaker") {
        $sql = searchDb("speaker.name", "$wordToSearch");
        $what = "Speaker: ";

    } elseif ($categoryToSearch == "event") {
        $sql = searchDb("event.name", "$wordToSearch");
        $what = "Event: ";

    // Si no pertany a cap de les tres, torna enrera.    
    } else {
        header('location: home.php');
     
    }
?>

<?php    
    $conn = connect();
    // utilitza la funció connect y si la conexió és corecta, no dona resultat false...
    if ($conn !== false) {

        $result = $conn->query($sql);
        // A n'aquesta variable es per sa quantitat de resultats
        $resultNumber = $result->num_rows;
        $i=1;
        // si troba resultats fa un while
        if ($resultNumber  > 0) {
                echo "<div class='goBack' ><a href='home.php'><< Go back</a></div>";

           ?> 
            
    <div class="results">
        <h1>Talks for <?php echo $what . "\"" . $wordToSearch . "\"" . ". " . $resultNumber . " results found."; ?></h1>
    </div>
        <div class="wrapper02">

    <div class="grid">
    <div class="encabezados">Name</div>
    <div class="encabezados">Comments</div>
    <div class="encabezados">Views</div>
    <div class="encabezados">Pictures</div>
    <div class="encabezados">Talk about</div>
    <div class="encabezados">Speaker</div>
    <div class="encabezados">Event & Filming Date</div>
    <div class="encabezados">Duration</div>
    <div class="encabezados">Tags</div>
    <div class="encabezados">Url Video</div> 
    <?php  

            while ($row = $result->fetch_assoc()) {

                $id_talk = $row["id_talk"];
                $name = $row["titles"];
                $comment = $row["comment"];
                $view = $row["view"];
                $descr = $row["descr"];
                $image = $row["img"];
                $id_speaker = $row["speakerId"];
                $numSpeakers = $row["speakerNum"];
                $speaker = $row["speakerName"];
                $speaker = "<p>" . $speaker . "</p>";
                $eventName = $row["eventName"];
                $filmDate = $row["filmDate"];
                $filmDate = strtotime( $filmDate);
                $filmDate = date( 'Y-M-d', $filmDate );
                $duration = $row["duration"];
                $duration = secToHR($duration);
                $video = $row["video"];

                // Si el nombre de conferenciants és més d'un...
                if ($numSpeakers > 1) {
                    //Amb la funció searchLoQueSea fa una consulta cercant els conferenciants i els concatena
                    $speaker = searchLoQueSea("speaker.name","talk_speaker","speaker","speaker.id=talk_speaker.id_speaker","id_talk=$id_talk",$conn);
                  
                }
                // per fer una recerca dels tag a la que pertany la conferència uilitza la funció searchLoQueSea
                $tagName = searchLoQueSea("tag.name","talk_tag","tag","talk_tag.id_tag=tag.id","id_talk=$id_talk",$conn);

?>

        <div class="title">
            <p><?php echo $name ?></p>
        </div>
        <div class="Cell">
            <p><?php echo $comment ?></p>
        </div>
        <div class="Cell">
            <p><?php echo $view ?></p>
        </div>
        <div class="image">
            <img src="<?php echo $image ?>" alt="<?php $name ?>" width="120">
        </div>
        <div class="description" style="overflow-y: scroll;"><?php echo $descr ?></div>
        <div class="Cell">
            <?php echo $speaker ?>
        </div>
        <div class="Cell">
            <p><?php echo $eventName ?></p>
            <br>
            <p><?php echo $filmDate ?></p>
        </div>
        <div class="Cell">
            <p><?php echo $duration ?></p>
        </div>
        <div class="tag" style="overflow-y: scroll;">
            <p><?php echo $tagName ?></p>
        </div>
        <div class="Cell">
            <p><a href="<?php echo $video ?>">Video url</a></p>
        </div>
        

    
  

<?php


                $i++;
            }

        } else {

            echo "<div class='wrapper'>
                  <h1>Results no found<h1>
                  </div>";
            
        }
        $conn->close();
    }
}
?>
    
</div>

</div> 
<div class='goBack' ><a href='home.php'><< Go back</a></div>

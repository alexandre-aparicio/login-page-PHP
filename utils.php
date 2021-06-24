<?php
//Variables
$userNameErr = "";
$emailErr = "";
$passErr = "";
$passRepErr = "";
$validate = "";
$password = "";
$table = "";
$column = "";

//Funcions
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function connect()
{
    //Conexió a la base de dades
    $servername = "localhost";
    $username = "alejandro";
    $password = "Contrasenya1234";
    $dbname = "ted-alumnes";

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
    if ($conn->connect_error) {
        return false;
    }
    return $conn;
}

//Segons a Hores:Minuts:Segons

function secToHR($seconds) {
  $hours = floor($seconds / 3600);
  $minutes = floor(($seconds / 60) % 60);
  $seconds = $seconds % 60;
  return "$hours:$minutes:$seconds";
}

//Funció per ses diferentes recerques... Segons títol, Conferenciant o Event.
function searchDb($table, $wordToSearch) {

        $search = "SELECT talk.id id_talk, talk.title titles, talk.comments comment, talk.views view, talk.description descr,talk.hero img, talk_speaker.id_speaker speakerId, count(*) speakerNum, speaker.name speakerName, event.name eventName, talk.film_date filmDate, talk.duration duration, talk.url video
FROM talk
JOIN talk_speaker ON talk_speaker.id_talk = talk.id 
JOIN speaker ON speaker.id = talk_speaker.id_speaker
JOIN event ON talk.id_event = event.id
WHERE $table LIKE '%$wordToSearch%' GROUP BY talk.id ";

return $search;
}

// Aquesta funció l'he emprada per quan havia més d'un conferenciant i per treure els tags
function searchLoQueSea($loQue,$loDonde,$loJoin,$loTablaIgual,$loIgual, $conexio) {

  $sql = "SELECT $loQue name from $loDonde JOIN $loJoin ON $loTablaIgual WHERE $loIgual";;
$result = $conexio->query($sql);
  $enlazando = "";
  while($row = $result->fetch_assoc()) {
    $speaker = $row["name"];
    $speaker = "<p>". $speaker. "</p>";
    $enlazando = $enlazando . " ". $speaker;


}
return $enlazando;
};



 
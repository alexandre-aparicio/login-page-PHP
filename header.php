<link rel='stylesheet' href='style.css' />
<div id="header">
<?php
include 'utils.php';
session_start();
$session_id = session_id();
$date_now = date("Y-m-d H:i:s");

if (!isset($_SESSION['username'])) {



    echo "<div class='heaText'><a href=\"register.php\"> Register</a></div>";
    echo "<div class='heaText'>|</div>";

    echo "<div class='heaText'><a href=\"login.php\">Sign in</a></div>";

} else {
    $userName = $_SESSION['username'];
  
    $conn = connect();
    if ($conn !==false) {
        // cerc l'id de lùsuari per afagir-lo a la taula sessio
        $sql = "SELECT id_users FROM users WHERE username='$userName'";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
        $idUserDb = $row["id_users"];
        }
        // fa una recerca de les sesions a la base de dades amb la sessió actual
        $sql = "SELECT * FROM  session WHERE id_session = '$session_id'";
        $result = $conn->query($sql);
        $resultNumber = $result->num_rows;
        //Si troba resultats
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                //retorna la data de la última interacció
                $modifiedDb = $row["modified"];
            }
            //Calculam quans de minuts han passat entre la data de la base de dades y la data d'ara
            $minutos = (strtotime($date_now)-strtotime($modifiedDb))/60;
            $minutos = abs($minutos); $minutos = floor($minutos);
           


            // Si han passat menys de 30 minuts atulitza la taula session amb l'hora d'interacció.
            if ($minutos<30) {
                //Actualitza la base de dades
                $sql = "UPDATE session SET modified = '$date_now' WHERE id_session = '$session_id'";
                $conn->query($sql);

            } else {
                //Sino,  destrueix la sessió
                header('location: destroy.php');
            }

        } else {
            // Si no existeix la id de la sessió a la taula sessio, la afegeig
            $sql = "INSERT INTO session (id_session, id_user,created, modified) values ('$session_id','$idUserDb', '$date_now', '$date_now')";
            $conn->query($sql);
        }


        $conn->close();
    }
    echo "<div class='heaTextUser'>Welcome " . $userName . "</div>";
echo "<div class='heaText'><a href=\"destroy.php\">Log Out</a></div>";

}
?>
</div>
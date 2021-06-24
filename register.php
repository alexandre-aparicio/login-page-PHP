<?php
include 'header.php';

//Aquí hi ha d'anar la validació de que les dades son correctes

if (isset($_SESSION['username'])) {

    header('location: home.php');

} else {

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validate = true;
    $userName = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);

    $password = test_input($_POST["password"]);
    $passwordRep = test_input($_POST["passwordRep"]);

    if (empty($userName)) {
        $userNameErr = "This fiels is necessary";
        $validate = false;

    }

    if (empty($password)) {
        $passErr = "This fiels is necessary";
        $validate = false;

    }
    if (!preg_match("#.*^(?=.{8,12})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password)){
        $passErr = "Your password is not safe. Between 8 and 12 characters, one number, a capitalizee leter and a lower letter";
        $validate = false;
    }

    if (empty($passwordRep)) {
        $passRepErr = "This fiels is necessary";
        $validate = false;

    }

    If ($password !== $passwordRep) {
        $passErr = "Not coincidence";
        $validate = false;
    }

    if (!preg_match("/^[A-Za-z]{1}[A-Za-z0-9_$@#-.]{5,}/", $userName)) {
        $userNameErr = "6 charters min. & must start with letter._-$@# charters permited";
        $validate = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $validate = false;
    }


}
// Aquí es connecta a la base de dades si ha passat la validació

if ($validate == true) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $conn = connect();

    if ($conn !== false) {

        //Fa una recerca a la base de dades per veure si ja està registrat per mail o per usuari

        $sql = "SELECT * FROM users WHERE email='$email' OR username='$userName'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {

            // Si no troba resultats s'inserten les dades a la bases de dades

            $sql = "INSERT INTO users (username, email, password, create_count) VALUES ('$userName', '$email', '$password', '$date_now' )";
            if ($conn->query($sql) === TRUE) {

                echo "S'ha enregistrat amb exit";
                $_SESSION["username"] = $userName;
                // I es redirigeix a Home
                header('location: home.php');
                $conn->close();

            } else {
                echo "ERROR";
            }
        } else {

            // Si ha trobat coincidencies...
            echo "<div class='wrapper'>
                  
                  <h1 class='errorCode'>Aquest usuari ja existeix<h1>
                  </div>";

        }

    }

        $conn->close();
    }

}

echo "<div class='wrapper'>
                  
                  <h1>Register Page<h1>
                  </div>";



?>
<div id="wrapper">
   <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"> 
        <label for="name">User Name</label><span class='errorCode'><?php echo $userNameErr;?></span>
        <input type="text" name="name" />
        <label for="email">Email</label><span class='errorCode'><?php echo $emailErr;?></span>
        <input type="text" name="email" />
        <label for="telephone">Password</label><span class='errorCode'><?php echo $passErr;?></span>
        <input type="password" name="password" />
        <label for="telephone">Repeat Password</label><span class='errorCode'><?php echo $passRepErr;?></span>
        <input input type="password" name="passwordRep" />
        <input type="submit" value="Send" name="submit" id="submit" />   
    </form>
</div>

<?php
include 'header.php';


// Si l'usuari ha inciat sessió ho redirigeix a Home
if (isset($_SESSION['username'])) {

    header('location: home.php');

} else {

//Aquí fa la validació de que les dades al formulari són correctes

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validate = true;
    $userName = test_input($_POST["userName"]);
    $password = test_input($_POST["password"]);


    if (empty($userName)) {
        $userNameErr = "This fiels is necessary";
        $validate = false;

    }
    if (empty($password)) {
        $userNameErr = "This fiels is necessary";
        $validate = false;

    }

    // Aquí valida si el usuari está registrat a la base de dades

    $conn = connect();
    if ($conn !==false) {

        $sql = "SELECT * FROM users WHERE username='$userName'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $userNameDb = $row["username"];
                $passwordDb = $row["password"];
            }
            if (password_verify($password, $passwordDb)) {
                echo 'Password is valid!';

                if ($validate == true) {

                    
                    $_SESSION["username"] = $userName;
                    $conn->close();
                    header('location: home.php');


                }
            } else {
                echo "<div class='wrapper'>
                  <h1 class='errorCode'>Incorrect Password</h1>
                  </div>";
            }

        } else {

            echo "<div class='wrapper'>
                  <h1 class='errorCode'>Incorrect User Name</h1>
                  </div>";


        }
        $conn->close();
    }

}
}   

echo "<div class='wrapper'>
                  
                  <h1>Login Page<h1>
                  </div>";
               

?>

<div id="wrapper">
   <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"> 
       
        <label for="name">User Name</label><?php echo $userNameErr;?>
        <input type="text" name="userName" />

        <label for="telephone">Password</label><?php echo $passErr;?>
        <input type="password" name="password" />

        <input type="submit" value="Send" name="submit" id="submit" />   
    </form>
</div>
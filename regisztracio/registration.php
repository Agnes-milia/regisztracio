<?php
include_once 'class-user.php';  

    $felh = new User(); // Checking for user logged in or not

    if (isset($_REQUEST['submit'])){
        extract($_REQUEST);
        $register = $felh->reg_felhasznalo($nev, $email, $jelszo);
        if (!$register) {
            // sikertelen regisztráció
            echo 'Sikertelen regisztráció. Email vagy felhasználónév már létezik. Próbáld újra!';
        }
    }
?>

<!DOCTYPE html>
<html lang="hu-HU">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Regisztráció</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main>
            <h1>Regisztráció</h1>
            <form action="" method="post" name="reg">
                <label>Felhasználói név:</label>
                <input type="text" name="nev" required="" /><br><br>
                <label>Email:</label>
                <input type="text" name="email" required="" /><br><br>
                <label>Password:</label>
                <input type="password" name="jelszo" required="" /><br><br>
                <input type="submit" name="submit" value="Regisztráció" /><br><br>
                <a href="login.php">Belépéshez kattints ide</a>
            </form>
        </main>
    </body>
</html>

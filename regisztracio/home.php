<?php
session_start();
include_once 'class-user.php';

$felh = new User(); 
$felhAzon = $_SESSION['felhAzon'];
$_SESSION['iranyit'] = "";

if (!$felh->get_session()){
    header("location:login.php");
}

if (isset($_GET['q'])){
    $felh->kijelentkezes();
    header("location:login.php");
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
            <div>
				<a href="home.php?q=logout">LOGOUT</a>
			</div>
            <div>
				<h1>Hello <?php $felh->get_nev($felhAzon); ?>!</h1>
            </div>
			<?php
				if ($felh->isAdmin($felhAzon))
					{
						echo "<h2>Bejelentkezett felhasználók:</h2>";
						$matrix = $felh->aktivok();
						$felh->megjelenit_aktivok($matrix);
                        echo "<a href='category.php'>Kategóriák felvitele, módosítása vagy törlése</a>";
                        echo "<a href='category-routpost.php'>Kategóriák felvitele útvonallal</a>";
					}
			?>
        </main>
    </body>
</html>
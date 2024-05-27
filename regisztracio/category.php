<?php
    include_once 'class-user.php';
    $felh = new User();
    session_start();
    if (!empty($_SESSION['iranyit'])) {
        header("Location: home.php");
        exit(); 
    }
?>
<!DOCTYPE html>
<html lang="hu-HU">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kategória</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h2>Kategória felvitele</h2>
		<form action="category.php" method="POST">
            <!-- <input type="hidden" name="_method" value="POST"> -->
            <label for="name">Név:</label>
            <input type="text" id="name" name="name"><br>
            <label for="price">Ár:</label>
            <input type="text" id="price" name="price"><br>
            <input type="submit" name="felvetel" value="Küldés">
        </form>

        <?php
            /* var_dump($_POST); */
			if (isset($_POST["felvetel"])) {
                $nev = $_POST['name']; 
                $ar = $_POST['price'];
                // Ide jön a további feldolgozás vagy adatbázisba mentés stb.
                try {
                    $felh->beszur("kategoria", $ar, $nev);
                } catch (\Throwable $th) {
                    echo "A név egyedi!";
                }
                $_SESSION['iranyit'] = 1;
            }
		?>

        <h2>Kategória módosítása</h2>
		<form action="category.php" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <label for="kategoria">Kategória:</label>
            <select name="kategoria" id="kategoria">
                <?php
                    $felh->megjelenit("kategoria", "nev", "ar");
                ?>
            </select><br>
            <label for="name">Név:</label>
            <input type="text" id="name" name="name"><br>
            <label for="price">Ár:</label>
            <input type="text" id="price" name="price"><br>
            <input type="submit" name="modosit" value="Küldés">
        </form>

        <?php
            if (isset($_POST['_method']) && $_POST['_method'] == 'PUT' && isset($_POST["modosit"])) {
                $regiNev = $_POST["kategoria"];
                $nev = $_POST['name'];
                $ar = $_POST['price'];
                // módosítás végrehajtása
                $felh->modosit("kategoria", $ar, $regiNev, $nev);
                $_SESSION['iranyit'] = 1;
                echo '<script type="text/javascript">';
                echo 'window.location.reload();';
                echo '</script>';
            }
        ?>      

        <h2>Kategória törlése</h2>
		<form action="category.php" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <label for="kategoria">Kategória:</label>
            <select name="kategoria" id="kategoria">
                <?php
                    $felh->megjelenit("kategoria", "nev", "ar");
                ?>
            </select><br>
            <input type="submit" name="torles" value="Törlés">
        </form>

        <?php
            if (isset($_POST['_method']) && $_POST['_method'] == 'DELETE' && isset($_POST["torles"])) {
                // törlés végrehajtása
                $nev = $_POST["kategoria"];
                $felh->torles("kategoria", "nev", $nev);
                $_SESSION['iranyit'] = 1;
                echo '<script type="text/javascript">';
                echo 'window.location.reload();';
                echo '</script>';

            }
        ?>      
    </body>
</html>

<!DOCTYPE html>
<html lang="hu-HU">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>aktív felhasználók</title>
    </head>
    <body>
        <?php
			include_once 'class.user.php';
			$felh = new User();
			$matrix = $felh->aktivok();
			$felh->megjelenit_aktivok($matrix);
		?>
    </body>
</html>

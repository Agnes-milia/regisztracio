<!DOCTYPE html>
<html lang="hu-HU">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kategória</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h2>Kategória felvitele útvonallal</h2>
		<form action="/regisztracio/api/category" method="POST">
            <label for="nameU">Név:</label>
            <input type="text" id="nameU" name="nameU" required><br>
            <label for="priceU">Ár:</label>
            <input type="text" id="priceU" name="priceU" required><br>
            <input type="submit" value="Küldés">
        </form>   
    </body>
</html>
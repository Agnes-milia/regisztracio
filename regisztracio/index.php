<?php

// Példa: URL elemzése és megfelelő funkció hívása
/* $requestUri = $_SERVER['REQUEST_URI']; */
$requestUri = strtok($_SERVER['REQUEST_URI'], '?'); //kérdőjel nélkül
$requestMethod = $_SERVER['REQUEST_METHOD'];
$basePath = '/regisztracio'; // Az alkalmazás gyökérútvonala

// Eltávolítjuk a gyökérútvonalat a kérésekből
$path = str_replace($basePath, '', $requestUri);
if ($path == "/") {
    header("Location: login.php");
}

// Például meghatározhatjuk az útvonalakat egy asszociatív tömb segítségével
$routes = [
    '/about' => __DIR__ . '/views/about.php',
	'/active' => __DIR__ . '/active-users.php',
    '/contact' => __DIR__ . '/views/contact.php',
    '/api/category/{id}' => __DIR__ . '/api/category-all.php',
    '/api/category' => __DIR__ . '/api/category-all.php',
	'/404' => __DIR__ . '/views/404.php'
];

$routesOthers = [
    'POST' => [
        '/api/category' => __DIR__ . '/api/category-all.php',
        // további POST útvonalak
    ],
    'PUT' => [
        '/api/category/{id}' => __DIR__ . '/api/category-all.php',
        // további PUT útvonalak
    ],
    'DELETE' => [
        '/api/category/{id}' => __DIR__ . '/api/category-all.php',
        // további DELETE útvonalak
    ],
];


// Ha az útvonal szerepel a definiált útvonalak között, importáljuk a megfelelő fájlt
if ($requestMethod == 'GET') {
    list($filePath, $params) = matchRoute($path, $routes);

    if ($filePath) {
        // Include the matched file
        include($filePath);
    } else {
        // Include the 404 error page
        include($routes['/404']);
    }
}
else {
    // Ha az útvonal szerepel a definiált útvonalak között, importáljuk a megfelelő fájlt
    if (isset($routesOthers[$requestMethod][$path])) {
        require $routesOthers[$requestMethod][$path];
    } 
    /* else {
        http_response_code(404);
    } */
}

function matchRoute($path, $routes) {
    // Dinamikus útvonal
    if (preg_match('/^\/api\/category\/(\d+)$/', $path, $matches)) {
        return [$routes['/api/category/{id}'], $matches];
    }
    // statikus útvonal
    if (isset($routes[$path])) {
        return [$routes[$path], []];
    }
    return [null, []];
}



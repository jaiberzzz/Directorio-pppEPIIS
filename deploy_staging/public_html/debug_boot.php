<?php
// debug_boot.php (Versión 2) - Sube esto a public_html y recarga en el navegador
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Debug de Arranque Laravel - Fase 2</h1>";

$backendPath = __DIR__ . '/../backend';

if (!file_exists($backendPath . '/vendor/autoload.php')) {
    die("❌ No encuentro vendor/autoload.php. Revisa la estructura.");
}

require $backendPath . '/vendor/autoload.php';
$app = require $backendPath . '/bootstrap/app.php';

try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    // Check key config values directly from the app instance
    echo "<h2>Verificación de Configuración</h2>";
    echo "APP_ENV: " . env('APP_ENV') . "<br>";
    echo "APP_DEBUG: " . (env('APP_DEBUG') ? '<span style="color:green">TRUE</span>' : '<span style="color:red">FALSE (Esto oculta el error real)</span>') . "<br>";
    echo "APP_URL: " . env('APP_URL') . "<br>";
    echo "DB_HOST: " . env('DB_HOST') . "<br>";

    echo "<h2>Ejecutando Petición...</h2>";
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    echo "Status Code: <b>" . $response->getStatusCode() . "</b><br>";

    echo "<hr><h3>Contenido de la Respuesta (El Error Real):</h3>";
    echo "<div style='border:1px solid #ccc; padding:10px; background:#f9f9f9;'>";
    echo $response->getContent();
    echo "</div>";

} catch (\Throwable $e) {
    echo "<h1>💥 EXCEPCIÓN FATAL NO CAPTURADA 💥</h1>";
    echo "<b>Mensaje:</b> " . $e->getMessage() . "<br>";
    echo "<b>Archivo:</b> " . $e->getFile() . ":" . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Diagnóstico de Despliegue</h1>";

echo "<h2>1. Verificación de Rutas</h2>";
$backendPath = __DIR__ . '/../backend';
echo "Buscando carpeta backend en: " . realpath($backendPath) . "<br>";

if (is_dir($backendPath)) {
    echo "<span style='color:green'>✅ Carpeta 'backend' ENCONTRADA.</span><br>";

    $autoloadPath = $backendPath . '/vendor/autoload.php';
    if (file_exists($autoloadPath)) {
        echo "<span style='color:green'>✅ 'vendor/autoload.php' ENCONTRADO.</span><br>";
    } else {
        echo "<span style='color:red'>❌ NO se encuentra 'vendor/autoload.php'. ¿Subiste la carpeta vendor completa?</span><br>";
    }

    $envPath = $backendPath . '/.env';
    if (file_exists($envPath)) {
        echo "<span style='color:green'>✅ Archivo '.env' ENCONTRADO.</span><br>";
    } else {
        echo "<span style='color:red'>❌ NO se encuentra el archivo '.env' en la carpeta backend.</span><br>";
    }

} else {
    echo "<span style='color:red'>❌ NO se encuentra la carpeta 'backend' al nivel superior.</span><br>";
    echo "Tu carpeta actual es: " . __DIR__ . "<br>";
    echo "El contenido del nivel superior es:<br>";
    $parentDir = dirname(__DIR__);
    if (is_dir($parentDir)) {
        $files = scandir($parentDir);
        foreach ($files as $file) {
            echo "- $file<br>";
        }
    }
}

echo "<h2>2. Versión de PHP</h2>";
echo "Versión actual: " . phpversion() . "<br>";
if (version_compare(phpversion(), '8.1.0', '<')) {
    echo "<span style='color:red'>❌ ALERTA: Tu versión de PHP es muy antigua. Laravel necesita PHP 8.1 o superior. Cambia la versión en el panel de Hostinger.</span><br>";
} else {
    echo "<span style='color:green'>✅ Versión de PHP correcta.</span><br>";
}

echo "<h2>3. Permisos de Carpetas</h2>";
$storagePath = $backendPath . '/storage';
if (is_writable($storagePath)) {
    echo "<span style='color:green'>✅ Carpeta 'storage' tiene permisos de escritura.</span><br>";
} else {
    echo "<span style='color:red'>❌ Carpeta 'storage' NO tiene permisos de escritura. (Error 500 probable).</span><br>";
}

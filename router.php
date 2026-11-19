<?php
error_log("ROUTER CALLED: " . $_SERVER['REQUEST_URI']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('#^/components/#', $uri)) {
    http_response_code(403);
    echo "403 Forbidden: Direct access to components is blocked.";
    return true;
}

// Map requested URI to local file path
$file = __DIR__ . $uri;

if (is_dir($file)) {
    $target = rtrim($file, DIRECTORY_SEPARATOR . '/') . DIRECTORY_SEPARATOR . 'index.html';
} else if (preg_match('/\.html$/', $uri)) {
    $target = $file;
} else {
    $target = null;
}

if ($target && file_exists($target)) {
    header('Content-Type: text/html; charset=UTF-8');
    // Execute PHP inside the HTML file
    chdir(dirname($target));
    include $target;
    return true;
}

return false;

<?php
if (!function_exists('base_url')) {
    function base_url($path = '')
    {
        // Detect protocol
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

        // Host name
        $host = $_SERVER['HTTP_HOST'];

        // Get document root and current directory
        $docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
        $currentDir = str_replace('\\', '/', realpath(__DIR__ . '/../')); // One level up (project root)

        // Remove document root from current directory to get relative project path
        $relativePath = str_replace($docRoot, '', $currentDir);

        // Build the base URL
        $base = rtrim($protocol . $host . $relativePath, '/');

        return $base . '/' . ltrim($path, '/');
    }
}
function vendor_url($path = '')
{
    $vendorPath = str_replace('src/', 'vendor/', base_url($path));
    return $vendorPath;
}
function db_url($path = '')
{
    $vendorPath = str_replace('src/', 'database/', base_url($path));
    return $vendorPath;
}

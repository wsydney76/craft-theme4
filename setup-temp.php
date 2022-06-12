<?php
echo "Initializing a temp project Env file with a given project handle. \n\n";
echo "Conventions:\n";
echo "Database must exist with the name of the handle, server:localhost/3306 user: root, no password.\n";
echo "Web server must be setup with http://<handle>.local\n\n";

$handle = $argv[1] ?? readline('Project handle: ');

$inputFile = './config/Env.php.example';
$outputFile = './config/Env.php';

file_put_contents($outputFile, str_replace(
    [
        '$HANDLE$',
        '$UC_HANDLE$',
        '$SECURITY_KEY$'
    ],
    [
        $handle,
        ucfirst($handle),
        bin2hex(random_bytes(24))
    ],
    file_get_contents($inputFile)
));

echo "$outputFile written";


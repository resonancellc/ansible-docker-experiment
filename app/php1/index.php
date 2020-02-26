<?php

header('Content-Type: application/json');
echo json_encode([
    'service'   => 'php1',
    'uri'       => $_SERVER['REQUEST_URI'],
    'server'    => getenv('SERVICE_HOST'),
]);


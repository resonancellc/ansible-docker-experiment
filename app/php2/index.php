<?php

header('Content-Type: application/json');
echo json_encode([
    'service'   => 'php2',
    'uri'       => $_SERVER['REQUEST_URI'],
    'server'    => $_SERVER['SERVER_NAME'],
]);


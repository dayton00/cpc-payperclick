<?php
// header.php

// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// Extract the requested file name without extension
$fileName = pathinfo($requestUri, PATHINFO_FILENAME);

// Define allowed file names (whitelist)
$allowedFiles = ['edit'];

// Check if the requested file is allowed
if (in_array($fileName, $allowedFiles)) {
    // Include the requested file
    include($fileName . '.php');
} 
?>

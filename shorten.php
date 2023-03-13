<?php

session_start();

// Define the URL map as an empty array
if (!isset($_SESSION['urlMap'])) {
  $_SESSION['urlMap'] = array();
}

// If the request is to shorten a URL
if (isset($_POST['long-url'])) {
  // Get the long URL from the request
  $longUrl = $_POST['long-url'];

  // Generate a random short URL
  $shortUrl = substr(md5($longUrl . time()), 0, 6);

  // Add the short URL to the URL map
  $_SESSION['urlMap'][$shortUrl] = $longUrl;

  // Return the shortened URL as JSON
  echo json_encode(array('short-url' => $shortUrl));
  exit();
}

// If the request is to redirect to a URL
if (isset($_SERVER['REQUEST_URI'])) {
  // Get the short URL from the request URI
  $shortUrl = substr($_SERVER['REQUEST_URI'], 1);

  // If the short URL is in the URL map, redirect to the long URL
  if (isset($_SESSION['urlMap'][$shortUrl])) {
    $longUrl = $_SESSION['urlMap'][$shortUrl];
    unset($_SESSION['urlMap'][$shortUrl]);
    echo '<!DOCTYPE html>
          <html>
            <head>
              <title>Redirecting...</title>
              <meta http-equiv="refresh" content="3;url=' . $longUrl . '">
            </head>
            <body>
              <p>Redirecting to ' . $longUrl . ' in 3 seconds...</p>
            </body>
          </html>';
    exit();
  }
}

// If the request is not a valid

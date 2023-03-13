<?php

// Define the URL map as an empty array
$urlMap = array();

// If the request is to shorten a URL
if (isset($_POST['long-url'])) {
  // Get the long URL from the request
  $longUrl = $_POST['long-url'];

  // Generate a random short URL
  $shortUrl = substr(md5($longUrl), 0, 6);

  // Add the short URL to the URL map
  $urlMap[$shortUrl] = $longUrl;

  // Return the shortened URL as JSON
  echo json_encode(array('short-url' => $shortUrl));
  exit();
}

// If the request is to redirect to a URL
if (isset($_SERVER['REQUEST_URI'])) {
  // Get the short URL from the request URI
  $shortUrl = substr($_SERVER['REQUEST_URI'], 1);

  // If the short URL is in the URL map, redirect to the long URL
  if (isset($urlMap[$shortUrl])) {
    header('Location: ' . $urlMap[$shortUrl]);
    exit();
  }
}

// If the request is not a valid URL shortening or redirection request, return a 404 error
http_response_code(301);
echo 'Page not found.';
exit();

// Get the form element
const form = document.getElementById('shorten-form');

// Get the input element
const input = document.getElementById('url-input');

// Get the container for the shortened URL
const shortenedUrlContainer = document.getElementById('shortened-url-container');

// Get the button element for copying the shortened URL to the clipboard
const copyButton = document.getElementById('copy-button');

// Initialize the URL map
const urlMap = new Map();

// Listen for the form submission event
form.addEventListener('submit', (event) => {
  // Prevent the default form submission behavior
  event.preventDefault();

  // Get the long URL from the input element
  const longUrl = input.value;

  // Generate a random short URL
  const shortUrl = generateShortUrl();

  // Store the long URL and corresponding short URL in the URL map
  urlMap.set(shortUrl, longUrl);

  // Display the shortened URL to the user
  shortenedUrlContainer.innerHTML = `<p>Your shortened URL is: <a href="${shortUrl}">${shortUrl}</a></p>`;

  // Show the copy button
  copyButton.style.display = 'block';
});

// Listen for the click event on the copy button
copyButton.addEventListener('click', (event) => {
  // Prevent the default click behavior
  event.preventDefault();

  // Get the shortened URL element
  const shortenedUrlElement = document.querySelector('#shortened-url-container a');

  // Create a temporary input element for copying the shortened URL to the clipboard
  const tempInput = document.createElement('input');

  // Set the value of the temporary input element to the shortened URL
  tempInput.value = shortenedUrlElement.href;

  // Append the temporary input element to the document
  document.body.appendChild(tempInput);

  // Select the contents of the temporary input element
  tempInput.select();

  // Copy the contents of the temporary input element to the clipboard
  document.execCommand('copy');

  // Remove the temporary input element from the document
  document.body.removeChild(tempInput);

  // Change the text of the copy button to indicate that the URL has been copied
  copyButton.innerHTML = 'Copied!';
});

// Listen for the window load event
window.addEventListener('load', () => {
  // Check if the URL contains a valid short URL
  const shortUrl = window.location.pathname.slice(1);
  if (urlMap.has(shortUrl)) {
    // Get the corresponding long URL from the URL map
    const longUrl = urlMap.get(shortUrl);

    // Delay for 3 seconds before redirecting to the original long URL
    setTimeout(() => {
      window.location.href = longUrl;
    }, 3000);
  } else {
    // Display an error message if the short URL is invalid
    const errorContainer = document.createElement('div');
    errorContainer.innerHTML = '<p>Invalid short URL</p>';
    document.body.appendChild(errorContainer);
  }
});

// Function to generate a random short URL
function generateShortUrl() {
  const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  let shortUrl = '';
  for (let i = 0; i < 6; i++) {
    shortUrl += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  return `https://${window.location.hostname}/${shortUrl}`;
}

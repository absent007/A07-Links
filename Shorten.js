const shortenForm = document.getElementById('shorten-form');
const shortenedUrlsDiv = document.getElementById('shortened-urls');

// Submit form to shorten URL
shortenForm.addEventListener('submit', (event) => {
	event.preventDefault();

	const longUrl = shortenForm.elements['long-url'].value;
	shorten

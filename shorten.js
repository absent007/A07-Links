$(document).ready(function() {
  $('#shorten-form').submit(function(event) {
    event.preventDefault();
    var longUrl = $('#long-url').val();
    $.ajax({
      url: 'shorten.php',
      type: 'post',
      dataType: 'json',
      data: { 'long-url': longUrl },
      success: function(data) {
        $('#short-url-input').val(window.location.origin + '/' + data['short-url']);
        $('#short-url').show();
      },
      error: function() {
        alert('An error occurred while shortening the URL.');
      }
    });
  });
  $('#copy-button').click(function() {
    $('#short-url-input').select();
    document.execCommand('copy');
    alert('Short URL copied to clipboard.');
  });
});

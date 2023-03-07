// Load up the dynamic component of available rooms every 5 seconds
$(document).ready(function(){
    // Load up the dynamic content
  $("#periodic-refresh-5secs").load("../components/dynamic/available-rooms.php", function() {
    $("#loadingDiv").hide(); // Hide loading image after first load
  });
  setInterval(function(){
    $("#periodic-refresh-5secs").load("../components/dynamic/available-rooms.php");
  }, 5000); // Refresh the dynamic content every 5 seconds
});
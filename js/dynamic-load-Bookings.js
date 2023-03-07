// Load up the dynamic component of bookings every 5 seconds
$(document).ready(function(){
    // Load up the dynamic content
  $("#refresh-5secs-bookings").load("../../components/dynamic/scheduled-visits.php", function() {
    $("#loadingDiv").hide(); // Hide loading image after first load
  });
  setInterval(function(){
    $("#refresh-5secs-bookings").load("../../components/dynamic/scheduled-visits.php");
  }, 5000); // Refresh the dynamic content every 5 seconds
});
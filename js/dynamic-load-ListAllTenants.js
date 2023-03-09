// Load up the dynamic component of bookings every 5 seconds
$(document).ready(function(){
    // Load up the dynamic content
  $("#periodic-refresh10secs-ListAll-Tenants").load("../../components/dynamic/listAll-tenants.php", function() {
    $("#loadingDiv").hide(); // Hide loading image after first load
  });
  setInterval(function(){
    $("#periodic-refresh10secs-ListAll-Tenants").load("../../components/dynamic/listAll-tenants.php");
  }, 5000); // Refresh the dynamic content every 5 seconds
});
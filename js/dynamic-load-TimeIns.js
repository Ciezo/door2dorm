// Load up the dynamic component
$(document).ready(function(){
    $("#time-in-securityLog").load("../../components/dynamic/admin-securityLogs-TimeIn.php", function() {
    });
    var num_of_refreshes = 0; 
    setInterval(function(){
      $("#time-in-securityLog").load("../../components/dynamic/admin-securityLogs-TimeIn.php");
      num_of_refreshes++;
      console.log("Refreshed content");
      console.log("Number of requests through jQuery: " + num_of_refreshes);
    }, 1000); // Refresh every 1 second
});
  
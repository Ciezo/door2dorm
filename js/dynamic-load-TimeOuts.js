// Load up the dynamic component
$(document).ready(function(){
    $("#time-out-securityLog").load("../../components/dynamic/admin-securityLogs-TimeOut.php", function() {
    });
    var num_of_refreshes = 0; 
    setInterval(function(){
      $("#time-out-securityLog").load("../../components/dynamic/admin-securityLogs-TimeOut.php");
      num_of_refreshes++;
      console.log("Refreshed content");
      console.log("Number of requests through jQuery: " + num_of_refreshes);
    }, 60000); // Refresh every 1 minute
});
  
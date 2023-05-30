// Load up the dynamic component
$(document).ready(function(){
    $("#refresh1secs-SecurityLogs-overview").load("../../components/dynamic/admin-home-SecurityLogs-Overview.php", function() {
        $("#loadingDiv").hide(); // Hide loading image after first load
    });
    var num_of_refreshes = 0; 
    setInterval(function(){
      $("#refresh1secs-SecurityLogs-overview").load("../../components/dynamic/admin-home-SecurityLogs-Overview.php");
      num_of_refreshes++;
      console.log("Refreshed content");
      console.log("Number of requests through jQuery: " + num_of_refreshes);
    }, 1000); // Refresh every 1 second
});
  
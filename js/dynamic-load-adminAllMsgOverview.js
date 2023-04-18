// Load up the dynamic component
$(document).ready(function(){
    $("#periodic-refresh5secs-overviewMessages").load("../../components/dynamic/admin-home-AllMessagesOverview.php", function() {
        $("#loadingDiv").hide(); // Hide loading image after first load
    });
    var num_of_refreshes = 0; 
    setInterval(function(){
      $("#periodic-refresh5secs-overviewMessages").load("../../components/dynamic/admin-home-AllMessagesOverview.php");
      num_of_refreshes++;
      console.log("Refreshed content");
      console.log("Number of requests through jQuery: " + num_of_refreshes);
    }, 5000); // Refresh every 1 second
});
  
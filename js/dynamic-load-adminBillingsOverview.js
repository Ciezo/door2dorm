// Load up the dynamic component
$(document).ready(function(){
    $("#refresh-5secs-bookings").load("../../components/dynamic/admin-home-TenantBalancesOverview.php", function() {
        $("#loadingDiv").hide(); // Hide loading image after first load
    });
    var num_of_refreshes = 0; 
    setInterval(function(){
      $("#periodic-refresh5secs-overviewBalances").load("../../components/dynamic/admin-home-TenantBalancesOverview.php");
      num_of_refreshes++;
      console.log("Refreshed content");
      console.log("Number of requests through jQuery: " + num_of_refreshes);
    }, 5000); // Refresh every 1 second
});
  
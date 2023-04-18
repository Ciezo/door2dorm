// Load up the dynamic component
$(document).ready(function(){
    var num_of_refreshes = 0; 
    setInterval(function(){
      $("#periodic-refresh8secs-messagesByGeneral").load("../../components/dynamic/admin-messages_General.php");
      num_of_refreshes++;
      console.log("Refreshed content");
      console.log("Number of requests through jQuery: " + num_of_refreshes);
    }, 1000); // Refresh every 1 second
});
  
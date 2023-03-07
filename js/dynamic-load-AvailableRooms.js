// Load up the dynamic component of available rooms every 5 seconds
$(document).ready(function(){
    setInterval(function(){
        $("#loadingDiv").show(); // Display the loading GIF animation before content is fetched
        $("#periodic-refresh-5secs").load("../components/dynamic/available-rooms.php", function() {
            $("#loadingDiv").hide(); // Hide the loading animation after content is retrieved
        });
    }, 5000); // Refresh every 5 seconds
});
<?php
require("../../config.php");
                //  Select statement to fetch all available rooms
                $sql = "SELECT * FROM AVAILABLE_ROOMS where occupancy_status = 'Available'";
                $results = mysqli_query($conn, $sql);

                if ($results->num_rows > 0) {
                    // Begin retrieving all entries as rows in a while loop
                    while ($row = mysqli_fetch_array($results)) {
                        // Rooms content are displayed as cards
                        echo    '<div class="card w-80 bg-base-100 shadow-xl mx-4">';
                        echo        '<figure>';
                                        // Render the room photo here
                        echo            '<img class="card-img-top" width="500" src="data:image/png;base64,'.base64_encode($row["room_photo"]).'" alt="Room photo" />'; 
                        echo        '</figure>';
                        echo        '<div class="card-body items-center text-center">';
                        echo            '<h2 class="card-title text-2xl font-bold mb-2">'.$row["room_type"].'</h2>';
                        echo            '<div class="badge badge-secondary">'.$row["room_category"].'</div>';
                        echo            '<div class="badge badge-outline mb-">Maximum Occupants Allowed: '.$row["num_of_occupants"].'</div>';
                        echo            '<p>Rent starts at:</p>';
                        echo            '<div class="card-actions">';
                        echo                '<button class="btn btn-warning">PHP '.$row["pricing"].'</button>';
                        echo                '<a class="btn btn-outline-primary" href="../api/rooms/read.php?id='.$row['room_id'].'">More info</a>';
                        echo            '</div>';
                        echo        '</div>';
                        echo    '</div>';
                    }
                }

                else {
                    echo '<div class="alert alert-danger"><em>There are no records found for available rooms!</em></div>';
                }
echo '<script>';
echo    'console.log("Fetched dynamic content: Listing all available rooms")';
echo '</script>';
?>
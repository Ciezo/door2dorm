<?php
require("../../config.php");
                //  Select statement to fetch all available rooms
                $sql = "SELECT * FROM AVAILABLE_ROOMS where occupancy_status = 'Available'";
                $results = mysqli_query($conn, $sql);

                if ($results->num_rows > 0) {
                    // Begin retrieving all entries as rows in a while loop
                    while ($row = mysqli_fetch_array($results)) {
                        echo    '<div class="card">';
                        echo        '<div class="card-header text-center">'; 
                        echo            $row["room_category"];
                        echo        '</div>';
              
                        echo        '<div class="card-body">';
                        echo            '<h5 class="card-title">'.$row["room_type"].'</h5>';
                        echo            '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($row["room_photo"]).'" alt="Card image cap">'; 
                        echo            '<div class="card-body text-center">';
                        echo                '<h2 class="card-text">Rent starts at </h2>';
                        echo                '<div class="btn-area mx-1">';
                        echo                    '<button class="btn btn-warning">PHP '.$row["pricing"].'</button>';
                        echo                    '<span class="px-1"></span>';
                        echo                    '<a class="btn btn-outline-primary" href="../api/rooms/read.php?id='.$row['room_id'].'">More info</a>';
                        echo                '</div>';
                        echo        '</div>';

                        echo        '<div class="card-footer text-muted"> Maximum number of occupants allowed: ';
                        echo            '<b>'.$row["num_of_occupants"].'</b>';
                        echo        '</div>';
                        echo       '</div>';
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
<div class="d-flex flex-row flex-nowrap overflow-auto">
    <?php 
    require("../../config.php");
    // <!-- Create a query to retrieve all list of tenants -->

                        $sql = "SELECT * FROM TENANT";
                        $results = mysqli_query($conn, $sql);

                        function calculateTotalDays($startDate, $endDate) {
                            // Convert the start and end dates to UNIX timestamps
                            $startTimestamp = strtotime($startDate);
                            $endTimestamp = strtotime($endDate);
                          
                            // Calculate the difference in seconds
                            $totalSeconds = abs($endTimestamp - $startTimestamp);
                          
                            // Convert seconds to days
                            $totalDays = round($totalSeconds / (60 * 60 * 24));
                          
                            return $totalDays;
                        }


                        if ($results->num_rows > 0) {
                            while ($row = mysqli_fetch_array($results)) {
                                // Get lease duration
                                $lease_duration = calculateTotalDays($row["lease_start"], $row["lease_end"]);
                                echo '<div class="card card-block mx-2" style="min-width: 300px;">';
                                echo    '<div class="card-header" id="" align="center" ><b>'.$row["full_name"].'</b></div>';
                                echo    '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($row["tenant_photo"]).'" alt="Tenant Photo" width="250" height="300">';
                                echo        '<div class="card-body">';
                                echo            '<ul class="list-group list-group-flush">';
                                echo                '<li class="list-group-item" id=""><i class="fa-solid fa-person-booth"></i> <b>Assigned Room: '.$row["room_assign"].'</b></li>';
                                echo                '<li class="list-group-item" id=""><i class="fa-solid fa-mobile-screen-button"></i> Mobile: <b>'.$row["mobile_num"].'</b></li>';
                                echo                '<li class="list-group-item" id=""><i class="fa-regular fa-envelope"></i> Email: <b>'.$row["email"].'</b></li>';
                                echo                '<li class="list-group-item" id=""><i class="fa-solid fa-calendar-day"></i> Lease start: <b>'.$row["lease_start"].'</b></li>';
                                echo                '<li class="list-group-item" id=""><i class="fa-solid fa-calendar-check"></i> Lease end: <b>'.$row["lease_end"].'</b></li>';
                                echo                '<li class="list-group-item" id=""><i class="fa-solid fa-clock"></i> Lease duration: <b>'.$lease_duration.' days</b></li>';
                                echo            '</ul>';
                                echo        '</div>';
                                echo        '<div class="card-footer">';
                                echo            '<center>';
                                // echo                '<input type="button" name="tenant-modal-selector" data-toggle="modal" data-target="#previewRegisteredTenantInfo" class="btn btn-outline-dark" value="More info">';
                                echo                '<a class="btn btn-outline-dark" name="tenant-modal-selector" href="../../api/tenant/read.php?id='.$row['tenant_id'].'">More Info</a>';
                                echo            '</center>';
                                echo        '</div>';
                                echo '</div>';
                            }
                        }

                        else {
                            echo '<div class="alert alert-danger"><em>There are no records found for all tenants</em></div>';
                        }
echo '<script>';
echo    'console.log("Fetched dynamic content: Listing all tenants")';
echo '</script>';
    ?>
</div>
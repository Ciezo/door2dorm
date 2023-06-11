<table class="table table-striped">
                    <thead class="thead-dark">
                        <tr class="table-dark">
                            <th scope="col">Log ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Checked-out</th>
                            <th scope="col">Room</th>
                            <th scope="col">Status</th>
                            <th scope="col">Face Capture</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        require("../../config.php");
                        // Create a query to select all time-ins records from the database
                        $sql = "SELECT * FROM SECURITY_LOGS_TIME_OUT";
                        $results = mysqli_query($conn, $sql); 
                        if ($results->num_rows > 0) {
                            while($rows = mysqli_fetch_assoc($results)) {
                                echo "<tr>";
                                echo    "<td>".$rows["log_id"]."</td>";
                                echo    "<td>".$rows["tenant_name"]."</td>";
                                echo    "<td>".$rows["time_out"]."</td>";
                                echo    "<td>".$rows["tenant_room"]."</td>";
                                echo    "<td>".$rows["status"]."</td>";
                                echo    "<td>";
                                            // Image capture from webcam
                                echo        '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($rows["capture"]).'"'; 
                                echo        'alt="Face capture" width="25%" height="25%">';
                                echo    "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo '<small><i>No data found</i></small>';    
                        }
                    ?>
                    </tbody>
                </table>
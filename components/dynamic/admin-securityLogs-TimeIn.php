                    <?php 
                        require("../../config.php");
                        // Create a query to select all time-ins records from the database
                        $sql = "SELECT * FROM SECURITY_LOGS_TIME_IN";
                        $results = mysqli_query($conn, $sql); 
                        if ($results->num_rows > 0) {
                            echo '<table class="table table-striped">';
                            echo    '<thead class="thead-dark">';
                            echo    '<tr>';
                            echo        '<th scope="col">Log ID</th>';
                            echo        '<th scope="col">Name</th>';
                            echo        '<th scope="col">Checked-in</th>';
                            echo        '<th scope="col">Room</th>';
                            echo        '<th scope="col">Status</th>';
                            echo    '</tr>';
                            echo    '</thead>';
                            
                            echo    '<tbody>';
                            
                            while($rows = mysqli_fetch_assoc($results)) {
                                echo "<tr>";
                                echo    "<td>".$rows["log_id"]."</td>";
                                echo    "<td>".$rows["tenant_name"]."</td>";
                                echo    "<td>".$rows["time_in"]."</td>";
                                echo    "<td>".$rows["tenant_room"]."</td>";
                                echo    "<td>".$rows["status"]."</td>";
                                echo "</tr>";
                            }
                            
                            echo  '</tbody>';
                            echo '</table>';
                        } else {
                            echo    '<div class="alert alert-info mt-2" role="alert">';
                            echo        '<div class="alert alert-danger" role="alert">';
                            echo            '<h5><i class="fa-solid fa-circle-info"></i> No entries found!<h5>';
                            echo            '<p>';
                            echo                'This can mean that no persons have been going out of the dormitory premises.';
                            echo            '</p>';
                            echo        '</div>';
                            echo    '</div>'; 
                        }
                    ?>
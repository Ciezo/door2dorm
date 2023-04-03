<?php require("../../config.php"); ?>
<h2>Scheduled Visitors</h2>
<p>This section presents all bookings and visits</p>
                    <?php
                        // Create a query to retrive all data for bookings
                        $sql = "SELECT * FROM VISITOR"; 
                        $results = mysqli_query($conn, $sql); 

                        if ($results->num_rows > 0) {
                            echo    '<table class="table table-striped">';
                            echo        '<thead class="thead-dark">';
                            echo            '<tr class="table-dark">';
                            echo                '<th scope="col">Name</th>';
                            echo                '<th scope="col">Vising Purpose</th>';
                            echo                '<th scope="col">Date</th>';
                            echo                '<th scope="col"></th>';
                            echo            '</tr>';
                            echo    '</thead>';

                            while($row = mysqli_fetch_array($results)) {
                                echo    '<tbody>';
                                echo        '<tr>';
                                echo            '<td>'.$row["full_name"].'</td>';
                                echo            '<td>'.$row["visit_purpose"].'</td>';
                                echo            '<td>'.$row["date_visit"].'</td>';
                                echo            '<td><a class="btn btn-outline-success" href="../../api/visitor/read.php?id='.$row['visitor_id'].'">View ID</a></td>';
                                echo        '</tr>';
                                echo    '</tbody>';
                            }
                        }

                        else {
                            echo '<div class="alert alert-danger"><em>There are no bookings</em></div>';
                        }
echo '<script>';
echo    'console.log("Fetched dynamic content: Scheduled Visits)';
echo '</script>';
                    ?>
                </table>
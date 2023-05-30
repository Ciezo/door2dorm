<table class="table table-striped">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th scope="col">Name</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require("../../config.php");
                        $sql_getTimeIns = "SELECT * FROM SECURITY_LOGS_TIME_IN";
                        $sql_getTimeOuts = "SELECT * FROM SECURITY_LOGS_TIME_OUT";
                        $results_TimeIns = mysqli_query($conn, $sql_getTimeIns);
                        $results_TimeOuts = mysqli_query($conn, $sql_getTimeOuts);

                        // Time-ins
                        while ($rows = mysqli_fetch_assoc($results_TimeIns)) {
                            echo "<tr>";
                            echo "<td>".$rows["tenant_name"]."</td>";
                            echo "<td>".$rows["tenant_room"]."</td>";
                            echo "<td>".$rows["status"]."</td>";
                            echo "</tr>";
                        }

                        // Time-outs
                        while ($rows = mysqli_fetch_assoc($results_TimeOuts)) {
                            echo "<tr>";
                            echo "<td>".$rows["tenant_name"]."</td>";
                            echo "<td>".$rows["tenant_room"]."</td>";
                            echo "<td>".$rows["status"]."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
</table>
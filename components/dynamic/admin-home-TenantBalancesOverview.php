<?php 
    require("../../config.php");
?>
<!-- Rentals -->
<div class="card px-5 mx-2">
    <table class="table table-striped">
        <h4>Monthly billings for rentals</h4>
        <tbody>
            <?php
                $_sql_rental_payments = "SELECT * FROM PAYMENTS_RENTAL";
                $results_rental = mysqli_query($conn, $_sql_rental_payments);
                // Check if there are nay returned results
                if ($results_rental->num_rows > 0) {
                    echo '<thead class="thead-dark">';
                    echo    '<tr class="table-dark">';
                    echo        '<th scope="col">Name</th>';
                    echo        '<th scope="col">Charges</th>';
                    echo        '<th scope="col">Due Date</th>';
                    echo        '<th scope="col">Details</th>';
                    echo        '<th scope="col">Payment Status</th>';
                    echo    '</tr>';
                    echo '</thead>';
                    // Fetch as rows 
                    while ($rows = mysqli_fetch_assoc($results_rental)) {
                        echo    '<tr>';
                        echo        '<td>'.$rows["to_be_paid_by"].'</td>';      // Name
                        echo        '<td>'.$rows["charges"].'</td>';            // Charges
                        echo        '<td>'.$rows["due_date"].'</td>';           // Due Date
                        echo        '<td>Rental</td>';                          // Billing types
                        echo        '<td>'.$rows["payment_status"].'</td>';     // Payment status
                        echo    '</tr>';
                    }
                } else {
                    echo '<div class="alert alert-danger"><em>There are no listed billings yet!</em></div>';
                }
            ?>
        </tbody>
    </table>
</div>
<br><br>
<!-- Electricity -->
<div class="card px-5 mx-2">
    <table class="table table-striped">
        <h4>Monthly billings for electricity</h4>
        <tbody>
        <?php
                $_sql_electricity_payments = "SELECT * FROM PAYMENTS_ELECTRICITY";
                $results_electricity = mysqli_query($conn, $_sql_electricity_payments);
                // Check if any results contain records
                if ($results_electricity->num_rows > 0) {
                    echo '<thead class="thead-dark">';
                    echo    '<tr class="table-dark">';
                    echo        '<th scope="col">Name</th>';
                    echo        '<th scope="col">Charges</th>';
                    echo        '<th scope="col">Due Date</th>';
                    echo        '<th scope="col">Details</th>';
                    echo        '<th scope="col">Payment Status</th>';
                    echo    '</tr>';
                    echo '</thead>';
                    // Fetch as rows 
                    while ($rows = mysqli_fetch_assoc($results_electricity)) {
                        echo    '<tr>';
                        echo        '<td>'.$rows["to_be_paid_by"].'</td>';      // Name
                        echo        '<td>'.$rows["charges"].'</td>';            // Charges
                        echo        '<td>'.$rows["due_date"].'</td>';           // Due Date
                        echo        '<td>Rental</td>';                          // Billing types
                        echo        '<td>'.$rows["payment_status"].'</td>';     // Payment status
                        echo    '</tr>';
                    }
                } else {
                    echo '<div class="alert alert-danger"><em>There are no listed billings yet!</em></div>';
                }
            ?>
        </tbody>
    </table>
</div>
<br><br>
<!-- Water -->
<div class="card px-5 mx-2">
    <table class="table table-striped">
        <h4>Monthly billings for electricity</h4>
        <tbody>
            <?php
                $_sql_water_payments = "SELECT * FROM PAYMENTS_WATER";
                $results_water = mysqli_query($conn, $_sql_water_payments);
                // Check if any results returned
                if ($results_water->num_rows > 0) {
                    echo '<thead class="thead-dark">';
                    echo    '<tr class="table-dark">';
                    echo        '<th scope="col">Name</th>';
                    echo        '<th scope="col">Charges</th>';
                    echo        '<th scope="col">Due Date</th>';
                    echo        '<th scope="col">Details</th>';
                    echo        '<th scope="col">Payment Status</th>';
                    echo    '</tr>';
                    echo '</thead>';
                    // Fetch as rows 
                    while ($rows = mysqli_fetch_assoc($results_water)) {
                        echo    '<tr>';
                        echo        '<td>'.$rows["to_be_paid_by"].'</td>';      // Name
                        echo        '<td>'.$rows["charges"].'</td>';            // Charges
                        echo        '<td>'.$rows["due_date"].'</td>';           // Due Date
                        echo        '<td>Rental</td>';                          // Billing types
                        echo        '<td>'.$rows["payment_status"].'</td>';     // Payment status
                        echo    '</tr>';
                    }
                } else {
                    echo '<div class="alert alert-danger"><em>There are no listed billings yet!</em></div>';
                }
            ?>
        </tbody>
    </table>
</div>
<?php 
    echo '<script>';
    echo    'console.log("Refreshed billings")';
    echo '</script>';
?>
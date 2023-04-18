<?php 
    require("../../config.php");
    require("../../api/messages/receive.php");
?>
<!-- General messages -->
<div class="card px-5 mx-2 mb-2">
    <h5 class="mt-2">General</h5>
    <p>These are general messages submitted by tenants</p>
    <table class="table px-5 mx-2">
        <thead>
            <tr>
                <th>Tenants</th>
                <th>Messages</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $results = getMessages_byGeneral(); 
                if ($results->num_rows > 0) {
                    while($msg = mysqli_fetch_assoc($results)) {
                        echo  '<tr>';
                        echo    '<td><button class="btn btn-outline-primary w-100">'.$msg["sent_by"].'</button></td>';
                        echo    '<td><textarea readonly class="form-control" name="" id="" cols="auto" rows="1">'.$msg["msg_body"].'</textarea></td>';
                        echo  '</tr>';
                    }
                } else {

                }
            ?>
        </tbody>
    </table>
</div>


<!-- Repairs -->
<div class="card px-5 mx-2 mb-2">
    <h5 class="mt-2">Repairs</h5>
    <p>These are submitted request for repairs by the tenants</p>
    <table class="table px-5 mx-2">
        <thead>
            <tr>
                <th>Tenants</th>
                <th>Messages</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $results_repairs = getMessages_byRepairs(); 
                if ($results_repairs->num_rows > 0) {
                    while($msg = mysqli_fetch_assoc($results_repairs)) {
                        echo  '<tr>';
                        echo    '<td><button class="btn btn-outline-primary w-100">'.$msg["sent_by"].'</button></td>';
                        echo    '<td><textarea readonly class="form-control" name="" id="" cols="auto" rows="1">'.$msg["msg_body"].'</textarea></td>';
                        echo  '</tr>';
                    }
                } else {

                }
            ?>
        </tbody>
    </table>
</div>


<!-- Feedback -->
<div class="card px-5 mx-2 mb-2">
    <h5 class="mt-2">Feedbacks</h5>
    <p>These are the submitted feedbacks by tenants</p>
    <table class="table px-5 mx-2">
        <thead>
            <tr>
                <th>Tenants</th>
                <th>Messages</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $results_feedback = getMessages_byFeedback(); 
                if ($results_feedback->num_rows > 0) {
                    while($msg = mysqli_fetch_assoc($results_feedback)) {
                        echo  '<tr>';
                        echo    '<td><button class="btn btn-outline-primary w-100">'.$msg["sent_by"].'</button></td>';
                        echo    '<td><textarea readonly class="form-control" name="" id="" cols="auto" rows="1">'.$msg["msg_body"].'</textarea></td>';
                        echo  '</tr>';
                    }
                } else {

                }
            ?>
        </tbody>
    </table>
</div>


<!-- Report -->
<div class="card px-5 mx-2 mb-2">
    <h5 class="mt-2">Reports</h5>
    <p>These are submitted reports by the tenants</p>
    <table class="table px-5 mx-2">
        <thead>
            <tr>
                <th>Tenants</th>
                <th>Messages</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $result_reports = getMessages_byReports(); 
                if ($result_reports->num_rows > 0) {
                    while($msg = mysqli_fetch_assoc($result_reports)) {
                        echo  '<tr>';
                        echo    '<td><button class="btn btn-outline-primary w-100">'.$msg["sent_by"].'</button></td>';
                        echo    '<td><textarea readonly class="form-control" name="" id="" cols="auto" rows="1">'.$msg["msg_body"].'</textarea></td>';
                        echo  '</tr>';
                    }
                } else {

                }
            ?>
        </tbody>
    </table>
</div>
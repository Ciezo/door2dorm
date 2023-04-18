<table class="table overflow-auto">
                            <thead>
                                <tr>
                                    <th>Tenants</th>
                                    <th>Messages</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require("../../api/messages/receive.php");
                                    $results = getMessages_byRepairs(); 

                                    if ($results->num_rows > 0) {
                                        // Fetch as rows 
                                        while($rows = mysqli_fetch_assoc($results)) {
                                            echo '<tr>';
                                            echo    '<td><button class="btn btn-outline-primary w-100">'.$rows["sent_by"].'</button></td>';
                                            echo    '<td><textarea readonly class="form-control" name="" id="" cols="auto" rows="1">'.$rows["msg_body"].'</textarea></td>';
                                            echo '</tr>';
                                        }
                                    }

                                    else {
                                        echo '<td><div class="alert alert-danger"><em>No messages found!</em></div></td>';
                                        echo '<td></td>';
                                        // echo '<div class="alert alert-danger"><em>No messages found!</em></div>';
                                        echo '<script>';
                                        echo    'console.log("Repair messages loaded!")';
                                        echo '</script>';
                                    }
                                ?>
                            </tbody>
                    </table>
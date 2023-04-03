<h2>List of All Tenants</h2>
<p>This section displays all registered tenants and their personal information</p>

<div class="d-flex flex-row flex-nowrap overflow-auto">
    <?php 
    require("../../config.php");
    // <!-- Create a query to retrieve all list of tenants -->

                        $sql = "SELECT * FROM TENANT";
                        $results = mysqli_query($conn, $sql);

                        if ($results->num_rows > 0) {
                            while ($row = mysqli_fetch_array($results)) {
                                echo '<div class="card card-block mx-2" style="min-width: 300px;">';
                                echo    '<div class="card-header" id="" align="center" ><b>'.$row["full_name"].'</b></div>';
                                echo    '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($row["tenant_photo"]).'" alt="Tenant Photo">';
                                echo        '<div class="card-body">';
                                echo            '<ul class="list-group list-group-flush">';
                                echo                '<li class="list-group-item" id=""><b>Assigned Room: '.$row["room_assign"].'</b></li>';
                                echo                '<li class="list-group-item" id=""><b>'.$row["mobile_num"].'</b></li>';
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
                            echo '<div class="alert alert-danger"><em>There are records found for all tenants</em></div>';
                        }
echo '<script>';
echo    'console.log("Fetched dynamic content: Listing all tenants")';
echo '</script>';
    ?>
</div>
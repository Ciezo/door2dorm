<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G774WB6BWG"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-G774WB6BWG');
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Invalid API Request</h2>
                    <div class="alert alert-danger">Sorry, the administrator has made an invalid request. Please <a href="../admin/admin-home.php" class="alert-link">go back to home</a> and try again.</div>
                    <?php 
                        date_default_timezone_set('Asia/Manila');
                        $request_date = date("d/m/Y");
                    ?>
                    <span> Most recent request: <?php echo $request_date; ?>
                    </span>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
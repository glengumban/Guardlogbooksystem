<?php include 'header.php'; 
if(isset($_SESSION['logged_in'])){
    header("location: index.php");
    ob_end_flush();
}
?>

<body class="bg-dark">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 shadow p-4  mt-">
            <?php if (isset($_GET['msg'])) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><?= $_GET['msg']; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <form method="POST" action="process.php">
                <div class="row mb-3">
                    <label for="fname" class="col-sm-4 col-form-label text-white">First Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="fname" name="f_name" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="lname" class="col-sm-4 col-form-label text-white">Last Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="lname" name="l_name" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-4 col-form-label text-white">Email</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-4 col-form-label text-white">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password" name="password1" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="pass2" class="col-sm-4 col-form-label text-white">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="pass2" name="password2" required>
                    </div>
                </div>                
                <button type="submit" class="btn btn-outline-light m-4" name="register">Sign up</button>
                <center> <p style="color: white;"> Already have an account? 
                    <a href="login.php" class="text-blue">Login here</a> </p> 
            </form>
        </div>
    </div>
</div>
<!-- content end -->
</body>

</html>
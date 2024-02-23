<?php include 'header.php' ;
if(isset($_SESSION['logged_in'])){
    header("location: index.php");
    ob_end_flush();
}

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $check = $conn->prepare("SELECT * FROM users WHERE u_email = ?");
    $check->execute([$email]);

    foreach($check as $value){
        if($value['u_email'] == $email && password_verify($pass, $value['u_pass'])){
            
            $_SESSION['logged_in'] = true;
            $_SESSION['u_id'] = $value['u_id'];

            header("location: index.php");
        }else{
            $msg = "Email or Password incorrect!";
            header("Location: login.php?msg=$msg");
        }
    }
}
?>

<div class="container wrapper">
    <div class="row justify-content-center">
        <div class="col-6 shadow p-4  mt-4">
        <?php if (isset($_GET['msg'])) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><?= $_GET['msg']; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <form method="POST" action="login.php">
                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label text-white">Email📧</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="pass" class="col-sm-2 col-form-label text-white">Pass:🔐</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="pass" name="password">
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-light m-4" name="login">Sign in</button>

                <center> <p style="color: white;">Do not have an account? 
                    <a href="register.php" class="text-blue">Sign up here</a> </p> </center> 
            </form>
</div>
    </div>
</div>

</body>

</html>
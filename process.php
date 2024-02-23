<?php
include 'conn.php';

// insert/create
if (isset($_POST['addData'])) {
    $userId = $_POST['userID'];
    $fname =  $_POST['firstname'];
    $lname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $vehicle_info = $_POST['vehicle_info'];


    //     INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);
    $insertData = $conn->prepare("INSERT INTO personal_info(u_id, fname, lname, address, contact, vehicle_info) VALUES(?, ?, ?, ?, ?, ?)");
    $insertData->execute([$userId, $fname, $lname, $address, $contact, $vehicle_info]);

    $msg = "Data inserted!";
    header("location: index.php?msg=$msg");
}

// update
if(isset($_POST['updateData'])){
    $id = $_POST['user_id'];
    $fname =  $_POST['firstname'];
    $lname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $vehicle_info = $_POST['vehicle_info'];


    //UPDATE table_name SET column1 = value1, column2 = value2, ... WHERE condition;
    $update = $conn->prepare("UPDATE personal_info SET fname = ?, lname = ?, address = ?, contact = ?, vehicle_info = ? WHERE p_id = ?");
    $update->execute([
        $fname,
        $lname,
        $address,
        $contact,
        $vehicle_info,
        $id
    ]);

    $msg = "Data updated!";
    header("location: index.php?msg=$msg");
}
// delete
if(isset($_GET['delete'])){
    $id = $_GET['id'];
    // DELETE FROM table_name WHERE condition;
    $delete = $conn->prepare("DELETE FROM personal_info WHERE p_id = ?");
    $delete->execute([$id]);

    $msg = "Data Deleted!";
    header("location: index.php?msg=$msg");

}

// adding new user.................................................................................
if(isset($_POST['register'])){
    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];
    $email = $_POST['email'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];

    if($pass1 == $pass2){
        $hash = password_hash($pass1, PASSWORD_DEFAULT);
        //INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);
        $addUser = $conn->prepare("INSERT INTO users (u_fname, u_lname, u_email, u_pass) VALUES(?, ?, ?, ?)");
        $addUser->execute([
            $fname,
            $lname,
            $email,
            $hash
        ]);

        $msg = "User registration successful!";
        header("location: register.php?msg=$msg");
    }else{
        $msg = "Password do not match!";
        header("location: register.php?msg=$msg");
    }
}



// update user table
if(isset($_POST['updateData'])){
    $id = $_POST['u_id'];
    $u_fname =  $_POST['firstname'];
    $u_lname = $_POST['lastname'];
    $u_email = $_POST['email'];
    $u_pass = $_POST['pass'];


    //UPDATE table_name SET column1 = value1, column2 = value2, ... WHERE condition;
    $update = $conn->prepare("UPDATE users SET f_name = ?, l_name = ?, u_email = ?, u_pass = ? WHERE u_id = ?");
    $update->execute([
        $u_fname,
        $u_lname,
        $u_email,
        $u_pass,
        $id
    ]);

    $msg = "Data updated!";
    header("location: user.php?msg=$msg");
}
// delete
if(isset($_GET['delete'])){
    $id = $_GET['id'];
    // DELETE FROM table_name WHERE condition;
    $delete = $conn->prepare("DELETE FROM users WHERE u_id = ?");
    $delete->execute([$id]);

    $msg = "Data Deleted!";
    header("location: user.php?msg=$msg");

}

// logout.............................................................................
if(isset($_GET['logout'])){
    session_start();

    unset($_SESSION['logged_in']);
    unset($_SESSION['u_id']);

    header("location: login.php");
}
<?php include 'header.php'; 

if(!isset($_SESSION['logged_in'])){
    header("location: login.php");
    ob_end_flush();
}


?>
<style>
.dropbtn {
  background-color: #3498DB;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
</head>
<body style="background-color:white;">
<div class="dropdown">
  <button onclick="myFunction()" class="dropbtn">Settings</button>
  <div id="myDropdown" class="dropdown-content">
    <a href="user.php">User</a>
    <a href="index.php">personal_info</a>
    <a href="about.php">About</a>
  </div>
</div>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>



</body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-4 shadow mt-4 p-3">
                <!-- alert message -->
                <?php if (isset($_GET['msg'])) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msg']; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <?php
                if (isset($_GET['edit'])) { ?>

                    <?php
                    $id = $_GET['id'];
                    $dataUp = $conn->prepare("SELECT * FROM personal_info WHERE p_id = ?");
                    $dataUp->execute([$id]);

                    foreach ($dataUp as $up) { ?>
                        <form action="process.php" method="post">
                            <input type="hidden" name="user_id" value="<?= $up['p_id'] ?>">
                            <div class="mb-3 text-white">
                                <label for="fname">Firstname</label>
                                <input type="text" class="form-input" id="fname" name="firstname" value="<?= $up['fname'] ?>">
                            </div>
                            <div class="mb-3 text-white">
                                <label for="lname">Lastname</label>
                                <input type="text" class="form-input" id="lname" name="lastname" value="<?= $up['lname'] ?>">
                            </div>

                            <div class="mb-3 text-white">
                                <label for="address">Address</label>
                                <input type="text" class="form-input" id="address" name="address" value="<?= $up['address'] ?>">
                            </div>
                            <div class="mb-3 text-white">
                                <label for="contact">Contact</label>
                                <input type="number" class="form-input" id="contact" name="contact" value="<?= $up['contact'] ?>">
                            </div>
                            <div class="mb-3 text-white">
                                <label for="vehicle_info">Vehicle Info.</label>
                                <input type="text" class="form-input" id="vehicle_info" name="vehicle_info" value="<?= $up['vehicle_info'] ?>">
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-warning" type="submit" name="updateData">Update</button>
                            </div>

                        </form>
                    <?php } ?>

                <?php } else { 
                    // echo $_SESSION['u_id'];
                    ?>
                
                    <form action="process.php" method="post">
                        <input type="hidden" name="userID" value="<?= $_SESSION['u_id'] ?>">
                        <div class="mb-3 text-white">
                            <label for="fname">Firstname</label>
                            <input type="text" class="form-input mb-3" id="fname" name="firstname">
                        </div>
                        <div class="mb-3 text-white">
                            <label for="lname">Lastname</label>
                            <input type="text" class="form-input mb-3" id="lname" name="lastname">
                        </div>
                        <div class="mb-3 text-white">
                            <label for="address">Address</label>
                            <input type="text" class="form-input mb-3" id="address" name="address">
                        </div>
                        <div class="mb-3 text-white">
                            <label for="contact">Contact</label>
                            <input type="number" class="form-input mb-3" id="contact" name="contact">
                        </div>
                        <div class="mb-3 text-white">
                            <label for="vehicle_info">Vehicle Info.</label>
                            <input type="text" class="form-input mb-3" id="vehicle_info" name="vehicle_info">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-success" type="submit" name="addData">Add</button>
                        </div>
                    </form>

                    <style>
      body {
        background-image: url("../image/bg.png");  
        background-size: 1500;
    background-repeat: no-repeat;
    background-position: center/cover;
    background-attachment: fixed;    }
      form {
        width: 400px;
        margin: auto;
        margin-top: 250px;
      }
      input {
        padding: 4px 10px;
        border: 0;
        font-size: 16px;
      }
      .search {
        width: 75%;
      }
      .submit {
        width: 80px;
      }
    </style>
  <body>
    <form action="search.php" method="GET">
      <input type="text" name="text" class="search" placeholder="Search here!">
      <input type="submit" name="submit" class="submit" value="Search">
    </form>
                <?php } ?>
            </div>
        </div>
  </body>
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="table shadow mt-4 p-2">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>FirstName</th>
                            <th>Lastname</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Vehicle Info.</th>

                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $user = $_SESSION['u_id'];
                            $getData = $conn->prepare("SELECT * FROM personal_info WHERE u_id = ?");
                            $getData->execute([$user]);
                            $cnt = 1;
                            foreach ($getData as $data) { ?>
                                <tr>
                                    <td><?= $cnt++ ?></td>
                                    <td><?= $data['fname'] ?></td>
                                    <td><?= $data['lname'] ?></td>
                                    <td><?= $data['address'] ?></td>
                                    <td><?= $data['contact'] ?></td>
                                    <td><?= $data['vehicle_info'] ?></td>
                                    <td><a href="index.php?edit&id=<?= $data['p_id'] ?>" class="text-decoration-none">✏️</a> | <a href="process.php?delete&id=<?= $data['p_id'] ?>" class="text-decoration-none">❌</a></td>

                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
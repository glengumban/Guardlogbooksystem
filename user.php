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
                    $dataUp = $conn->prepare("SELECT * FROM users WHERE u_id = ?");
                    $dataUp->execute([$id]);

                    foreach ($dataUp as $up) { ?>
                        <form action="process2.php" method="post">
                            <input type="hidden" name="user_id" value="<?= $up['u_id'] ?>">
                            <div class="mb-3 text-white">
                                <label for="u_fname">Firstname</label>
                                <input type="text" class="form-input" id="u_fname" name="firstname" value="<?= $up['u_fname'] ?>">
                            </div>
                            <div class="mb-3 text-white">
                                <label for="u_lname">Lastname</label>
                                <input type="text" class="form-input" id="u_lname" name="lastname" value="<?= $up['u_lname'] ?>">
                            </div>

                            <div class="mb-3 text-white">
                                <label for="u_email">Email</label>
                                <input type="text" class="form-input" id="u_email" name="u_email" value="<?= $up['u_email'] ?>">
                            </div>
                            <div class="mb-3 text-white">
                                <label for="u_pass">Password</label>
                                <input type="number" class="form-input" id="u_pass" name="password" value="<?= $up['u_pass'] ?>">
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-warning" type="submit" name="updateData">Update</button>
                            </div>

                        </form>
                    <?php } ?>

                <?php } else { 
                    // echo $_SESSION['u_id'];
                    ?>
                
                    <form action="process2.php" method="post">
                        <input type="hidden" name="userID" value="<?= $_SESSION['u_id'] ?>">
                        <div class="mb-3 text-white">
                            <label for="u_fname">Firstname</label>
                            <input type="text" class="form-input mb-3" id="u_fname" name="firstname">
                        </div>
                        <div class="mb-3 text-white">
                            <label for="u_lname">Lastname</label>
                            <input type="text" class="form-input mb-3" id="u_lname" name="lastname">
                        </div>
                        <div class="mb-3 text-white">
                            <label for="u_email">Email</label>
                            <input type="text" class="form-input mb-3" id="u_email" name="email">
                        </div>
                        <div class="mb-3 text-white">
                            <label for="u_pass">Password</label>
                            <input type="number" class="form-input mb-3" id="u_pass" name="password">
                        </div>
                        
                        <div class="mb-3">
                            <button class="btn btn-success" type="submit" name="addData">Add</button>
                        </div>
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
                            <th>Email</th>
                            <th>Password</th>

                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $user = $_SESSION['u_id'];
                            $getData = $conn->prepare("SELECT * FROM users WHERE u_id = ?");
                            $getData->execute([$user]);
                            $cnt = 1;
                            foreach ($getData as $data) { ?>
                                <tr>
                                    <td><?= $cnt++ ?></td>
                                    <td><?= $data['u_fname'] ?></td>
                                    <td><?= $data['u_lname'] ?></td>
                                    <td><?= $data['u_email'] ?></td>
                                    <td><?= $data['u_pass'] ?></td>
                                    <td><a href="user.php?edit&id=<?= $data['u_id'] ?>" class="text-decoration-none">✏️</a> | <a href="user.php?delete&id=<?= $data['u_id'] ?>" class="text-decoration-none">❌</a></td>

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
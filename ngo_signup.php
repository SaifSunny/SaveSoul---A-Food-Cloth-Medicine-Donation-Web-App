<?php

include './database/config.php';
error_reporting(0);

session_start();

if (isset($_SESSION['ngoname'])) {
    header("Location: ngo_home.php");
}


if (isset($_POST['signup'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $p = $_POST['password'];
    $error = "";
    $cls="";

    if ($password == $cpassword) {
            if (strlen($p) > 5) {

                $query = "SELECT * FROM ngo WHERE username = '$username'";
                $query_run = mysqli_query($conn, $query);

                if (!$query_run->num_rows > 0) {
                    $query = "SELECT * FROM ngo WHERE username = '$username' AND email = '$email'";
                    $query_run = mysqli_query($conn, $query);

                    if(!$query_run->num_rows > 0){
                        $query2 = "INSERT INTO ngo(username,email,`password`)
                        VALUES ('$username', '$email', '$password')";
                        $query_run2 = mysqli_query($conn, $query2);

                        if ($query_run2) {
                            $_SESSION['ngoname'] = $_POST['username'];
                            echo "<script> 
                            alert('Regestration Successfull.');
                            window.location.href='ngo_profile.php';
                            </script>";
                            
                        } 
                        else {
                            $error = mysqli_error($conn);
                            $cls="danger";

                        }
                    }
                    else{
                        $error = "NGO Already Exists";
                        $cls="danger";
                    }

                } 
                else {
                    $error = "username Already Exists";
                    $cls="danger";

                }
            } 
            else {
                $error =  "Password has to be minimum of 6 charecters";
                $cls="danger";

            }
    } 
    else {
        $error = 'Passwords did not Matched.';
        $cls="danger";

    }
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Rubik:wght@400;500;600;700&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="css/signin.css">

  <title>Savesoul - Food and Cloth Donation App</title>

</head>

<body class="text-center">

  <main class="form-signin">
    <form action="" method="POST">
      <h1 class="h3 mb-5 fw-normal" style="fontt-weight:700">Sign Up</h1>
      <div class="alert alert-<?php echo $cls;?>">
        <?php 
          if (isset($_POST['signin'])){
            echo $error;
          }
        ?>
      </div>
      <div class="form-floating">
        <input type="text" class="form-control" name="username" id="floatingInput" placeholder="Username">
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input type="email" class="form-control" name="email" id="floatingInput" placeholder="Email Address">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="cpassword" id="floatingPassword"
          placeholder="Confirm Password">
        <label for="floatingPassword">Confirm Password</label>
      </div>
      <div class="d-flex justify-content-between" style="margin: 20px;">
        <div>
          <label>
            <input type="checkbox" value="remember-me"> &nbsp; I Agree to all the Terms and Conditions
          </label>
        </div>

      </div>
      <button class="w-100 btn btn-lg btn-orange" type="submit" name="signup">Sign Up</button>
      <p class="mt-5 mb-3 text-muted">Already a User? Sign In <a href="ngo_login.php">Now</a></p>
    </form>
  </main>



</body>

</html>
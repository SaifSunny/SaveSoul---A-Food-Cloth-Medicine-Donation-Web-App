<?php
include_once("./database/config.php");

session_start();

$username = $_SESSION['ngoname'];

if (!isset($_SESSION['ngoname'])) {
    header("Location: ngo_login.php");
}

$sql = "SELECT * FROM ngo WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
 
$ngo_id = $row['ngo_id'];
$image = $row['ngo_img'];
$ngo_name=$row['ngo_name'];
$registration_id=$row['registration_id'];
$about=$row['about'];
$established=$row['established'];
$email=$row['email'];
$contact=$row['contact'];
$address=$row['address'];
$city=$row['city'];
$zip=$row['zip'];
$reg_img=$row['reg_img'];

$sql22 = "SELECT * FROM messages WHERE ngo_id='$ngo_id' order by message_id desc";
$result22 = mysqli_query($conn, $sql22);
$row22=mysqli_fetch_assoc($result22);

$ngo_read = $row22['ngo_read'];

$cause_id=$_GET['id'];



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Savesoul - Food and Cloth Donation App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Rubik:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sidebars.css">

</head>

<body>

    <section class="d-flex">
    <div class="header d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"
                style="padding:5px 30px;">
                <img src="./img/logo.png" alt="">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="ngo_home.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-house" style="padding-right:14px;"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="ngo_causes.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-ribbon" style="padding-right:14px;"></i>
                        Donation Causes
                    </a>
                </li>
                <li>
                    <a href="ngo_blog.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-blog" style="padding-right:14px;"></i>
                        Blog Posts
                    </a>
                </li>
                <li>
                    <a href="ngo_pickup.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-list" style="padding-right:14px;"></i>
                        Pick-up Requests
                    </a>
                </li>
                <li>
                    <a href="ngo_donation.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-coins" style="padding-right:14px;"></i>
                        Donation History
                    </a>
                </li>
                <?php
                    if($ngo_read==0){
                        $sql = "SELECT * from messages where ngo_id = $ngo_id and `ngo_read` = '0'";
                        $result = mysqli_query($conn, $sql);
                        $row_cnt = $result->num_rows;
                ?>
                <li>
                    <a href="ngo_chat.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                        Messages <span class="badge bg-danger" style="margin-bottom:2px"><?php echo $row_cnt?></span>
                    </a>
                </li>
                <?php
                    }else{
                ?>
                <li>
                    <a href="ngo_chat.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                        Messages
                    </a>
                </li>
                <?php
                    }
                ?>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./img/ngos/<?php echo $image?>" alt="" width="60" height="40" class="me-2"
                        style="border-radius:10px">
                    <strong><?php echo $username?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1"
                    style="width:200px;padding:20px;">
                    <li><a class="dropdown-item" href="ngo_profile.php">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                </ul>
            </div> 
        </div>

        <div class="main">
            <div class="row">
                <div class="col-md-12">
                    <h2 style="font-weight:600">Donation History</h2>
                    <p><a href="ngo_home.php">Dashboard</a> / Donation History</p>
                </div>
            </div>

            <div class="row" style="margin-bottom:0px;">
                <div class="col-md-12">
                    <div style="text-align:center; height:500px;">
                        <div style="padding:20px 40px; text-align:center;font-size:18px;">
                            <table class="table" style="font-size: 14px;color:#222;vertical-align:middle">
                                <thead>
                                    <th>Image</th>
                                    <th>Donation By</th>
                                    <th>Donation Item</th>
                                    <th>Amount</th>
                                    <th>Donate Date</th>
                                    <th>Status</th>

                                </thead>

                                <tbody>
                                    <?php 
                                            $sql = "SELECT * FROM donation Where cause_id=$cause_id";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $category=$row['category'];
                                                    $amount=$row['amount'];
                                                    $address=$row['address'];
                                                    $date=$row['date'];
                                                    $status=$row['status'];
                                                    $cause_id=$row['cause_id'];
                                                    $cposter_id=$row['poster_id'];
                                                    $crole=$row['role'];

                                                    if($status == 1){
                                                        $type = "success";
                                                        $msg = "Successfull";
                                                    }                                               
                                                    else if($status == 0){
                                                        $type = "warning";
                                                        $msg = "Processing";
                                                    }
                                                    else{
                                                        $type = "danger";
                                                        $msg = "Canclled";
                                                    }

                                                    $item = "";
      
                                                    if($category=="Food"){
                                                        $item = "Kg.";
                                                    }
                                                    else if($category == "Cloths"){
                                                        $item = "Item";
                                                    }
                                                    else if($category == "Medicine"){
                                                        $item = "Pack";
                                                        
                                                    }else if($category == "Money"){
                                                        $item = "Tk.";
                                                    }

                                 
   

                                                    if($crole=="Donner"){
                                                        $sql3 = "SELECT * from donners where donner_id = $cposter_id";
                                                        $result3 = mysqli_query($conn, $sql3);
                                                        $row3 =mysqli_fetch_assoc($result3);
                                                        $pname=$row3['firstname']." ".$row3['lastname'];
                                                        $pimg=$row3['donner_img'];

                                                        $dir="donners";
                                                
                                                    }else{
                                                        $sql4 = "SELECT * from ngo where ngo_id = $cposter_id";
                                                        $result4 = mysqli_query($conn, $sql4);
                                                        $row4 =mysqli_fetch_assoc($result4);
                                                        $pname=$row4['ngo_name'];
                                                        $pimg=$row4['ngo_img'];

                                                        $dir="ngos";

                                                    }



                                        ?>
                                    <tr>
                                        <td><img src="./img/<?php echo $dir."/".$pimg?>" style="width:60px;"
                                                alt="profile">
                                            <span style="padding-left:20px;"></span></td>
                                        <td><?php echo $pname ?></td>
                                        <td><?php echo $category ?></td>
                                        <td><?php echo $amount." ".$item?></td>
                                        <td><?php echo $date ?></td>
                                        <td style="font-size:14px; font-weight:600;"><button
                                                style="border-radius: 40px; padding:5px 14px; font-size:10px; font-weight:600"
                                                class="btn btn-<?php echo $type?>"><?php echo $msg?></button></td>
                                    </tr>
                                    <?php 
                                                }
                                            }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
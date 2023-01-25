<?php
include_once("./database/config.php");

session_start();

$username = $_SESSION['donnername'];

if (!isset($_SESSION['donnername'])) {
    header("Location: donner_login.php");
}

$sql = "SELECT * FROM donners WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$donner_img=$row['donner_img'];

$_SESSION['donner_img'] = $donner_img;
$_SESSION['donner_id'] = $row['donner_id'];
$_SESSION['username'] = $row['username'];

$donner_id=$row['donner_id'];
$sql22 = "SELECT * FROM messages WHERE donner_id='$donner_id' order by message_id desc";
$result22 = mysqli_query($conn, $sql22);
$row22=mysqli_fetch_assoc($result22);

$donner_read = $row22['donner_read'];

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
                    <a href="donner_home.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-house" style="padding-right:14px;"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="donner_causes.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-ribbon" style="padding-right:14px;"></i>
                        Donation Causes
                    </a>
                </li>
                <li>
                    <a href="donner_blog.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-blog" style="padding-right:14px;"></i>
                        Blog Posts
                    </a>
                </li>
                <li>
                    <a href="donner_pickup.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-list" style="padding-right:14px;"></i>
                        Pick-up Requests
                    </a>
                </li>
                <li>
                    <a href="donner_donation.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-coins" style="padding-right:14px;"></i>
                        Donation History
                    </a>
                </li>
                <?php
                    if($donner_read==0){
                        $sql = "SELECT * from messages where donner_id = $donner_id and `donner_read` = '0'";
                        $result = mysqli_query($conn, $sql);
                        $row_cnt = $result->num_rows;
                ?>
                <li>
                    <a href="donner_chat.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                        Messages <span class="badge bg-danger" style="margin-bottom:2px"><?php echo $row_cnt?></span>
                    </a>
                </li>
                <?php
                    }else{
                ?>
                <li>
                    <a href="donner_chat.php" class="nav-link text-white" style="font-size:17px;">
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
                    <img src="./img/donners/<?php echo $donner_img?>" alt="" width="40" height="40"
                        class="rounded-circle me-2">
                    <strong><?php echo $username?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1"
                    style="width:200px;padding:10px;">
                    <li><a class="dropdown-item" href="donner_profile.php">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="donner_logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>

        <div class="main">
            <div class="row">
                <div class="col-md-12" style="padding-bottom:30px;">
                    <h2 style="font-weight:600">Dashboard</h2>
                    <p>User Dashboard</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:18px">Donation Posts
                        </h5>
                        <div class="card-body" style="text-align:center; font-size:15px;">
                            <?php
                                    $sql = "SELECT * from causes where poster_id = $donner_id and `role`='Donner'";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:20px">Donation Made</h5>
                        <div class="card-body" style="text-align:center; font-size:18px;">
                            <?php
                                    $sql = "SELECT * from donation where poster_id = $donner_id and `role`='Donner' ";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:20px">Blogs
                        </h5>
                        <div class="card-body" style="text-align:center; font-size:18px;">
                            <?php
                                    $sql = "SELECT * from blog where poster_id = $donner_id and `role`='Donner'";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:20px">Chats
                        </h5>
                        <div class="card-body" style="text-align:center; font-size:18px;">
                            <?php
                                    $sql = "SELECT * from chat_room where donner_id = $donner_id";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:40px;">
                <div class="col-md-12">
                    <div style="text-align:left;padding:30px 0px; height:500px;">
                        <h3 style="font-size:24px;margin-bottom:40px">My Causes
                        </h3>
                        <div class="col-lg-12">

                            <?php 

                                $sql = "SELECT * FROM causes where poster_id = $donner_id and `role`='Donner' ORDER BY cause_id";
                                $result = mysqli_query($conn, $sql);
                                if($result){
                                    while($row=mysqli_fetch_assoc($result)){
                                        $id=$row['cause_id'];
                                        $cause_title=$row['cause_title'];
                                        $category=$row['category'];
                                        $location=$row['location'];
                                        $goal=$row['goal'];
                                        $image=$row['cause_img'];
                                        $description=$row['description'];
                                        $poster_id=$row['poster_id'];
                                        $role=$row['role'];

                                        $total = 0;
                                        $count = 0;
                                        $item = "";
                                        
                                        if($role=='Donner'){
                                            $sql3 = "SELECT * from donners where donner_id = $poster_id";
                                            $result3 = mysqli_query($conn, $sql3);
                                            $row3 =mysqli_fetch_assoc($result3);
                                            $name=$row3['firstname']." ".$row3['lastname'];

                                        }
                                        
                                        if($role=='NGO'){
                                            $sql4 = "SELECT * from ngo where ngo_id = $poster_id";
                                            $result4 = mysqli_query($conn, $sql4);
                                            $row4 =mysqli_fetch_assoc($result4);
                                            $name=$row4['ngo_name'];
                                        }
                                        
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

                                        $sql1 = "SELECT SUM(amount) as total FROM donation WHERE `cause_id`= $id AND `status` = 1";
                                        $result1 = mysqli_query($conn, $sql1);
                                        $row1 =mysqli_fetch_assoc($result1);

                                        $total=$row1['total'];
                                        if(empty($total))
                                        {
                                            $total = 0;
                                        }

                                        $sql2 = "SELECT COUNT(amount) as count FROM donation WHERE `cause_id`= $id AND `status` = 1";
                                        $result2 = mysqli_query($conn, $sql2);
                                        $row2 =mysqli_fetch_assoc($result2);
                                        $count=$row2['count'];
                                        if(empty($count))
                                        {
                                            $count = 0;
                                        }
                                        


                                ?>
                            <div class="card" style="margin-bottom:30px">
                                <div class="d-flex">
                                    <div>
                                        <?php
                                        if( $role=="Donner" && $poster_id==$donner_id ){
                                        ?>
                                        <a href="donner_cause_details_edit.php?id=<?php echo $id?>"><img
                                                src="img/causes/<?php echo $image?>" class="card-img-top" alt="Cause"
                                                style="height:400px;width:300px;object-fit: cover;"></a>
                                        <?php
                                        }else{
                                        ?>
                                        <a href="donner_cause_details.php?id=<?php echo $id?>"><img
                                                src="img/causes/<?php echo $image?>" class="card-img-top" alt="Cause"
                                                style="height:400px;width:300px;object-fit: cover;"></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="card-body d-flex" style="margin: 25px">
                                        <div style="width:100%">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="badge text-bg-success"
                                                        style="padding: 6px 15px;margin-right:10px;"><?php echo $name?></span>
                                                    <span class="badge text-bg-success"
                                                        style="margin-right:10px; padding: 6px 15px;"><?php echo $location?></span>
                                                    <span class="badge text-bg-success"
                                                        style="padding: 6px 15px;"><?php echo $category?></span>
                                                </div>
                                                <div>
                                                    <?php
                                                    if( $role=="Donner" && $poster_id==$donner_id ){
                                                    ?>
                                                    <a href="donner_cause_delete.php?cause_id=<?php echo $id?>"
                                                        class="btn btn-danger" style="padding:10px 15px"><i
                                                            class="fa fa-trash"></i></a>
                                                    <?php
                                                    }else{}
                                                    ?>
                                                </div>
                                            </div>



                                            <h5 class="card-title"><?php echo $cause_title?></h5>
                                            <p class="card-text"><?php echo substr($description, 0, 100)?></p>

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: <?php echo ($total/$goal)*100?>%;"
                                                    aria-valuenow="<?php echo ($total/$goal)*100?>" aria-valuemin="0"
                                                    aria-valuemax="100"><?php echo ($total/$goal)*100?>%</div>
                                            </div>
                                            <div class="d-flex justify-content-between"
                                                style="font-size:16px; font-weight:600;margin-top:30px">
                                                <p style="font-size:16px">Recieved: <?php echo $total." ".$item?></p>
                                                <p>Target: <?php echo $goal." ".$item?></p>
                                            </div>
                                            <div>
                                                <?php
                                                    if($role=="Donner" && $poster_id==$donner_id){
                                                ?>
                                                <a href="donner_cause_donations.php?id=<?php echo $id?>"
                                                    class="btn btn-outline-success">View Donations</a>
                                                <a href="donner_cause_details_edit.php?id=<?php echo $id?>"
                                                    class="btn btn-success">Update Post</a>
                                                <?php
                                                    }else{
                                                ?>
                                                <a href="donner_cause_details.php?id=<?php echo $id?>"
                                                    class="btn btn-outline-success">Donate Now</a>
                                                <?php
                                                    }
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <?php 
                                }
                            }
                            ?>
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
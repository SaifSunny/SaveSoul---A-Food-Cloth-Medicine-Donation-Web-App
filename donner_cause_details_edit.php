<?php
include_once("./database/config.php");
date_default_timezone_set('Asia/Dhaka');


session_start();

$username = $_SESSION['donnername'];

if (!isset($_SESSION['donnername'])) {
    header("Location: donner_login.php");
}

$date = date('l jS \ F Y h:i A');

$sql1 = "SELECT * FROM donners WHERE username='$username'";
$result1 = mysqli_query($conn, $sql1);
$row1=mysqli_fetch_assoc($result1);

$donner_id=$row1['donner_id'];
$donner_img=$row1['donner_img'];
$firstname=$row1['firstname'];
$lastname=$row1['lastname'];
$address=$row1['address'];
$city=$row1['city'];
$zip=$row1['zip'];

$_SESSION['donner_img'] = $donner_img;
$_SESSION['donner_id'] = $row1['donner_id'];
$_SESSION['username'] = $row1['username'];

$cause_id =  $_GET['id'];

$sql = "SELECT * FROM causes WHERE `cause_id`= $cause_id ";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

    $id=$row['cause_id'];
    $poster_id=$row['poster_id'];
    $role=$row['role'];
    $cause_title=$row['cause_title'];
    $category=$row['category'];
    $location=$row['location'];
    $goal=$row['goal'];
    $cause_img=$row['cause_img'];
    $description=$row['description'];

      $total = 0;
      $count = 0;
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

                                  
    if($role=="Donner"){
        $sql3 = "SELECT * from donners where donner_id = $poster_id";
        $result3 = mysqli_query($conn, $sql3);
        $row3 =mysqli_fetch_assoc($result3);
        $pname=$row3['firstname']." ".$row3['lastname'];

    }else{
        $sql4 = "SELECT * from ngo where ngo_id = $poster_id";
        $result4 = mysqli_query($conn, $sql4);
        $row4 =mysqli_fetch_assoc($result4);
        $pname=$row4['ngo_name'];
    }
    


    if(isset($_POST['submit'])){

        $title = $_POST['title'];
        $goal = $_POST['goal'];
        $description = $_POST['description'];
    
        $error = "";
        $cls="";
    
        $query2 = "UPDATE causes set cause_title='$title', goal='$goal', `description`='$description' WHERE cause_id='$cause_id'";
        $query_run2 = mysqli_query($conn, $query2);
                
        if ($query_run2) {
            $cls="success";
            $error = "Successfully Updated.";
        } 
        else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
    
    
    }

    if (isset($_POST['submit_img'])) {

        $error = "";
        $cls="";
     
        $name = $_FILES['file']['name'];
        $target_dir = "img/cause_img/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
      
        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      
        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");
    
        // Check extension
        if( in_array($imageFileType,$extensions_arr) ){
    
            // Upload file
            if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){
    
                // Convert to base64 
                $image_base64 = base64_encode(file_get_contents('img/cause_img/'.$name));
                $image = 'data:img/'.$imageFileType.';base64,'.$image_base64;
    
                // Update Record
                $query2 = "INSERT INTO cause_img (cause_id, `image`) values('$cause_id', '$name')";
                $query_run2 = mysqli_query($conn, $query2);
    
                if ($query_run2) {
                    $cls="danger";
                    $error = "Successfully Added Image";
                } 
                else {
                    $cls="danger";
                    $error = "Cannot Update Profile Image";
                }
    
            }else{
                $cls="danger";
                $error = 'Unknown Error Occurred.';
            }
        }else{
            $cls="danger";
            $error = 'Invalid File Type';
        }   
    }

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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
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
                    <a href="donner_home.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-house" style="padding-right:14px;"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="donner_causes.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
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
                    <h2 style="font-weight:600">Manage Causes</h2>
                    <p><a href="donner_home.php">Dashboard</a> / <a href="donner_causes.php">Manage Causes</a> / Cause
                        Details</p>
                </div>
            </div>
            <div class="row py-3">

                <div class="col-md-12">
                    <img src="img/causes/<?php echo $cause_img?>" class="card-img-top" alt="Cause" height="312"
                        style="object-fit: cover;">
                </div>
                <div class="col-lg-12">
                    <div class="card-body d-flex" style="margin: 20px">
                        <div style="width:100%">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="badge text-bg-success"
                                        style="margin-right:10px; padding: 6px 15px;"><?php echo $location?></span>
                                    <span class="badge text-bg-success"
                                        style="padding: 6px 15px;"><?php echo $category?></span>
                                </div>
                                <div>
                                    <a href="donner_cause_delete.php?cause_id=<?php echo $id?>" class="btn btn-danger"
                                        style="padding:10px 15px"><i class="fa fa-trash"></i></a>

                                </div>
                            </div>


                            <h4 class="card-title"><?php echo $cause_title?></h4>

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
                            <div class="d-flex justify-content-between"
                                style="font-size:16px; font-weight:600;margin-top:30px">
                                <p style="font-size:16px">Post By: <?php echo $pname?></p>
                            </div>
                            <form action="" method="POST">
                                <div class="d-flex justify-content-between row">
                                    <div class="col-md-12">
                                        <h4 style="padding-top:15px">
                                            <label for="" style="margin-bottom:15px">Cause Title</label>
                                            <input type="text" class="form-control" name="title"
                                                value="<?php echo $cause_title?>">
                                        </h4>

                                    </div>
                                    <div class="col-md-12">
                                        <h4 style="padding-top:15px">
                                            <label for="" style="margin-bottom:15px">Target</label>
                                            <input type="text" class="form-control" name="goal"
                                                value="<?php echo $goal?>"></h4>

                                    </div>
                                    <div class="col-md-12">
                                        <h4 style="padding-top:15px">
                                            <label for="" style="margin-bottom:15px">Cause Description</label>
                                            <textarea name="" id="" rows="8" name="description"
                                                class="form-control"><?php echo $description?></textarea>

                                    </div>
                                    <div class="col-md-10" style="margin-top:15px;">

                                    </div>
                                    <div class="col-md-2" style="margin-top:20px">
                                        <button type="submit" name="submit" class="btn btn-success">Update</button>

                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div>
                                <div class="row" style="padding-top:10px">
                                    <div class="col-md-6">
                                        <h5 style="">Cause Images</h5>
                                    </div>
                                    <div class="col-md-6 ">
                                        <form action="" method="POST" enctype='multipart/form-data'>
                                            <input type="file" name="file" id="file" style="margin-top:10px;">
                                            <button class="btn btn-success" name="submit_img">Add Image</button>
                                        </form>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <?php 
                                        $sql = "SELECT * from cause_img where cause_id = '$cause_id'";
                                        $result = mysqli_query($conn, $sql);
                                        if($result){
                                            while($row=mysqli_fetch_assoc($result)){
                                            $cause_img=$row['image'];
                                    ?>
                                    <div class="col-lg-4 col-md-4 col-xs-4 thumb">
                                        <a href="img/cause_img/<?php echo $cause_img?>" class="fancybox" rel="ligthbox">
                                            <img src="img/cause_img/<?php echo $cause_img?>" class="zoom img-fluid "
                                                alt="">

                                        </a>
                                    </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div>
                                <hr>
                                <div class="row" style="padding-top:10px">
                                    <div class="col-md-10">
                                        <h5 style="padding-top:10px">Blog Posts</h5>
                                    </div>
                                    <div class="col-md-2 ">
                                        <a href="donner_post_add.php" class="btn btn-success">Add Post</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="container">
                                        <div class="row">
                                            <?php 

                            $sql = "SELECT * FROM blog where cause_id=$cause_id";
                            $result = mysqli_query($conn, $sql);
                            if($result){
                            while($row=mysqli_fetch_assoc($result)){
                                $id=$row['blog_id'];
                                $cause_id=$row['cause_id'];
                                $topic=$row['topic'];
                                $image=$row['post_img'];
                                $post_date=$row['post_date'];
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
                                
                                $dt = explode(" ", $post_date);

                            ?>
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <a href="donner_blog_details.php?blog_id=<?php echo $id?>"><img
                                                            src="img/posts/<?php echo $image?>" class="card-img-top"
                                                            alt="..." style=""></a>
                                                    <div class="card-body" style="padding:30px">
                                                        <p style="font-size:15px"><i
                                                                class="fa fa-user text-success"></i> <?php echo $name?>
                                                            &nbsp; &nbsp; &nbsp;<i class="fa fa-clock text-success"></i>
                                                            <?php echo $dt[0]." ".$dt[1]?></p>


                                                        <h5 class="card-title"><a
                                                                href="donner_blog_details.php?blog_id=<?php echo $id?>"
                                                                style="color:black"><?php echo $topic?></a></h5>
                                                        <p class="card-text"><?php echo substr($description, 0, 100)?>
                                                        </p>
                                                        <a href="donner_blog_details.php?blog_id=<?php echo $id?>"
                                                            class="btn btn-success">View Post</a>
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
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function () {
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });

            $(".zoom").hover(function () {

                $(this).addClass('transition');
            }, function () {

                $(this).removeClass('transition');
            });
        });
    </script>
</body>

</html>
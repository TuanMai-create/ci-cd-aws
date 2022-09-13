<?php
include 'config.php';
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $mssv = mysqli_real_escape_string($conn, $_POST['mssv']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'img/'.$image;

    $select = mysqli_query($conn, "SELECT * FROM `user_member` WHERE mssv = '$mssv' ") or die('query failed123');
    if(mysqli_num_rows($select) > 0){
        $message[]= 'thành viên đã tồn tại';
    }else{
        if($image_size > 2000000){
            $message[] = 'kich co anh vuot qua gioi han';
        }else{
            $insert = mysqli_query($conn, "INSERT INTO `user_member`(`mssv`, `name`, `class`, `image`) VALUES ('$mssv','$name','$class','$image') ") or die ('query failed456');

            if($insert){
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Them thanh cong';
                header('location:index.php');
            }else{
                $message[] = 'Them khong thanh cong';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Profile Card</title>
    <meta http-equiv="X-UA-Compatitable" content="IE=edge">
    <meta name="viewport" content="with=device-with, initial-scale=1.0" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="form-container">
        <form action ="" method="post" enctype="multipart/form-data">
            <h3>Thành viên mới</h3>
            <input type ="text" name ="name" placeholder ="nhập tên của bạn" class="box" >
            <input type ="text" name ="class" placeholder ="nhập lớp của bạn" class="box" >
            <input type ="text" name ="mssv" placeholder ="nhập mã số sinh viên" class="box" >
            <input type ="file" name="image" class = "box" accept="img/jpg, img/jpeg, img/png">
            <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo'<div class"message">'.$message.'</div>';
                    }
                }
            ?>
            <input type ="submit" name ="submit" value="Thêm mới" class="btn">
            <p>Bạn muốn quay lại <a href="index.php">Trang Chủ</a></p>



            
        </form>
    </div>
</body>


</html>
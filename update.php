<?php
$con = mysqli_connect('localhost', 'root', '', 'ajax3') or die("connection faild");

// $user=mysqli_query($con,"SELECT * FROM ajax");
// $arr=mysqli_fetch_assoc($user);
// echo $arr['id'];
// print_r($select);
$res = array();

//  echo "hello";

if (isset($_POST) && !empty($_POST)) {
    unset($_POST['password']);
    unset($_POST['cpassword']);
    $update_id = $_POST['id'];
    $select = "SELECT * FROM ajax WHERE `id`='$update_id'";
    $select_exe = mysqli_query($con, $select);
    $arr = mysqli_fetch_assoc($select_exe);
    $hobby=explode(',',$arr['hobby']);
    $name = $_POST['name'] ? $_POST['name'] : $arr['name'];
    $email = $_POST['email'] ? $_POST['email'] : $arr['email'];
    $gender = $_POST['gender'] ? $_POST['gender'] : $arr['gender'];
    $hobby = $_POST['hobby'] ? $_POST['hobby'] : $hobby;
    $selectd = $_POST['country'] ? $_POST['country'] : $arr['country'];
    // $profile=$_POST['image']?$_POST['image']:$arr['profile'];
    // $multiple=$_POST['multiple']?$_POST['multiple']:$arr['profile'];

    if (!empty($_FILES['image']['name'])) {

        unlink('img/' . $arr['profile']);

        if ($_FILES['image']['size'] > 2000000) {
            $res['profile_size_err'] = "Profile size must be less then 2MB.";
            $res['status'] = 403;
        } else {
            $ext = pathinfo($_FILES['image']['name'], 4);
            if (strtolower($ext)) {
                $explode = explode('.', $_FILES['image']['name']);
                $ext = end($explode);
                $image = time() . '.' . $ext;
                $tmp_name = $_FILES['image']['tmp_name'];
                $folder = "img/" . $image;
                $upload = move_uploaded_file($tmp_name, $folder);
            } else {
                $res['profile_ext_err'] = "Allowed extension is png.";
                $res['status'] = 403;
            }
        }
    } else {
        $image = $arr['profile'];
    }
    if ($_FILES['multiple']['name'][0]) {
        $multiple = $_FILES['multiple'];
        $memory_arr = [];

        $old_pic = !empty($arr['multiple']) ? explode(',',$arr['multiple']) : '';
        if (!empty($old_pic)) {
            foreach ($old_pic as $pic) {
                unlink('img/' . $pic);
            }
        }
        for ($i = 0; $i < count($multiple['name']); $i++) {
            $explode = explode('.', $multiple['name'][$i]);
            $extension = end($explode);
            $memory_arr[] = time() . rand(10000000, 111111111) . '.' . $extension;
            move_uploaded_file($multiple['tmp_name'][$i], 'img/' . $memory_arr[$i]);
        }
        $multiple = implode(',',$memory_arr);
    } else {
        $multiple = $arr['multiple'];
    }
    $hoby=implode(',',$hobby);
     $update=mysqli_query($con,"UPDATE ajax SET `name`='$name',`gender`='$gender',`hobby`='$hoby',`country`='$selectd',`profile`='$image',`multiple`='$multiple'WHERE `id`='$update_id'");

     if($update){
        $res['status'] = 200;
        $res['message'] = "Data updated successfully.";
      
     }else{
        $res['status'] = 400;
        $res['message'] = "Somthing went wrong.";
     }

     echo json_encode($res);
}

?>
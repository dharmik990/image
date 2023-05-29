<?php

$con = mysqli_connect('localhost', 'root', '', 'ajax3') or die("connection faild");
$select=mysqli_query($con,"SELECT * FROM ajax");

$res=[];

if(!empty($_GET['update_user'])){
  $update_id=base64_decode($_GET['update_id']);
  $select=mysqli_query($con,"SELECT * FROM ajax");

}



if(!empty($_GET['delete_user'])){
 $id=base64_decode($_GET['delete_user']);
 $user=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM ajax WHERE `id`='$id'"));
 if(!empty($user['multiple'])&&!empty($user['profile'])){
   
   if(!empty($user['profile'])){
    @unlink('img/'.$user['profile']);
   }
  $old=!empty($user['multiple']) ? explode(',',$user['multiple']):'';
  if(!empty($old)){
    foreach($old as $pic){
      if(file_exists('img/'.$pic)){
        unlink('img/'.$pic);
      }
    }
  }
  $delete_user=mysqli_query($con,"DELETE FROM ajax WHERE `id`='$id'");
  if($delete_user){
    $res['status']=200;
    $res['key']='delete_user';
    $res['key_message']="user delete successfully";
  }
 }

}









$table_row="";
$res=[];
while($data=mysqli_fetch_assoc($select)){
      $memory=explode(",",$data['multiple']);
      $table_row.='<tr><td>'.$data['id'].'</td>
                 <td> '.$data['name'].'</td>
                 <td>'.$data['email'].'</td>
                 <td>'.$data['password'].'</td>
                 <td>'.$data['gender'].'</td>
                 <td>'.$data['hobby'].'</td>
                 <td>'.$data['country'].'</td>
                 <td><div style="width: 50px;height: 50px;padding: 5px;"><img src="'.'img/'.$data['profile'].'" style="max-width: 100%;max-height: 100%;"></div></td><td>';
                 for ($i=0; $i <count($memory); $i++) { 
                    $table_row .= '<div style="width: 50px;height: 50px;padding: 5px;"><img src="'.'img/'.$memory[$i].'" style="max-width: 100%;max-height: 100%;"></div>';
                  }
                  $table_row .=          '</td><td>'.$data['create'].'</td>
                    <td>'.$data['update'].'</td>';
                    $table_row .= '<td><button class="btn btn-primary"  onclick="getdata('. $data['id'] .')"><i class="fa fa-edit"></i></button></td>';
                    $table_row .= '<td><button class="btn btn-danger" onclick="delete_user('. $data['id'] .')"><i class="fa fa-trash"></i></button></td>';

                 
                 
                 

        $table_row .='</tr>';

                    
}


echo $table_row;

?>
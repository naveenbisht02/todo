<?php

include 'config/conn.php';
include 'response.php';

$content=$_POST['content'];
$is_completed=$_POST['is_completed'];

if(!preg_match('/^[a-zA-Z0-9\s]*$/',$content)){
    echo json_encode(errorResponse($content));
}else if(preg_match('/^[a-zA-Z0-9\s]*$/',$content) && !($is_completed=="0" || $is_completed=="1")){
    echo json_encode(errorResponse($content));
}
else{
   $sql = "INSERT INTO `todolist` (`content`, `is_completed`)
        VALUES ('$content', '$is_completed')";
    mysqli_query($conn,$sql);
}
$query="SELECT * FROM `todolist` ORDER BY id DESC limit 1";
$query_result=mysqli_query($conn,$query);
$query_row=mysqli_fetch_assoc($query_result);
$new_id=$query_row['id'];

$result="SELECT * FROM todolist WHERE id=$new_id";
$final_result=mysqli_query($conn,$result);
$final_row=mysqli_fetch_assoc($final_result);
echo json_encode(successResponse($final_row)); 

 
?>
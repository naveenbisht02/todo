<?php

include 'config/conn.php';
include 'response.php';

$id=$_POST['id'];
if($_POST['content']){
$new_content=$_POST['content'];
}


$que = "SELECT is_completed FROM todolist WHERE id='$id'";
$res=mysqli_query($conn,$que);
$row=mysqli_fetch_assoc($res);


if($id && !$_POST['content']){
    if($row['is_completed']==1){
        $sql = "UPDATE `todolist` SET is_completed='0' WHERE id=$id";
        if ($conn->query($sql) === TRUE) { echo json_encode(successResponse("is_completed=0"));}
        }else{
            $sql = "UPDATE `todolist` SET is_completed='1' WHERE id=$id";
            if ($conn->query($sql) === TRUE) { echo json_encode(successResponse("is_completed=1"));}
        }
    }else {
        if(!preg_match('/^[a-zA-Z0-9\s]*$/',$new_content)){
            echo json_encode(errorResponse("Error"));
        }else{
            $sql = "UPDATE `todolist` SET content='$new_content' WHERE id='$id'";
            if ($conn->query($sql) === TRUE) { echo json_encode(successResponse($new_content));}
        }
    }


?>
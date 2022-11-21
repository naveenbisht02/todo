<?php
header("Content-Type: application/json");

include 'config/conn.php';
include 'response.php';

$filter = $_GET['filter'];
if($filter=="all"){
    $sql = "SELECT * FROM todolist";
}else if($filter=="completed"){
    $sql = "SELECT * FROM todolist WHERE is_completed='1'";
}else if($filter=="incompleted"){
    $sql = "SELECT * FROM todolist WHERE is_completed='0'";
}
 $res=mysqli_query($conn,$sql);
    
$todo = array();
while ($row=mysqli_fetch_assoc($res)) {
    array_push($todo,array(
        "id"=>$row['id'],
        "content"=>$row['content'],
        "is_completed"=>$row['is_completed'])
    );
}
echo json_encode(successResponse($todo));

?>
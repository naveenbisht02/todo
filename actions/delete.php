<?php

include 'config/conn.php';
include 'response.php';

$id=$_GET['id'];

$sql = "DELETE FROM todolist WHERE id='$id'";


if ($conn->query($sql) === TRUE) {
    echo json_encode(successResponse("Deleted"));
} else {
    header("HTTP/1.1 500");
    echo json_encode(errorResponse(mysqli_error($conn)));}
?>
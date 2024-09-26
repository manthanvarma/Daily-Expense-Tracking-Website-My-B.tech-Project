<?php
extract($_POST);
include "config.php";

if ((isset($_GET['category_id'])) && ($_GET['category_id'] !== "")) {
    $category_id = $_GET["category_id"];

    $sql="DELETE FROM category WHERE category_id = :category_id";
    $data = array(':category_id' => $category_id);
    $result = $conn->prepare($sql);
    $result->execute($data);

    echo "<script> location.replace('manage_category.php?mode=deleted')</script>";
}
?>
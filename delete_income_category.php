<?php
extract($_POST);
include "config.php";

if ((isset($_GET['i_category_id'])) && ($_GET['i_category_id'] !== "")) {
    $i_category_id = $_GET["i_category_id"];

    $sql="DELETE FROM incomecategory WHERE i_category_id = :i_category_id";
    $data = array(':i_category_id' => $i_category_id);
    $result = $conn->prepare($sql);
    $result->execute($data);

    echo "<script> location.replace('manage_income_category.php?mode=deleted')</script>";
}
?>
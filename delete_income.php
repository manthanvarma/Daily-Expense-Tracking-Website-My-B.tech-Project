<?php
extract($_POST);
include "config.php";

if ((isset($_GET['income_id'])) && ($_GET['income_id'] !== "")) {
    $income_id = $_GET["income_id"];

    $sql="DELETE FROM income WHERE income_id = :income_id";
    $data = array(':income_id' => $income_id);
    $result = $conn->prepare($sql);
    $result->execute($data);

    echo "<script> location.replace('manage_income.php?mode=deleted')</script>";
}
?>
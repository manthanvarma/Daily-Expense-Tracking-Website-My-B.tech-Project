<?php
extract($_POST);
include "config.php";

if ((isset($_GET['expense_id'])) && ($_GET['expense_id'] !== "")) {
    $expense_id = $_GET["expense_id"];

    $sql="DELETE FROM expense WHERE expense_id = :expense_id";
    $data = array(':expense_id' => $expense_id);
    $result = $conn->prepare($sql);
    $result->execute($data);

    echo "<script> location.replace('manage_expense.php?mode=deleted')</script>";
}
?>
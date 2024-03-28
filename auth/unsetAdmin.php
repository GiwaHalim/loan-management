<?php
// script to update the current user as an admin

session_start();

$user_id = $_SESSION["id"];
$sql = "UPDATE user SET user_type = 'CUSTOMER' WHERE user_id = ?";

if ($stmt = mysqli_prepare($link, $sql)) {
  // Bind variables to the prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "i", $param_id);

  // Set parameters
  $param_id = $user_id;

  // Attempt to execute the prepared statement
  if (mysqli_stmt_execute($stmt)) {
    // Redirect to the welcome page
    echo "User is now a customer.";
  } else {
    echo "Oops! Something went wrong. Please try again later.";
  }

  // Close statement
  mysqli_stmt_close($stmt);
}
?>
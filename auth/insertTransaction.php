<?php
// Establish connection to your database

// Assuming your connection details are stored in a separate file
include 'db_connection.php';

// Check if the request contains necessary parameters
if (isset($_POST['reference'], $_POST['totalAmount'])) {
  $reference = $_POST['reference'];
  $totalAmount = $_POST['totalAmount'];
  $loan_id = $_POST['loanID'];
  $date = date('Y-m-d H:i:s');
  $user_id = $_SESSION['id'];
  $status = $_POST['status'];

  // Insert data into the table
  $insert_query = "INSERT INTO settle_reconcile_loan (date, reconcile_amount, user_id, loan_id, status, payment_authorizer, payment_reference) 
                     VALUES ($date, $totalAmount, $user_id, $loan_id, $status, 'Paystack', $reference)";

  if ($conn->query($insert_query) === TRUE) {
    echo "Data inserted successfully";

  } else {
    echo "Error: " . $insert_query . "<br>" . $conn->error;
  }

  // Close connection
  $conn->close();
} else {
  echo "Required parameters are missing";
}
?>
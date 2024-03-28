<?php

require_once "getUser.php";

// SQL query to fetch pending loans
$sql = "SELECT * FROM loan_request WHERE loan_status = 'PENDING' ORDER BY loan_id DESC";

// Execute the query
$result = mysqli_query($link, $sql);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
  // Initialize an array to store pending loans
  $GLOBALS['pending_loans'] = array();

  // Fetch rows and store in $GLOBALS['pending_loans']
  while ($row = mysqli_fetch_assoc($result)) {
    $GLOBALS['pending_loans'][] = $row;
  }
} else {
  // If no pending loans found, initialize empty array
  $GLOBALS['pending_loans'] = array();
}

// get approved_loans
$sql = "SELECT * FROM loan_request WHERE loan_status = 'APPROVED' ORDER BY loan_id DESC";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  $GLOBALS['approved_loans'] = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $GLOBALS['approved_loans'][] = $row;
  }
} else {
  $GLOBALS['approved_loans'] = array();
}


// get rejected_loans
$sql = "SELECT * FROM loan_request WHERE loan_status = 'REJECTED' ORDER BY loan_id DESC";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  $GLOBALS['rejected_loans'] = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $GLOBALS['rejected_loans'][] = $row;
  }
} else {
  $GLOBALS['rejected_loans'] = array();
}
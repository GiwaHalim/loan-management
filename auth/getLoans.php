<?php

require_once "getUser.php";
require_once "../utils/utils.php";

// SQL query to fetch pending loans
$user_id = $_SESSION["id"];

$sql = "SELECT * FROM loan_request WHERE loan_status = 'PENDING' AND user_id = '$user_id' ORDER BY loan_id DESC";
if (is_user_admin()) {
  // If user is an admin, fetch all pending loans and get the firstname and lastname of the user
  $sql = "SELECT loan_request.*, user.firstname, user.lastname FROM loan_request JOIN user ON loan_request.user_id = user.user_id WHERE loan_status = 'PENDING' ORDER BY loan_id DESC";
}

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
$sql = "SELECT * FROM loan_request WHERE loan_status = 'APPROVED' AND user_id = '$user_id' ORDER BY loan_id DESC";
if (is_user_admin()) {
  // If user is an admin, fetch all approved loans and get the firstname and lastname of the user
  $sql = "SELECT loan_request.*, user.firstname, user.lastname FROM loan_request JOIN user ON loan_request.user_id = user.user_id WHERE loan_status = 'APPROVED' ORDER BY loan_id DESC";
}

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
$sql = "SELECT * FROM loan_request WHERE loan_status = 'REJECTED' AND user_id = '$user_id' ORDER BY loan_id DESC";
if (is_user_admin()) {
  // If user is an admin, fetch all rejected loans and get the firstname and lastname of the user
  $sql = "SELECT loan_request.*, user.firstname, user.lastname FROM loan_request JOIN user ON loan_request.user_id = user.user_id WHERE loan_status = 'REJECTED' ORDER BY loan_id DESC";
}

$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  $GLOBALS['rejected_loans'] = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $GLOBALS['rejected_loans'][] = $row;
  }
} else {
  $GLOBALS['rejected_loans'] = array();
}



// get settlements including the user_id firstname and lastname
$sql = "SELECT settle_reconcile_loan.*, user.firstname, user.lastname FROM settle_reconcile_loan JOIN user ON settle_reconcile_loan.user_id = user.user_id WHERE settle_reconcile_loan.user_id = '$user_id' ORDER BY reconcile_id DESC";
if (is_user_admin()) {
  // If user is an admin, fetch all settlements and get the firstname and lastname of the user
  $sql = "SELECT settle_reconcile_loan.*, user.firstname, user.lastname FROM settle_reconcile_loan JOIN user ON settle_reconcile_loan.user_id = user.user_id ORDER BY reconcile_id DESC";
}
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  $GLOBALS['settlements'] = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $GLOBALS['settlements'][] = $row;
  }
} else {
  $GLOBALS['settlements'] = array();
}
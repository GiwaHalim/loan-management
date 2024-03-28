<?php
require_once "../auth/getLoans.php";
require_once "../auth/getCustomersCount.php";

// Function to delete a loan from the database
function approveLoan($loan_id)
{
  // delete loan from the database
  $sql = "UPDATE loan_request SET loan_status = 'APPROVED' WHERE loan_id = $loan_id";
  if (mysqli_query($GLOBALS['link'], $sql)) {
    // show success message for 2 seconds
    echo '<div class="alert alert-success mt-1" role="alert">Loan approved successfully</div>';
    // clear the output buffer after 2 seconds with setTimeout
    echo '<script>setTimeout(function() {document.querySelector(".alert").remove();}, 1000);</script>';
    // get rid of the page state
    echo '<script>setTimeout(function() {window.history.replaceState( null, null, window.location.href ); location.reload();}, 1000);</script>';

    // add the approved loan to the approved loans
    // $GLOBALS['approved_loans'][] = $GLOBALS['pending_loans'][array_search($loan_id, array_column($GLOBALS['pending_loans'], 'loan_id'))];

  } else {
    echo '<div class="alert alert-danger" role="alert">Error deleting loan: ' . mysqli_error($GLOBALS['link']) . '</div>';
  }
}


function rejectLoan($loan_id)
{
  // delete loan from the database
  $sql = "UPDATE loan_request SET loan_status = 'REJECTED' WHERE loan_id = $loan_id";
  if (mysqli_query($GLOBALS['link'], $sql)) {
    // show success message for 2 seconds
    echo '<div class="alert alert-success mt-1" role="alert">Loan Rejected successfully</div>';
    // clear the output buffer after 2 seconds with setTimeout
    echo '<script>setTimeout(function() {document.querySelector(".alert").remove();}, 1000);</script>';
    // get rid of the page state
    echo '<script>setTimeout(function() {window.history.replaceState( null, null, window.location.href ); location.reload();}, 1000);</script>';

  } else {
    echo '<div class="alert alert-danger" role="alert">Error deleting loan: ' . mysqli_error($GLOBALS['link']) . '</div>';
  }
}

// Check if the form has been submitted (for approve action)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_loan_id'])) {
  // Call the delete function with the loan ID to delete
  approveLoan($_POST['approve_loan_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject_loan_id'])) {
  // Call the delete function with the loan ID to delete
  rejectLoan($_POST['reject_loan_id']);
}




// Function to generate delete form for each loan
function generateApproveForm($loan_id)
{
  echo '<form method="POST">';
  echo '<input type="hidden" name="approve_loan_id" value="' . $loan_id . '">';
  echo '<button type="submit" class="btn btn-success btn-sm">Approve</button>';
  echo '</form>';
}

function generateRejectForm($loan_id)
{
  echo '<form method="POST">';
  echo '<input type="hidden" name="reject_loan_id" value="' . $loan_id . '">';
  echo '<button type="submit" class="btn btn-danger btn-sm">Reject</button>';
  echo '</form>';
}

// Function to generate loan table
function generateLoanTable($loan_status)
{
  $loans = $GLOBALS[$loan_status];
  echo '<div class="container">';
  echo '<table class="table table-striped">';
  echo '<thead>';
  echo '<tr>';
  echo '<th scope="col">Loan ID</th>';
  echo '<th scope="col">Customer</th>';
  echo '<th scope="col">Loan Amount</th>';
  echo '<th scope="col">Repayment Plan</th>';
  echo '<th scope="col">Interest (%)</th>';
  echo '<th scope="col">Total to be repaid</th>';
  echo '<th scope="col">Loan Status</th>';
  echo '<th scope="col">Loan Date</th>';
  if ($loan_status == 'pending_loans') {
    echo '<th scope="col">Actions</th>';
  }
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  // Loop through each loan and display data in table rows
  foreach ($loans as $loan) {
    echo '<tr>';
    echo '<td>' . $loan['loan_id'] . '</td>';
    echo '<td>' . $loan['firstname'] . ' ' . $loan['lastname'] . '</td>';
    echo '<td>' . comma_separate_amount($loan['loan_amount']) . '</td>';
    echo '<td>' . $loan['repayment_plan'] . ' Months</td>';
    echo '<td>' . get_loan_interest_rate($loan['repayment_plan']) . '%</td>';
    echo '<td>' . comma_separate_amount(calculate_total_loan_repayment_amount($loan['loan_amount'], $loan['repayment_plan'])) . '</td>';
    echo '<td>' . generateLoanStatusBadge($loan['loan_status']) . '</td>';
    echo '<td>' . $loan['loan_date'] . '</td>';
    if ($loan_status == 'pending_loans') {
      echo '<td>';
      echo '<div class="d-flex gap-3">';
      generateApproveForm($loan['loan_id']);
      generateRejectForm($loan['loan_id']);
      echo '</div>';
      echo '</td>';
    }
    echo '</tr>';
  }

  echo '</tbody>';
  echo '</table>';
  echo '</div>';
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="container mb-5">
    <div class="mb-5">
      <h1>Dashboard</h1>
      <p class="text-muted">Track and manage customer information and activities.</p>
    </div>

    <div class="container row mb-5">
      <div class="card col me-3">
        <div class="card-body">
          <p class="card-title text-muted">Total Loan Paid</p>
          <h4 class="card-text display-6 font-weight-bold">
            <?php echo comma_separate_amount(getApprovedLoanAmount()) ?>
          </h4>
          <p class="card-text text-muted">This is the total of amount loan paid(approved) to customers.</p>
        </div>
      </div>
      <div class="card col me-3">
        <div class="card-body">
          <p class="card-title text-muted">Total Expected Profit</p>
          <h4 class="display-6 font-weight-bold">
            <?php echo comma_separate_amount(totalExpectedProfit()) ?>
          </h4>
          <p class="card-text text-muted">This is the total amount of money expected to be made from loan given out</p>
        </div>
      </div>
      <div class="card col">
        <div class="card-body">
          <p class="card-title text-muted">Total Number Of Customers</p>
          <h4 class="display-6 font-weight-bold">
            <?php echo isset($GLOBALS['customers_count']) ? $GLOBALS['customers_count'] : '' ?>
          </h4>
          <p class="card-text text-muted">All customers that has created an account with our company. </p>
        </div>
      </div>
    </div>




    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button"
          role="tab" aria-controls="home-tab-pane" aria-selected="true">Pending Loans Requests</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button"
          role="tab" aria-controls="profile-tab-pane" aria-selected="false">Approved Loans</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button"
          role="tab" aria-controls="contact-tab-pane" aria-selected="false">Rejected Loans</button>
      </li>
    </ul>


    <div class="tab-content mt-2" id="myTabContent">
      <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <?php
        if (isset($GLOBALS['pending_loans']) && !empty($GLOBALS['pending_loans'])) {
          generateLoanTable('pending_loans');
        } else {
          echo '<p class="text-center">No pending loans found.</p>';
        }
        ?>
      </div>
      <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
        <?php
        if (isset($GLOBALS['approved_loans']) && !empty($GLOBALS['approved_loans'])) {
          generateLoanTable('approved_loans');
        } else {
          echo '<p class="text-center">No Approved loans found.</p>';
        }
        ?>
      </div>
      <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
        <?php
        if (isset($GLOBALS['rejected_loans']) && !empty($GLOBALS['rejected_loans'])) {
          generateLoanTable('rejected_loans');
        } else {
          echo '<p class="text-center">No Rejected loans found.</p>';
        }
        ?>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>
<?php
function calculate_total_loan_repayment_amount($loan_amount, $repayment_plan)
{
  // interest rate is 10% for 6 months and 15% for 12 months
  $interest_rate = $repayment_plan == 6 ? 0.1 : 0.15;
  $interest = $loan_amount * $interest_rate;
  return $loan_amount + $interest;
}

function get_loan_interest_rate($repayment_plan)
{
  return $repayment_plan == 6 ? 10 : 15;
}

function getTotalLoanAmount()
{
  // pending loans + approved loans + rejected loans (amount)
  $totalLoanAmount = 0;

  if (isset($GLOBALS['pending_loans'])) {
    foreach ($GLOBALS['pending_loans'] as $loan) {
      if (isset($loan['loan_amount'])) {
        $totalLoanAmount += $loan['loan_amount'];
      }
    }
  }

  if (isset($GLOBALS['approved_loans'])) {
    foreach ($GLOBALS['approved_loans'] as $loan) {
      if (isset($loan['loan_amount'])) {
        $totalLoanAmount += $loan['loan_amount'];
      }
    }
  }

  if (isset($GLOBALS['rejected_loans'])) {
    foreach ($GLOBALS['rejected_loans'] as $loan) {
      if (isset($loan['loan_amount'])) {
        $totalLoanAmount += $loan['loan_amount'];
      }
    }
  }

  return $totalLoanAmount;
}

function getApprovedLoanAmount()
{
  // approved loans (amount)
  $approvedLoanAmount = 0;

  if (isset($GLOBALS['approved_loans'])) {
    foreach ($GLOBALS['approved_loans'] as $loan) {
      if (isset($loan['loan_amount'])) {
        $approvedLoanAmount += $loan['loan_amount'];
      }
    }
  }

  return $approvedLoanAmount;
}

// calculate the total interest on all approved loans
function totalExpectedProfit()
{
  // use calculate_total_loan_repayment_amount to calculate the total amount to be repaid for each loan
  // then subtract the loan_amount to get the interest
  $totalInterest = 0;
  if (isset($GLOBALS['approved_loans'])) {
    foreach ($GLOBALS['approved_loans'] as $loan) {
      if (isset($loan['loan_amount'])) {
        $totalInterest += calculate_total_loan_repayment_amount($loan['loan_amount'], $loan['repayment_plan']) - $loan['loan_amount'];
      }
    }
  }
  return $totalInterest;
}

function getRejectedLoanAmount()
{
  // rejected loans (amount)
  $rejectedLoanAmount = 0;

  if (isset($GLOBALS['rejected_loans'])) {
    foreach ($GLOBALS['rejected_loans'] as $loan) {
      if (isset($loan['loan_amount'])) {
        $rejectedLoanAmount += $loan['loan_amount'];
      }
    }
  }

  return $rejectedLoanAmount;
}


function is_user_admin()
{
  return isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === true;
}


function generateLoanStatusBadge($loan_status)
{
  $badge_class = "badge-primary";
  if ($loan_status == "APPROVED") {
    $badge_class = "badge-success";
  } else if ($loan_status == "REJECTED") {
    $badge_class = "badge-danger";
  } else if ($loan_status == "PENDING") {
    $badge_class = "badge-warning";
  }
  return "<span class='badge $badge_class'>$loan_status</span>";
}

function comma_separate_amount($amount)
{
  return "₦" . number_format($amount, 2);
}

// include genraral js functions too

?>


<script>
  function calculate_total_loan_repayment_amount(loan_amount, repayment_plan) {
    if (!loan_amount) {
      return 0;
    }
    loan_amount = parseFloat(loan_amount);
    // interest rate is 10% for 6 months and 15% for 12 months
    let interest_rate = repayment_plan == 6 ? 0.1 : 0.15;
    let interest = loan_amount * interest_rate;
    return loan_amount + interest;
  }

  function comma_separate_amount(amount) {
    return "₦" + parseFloat(amount).toLocaleString();
  }
</script>
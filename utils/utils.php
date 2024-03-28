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
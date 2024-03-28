<!DOCTYPE html>
<html lang="en">
<?php
require_once "../auth/getLoans.php";

?>

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
      <h1>settlements</h1>
      <p class="text-muted">Track and manage customer information and activities. Click transfer to send to your
        personal account</p>
    </div>

    <div class="container row mb-5">
      <div class="card col me-3">
        <div class="card-body">
          <p class="card-title text-muted">Loan repaid</p>
          <h4 class="card-text display-6 font-weight-bold">
            <?php echo comma_separate_amount(total_loan_repaid()) ?>
          </h4>
          <p class="card-text text-muted">This is the total amount of money repaid to company.</p>
        </div>
      </div>
      <div class="card col me-3">
        <div class="card-body">
          <p class="card-title text-muted">Unsettled balance</p>
          <h4 class="card-text display-6 font-weight-bold">
            <?php echo '--' ?>
          </h4>
          <p class="card-text text-muted">This is the total amount of money collected by the customer</p>
        </div>
      </div>
    </div>


    <?php

    // Function to generate settlements table
    function generateSettlementsTable()
    {
      $settlements = $GLOBALS['settlements'];
      echo '<div class="container">';
      echo '<table class="table table-striped">';
      echo '<thead>';
      echo '<tr>';
      echo '<th scope="col">Settled ON</th>';
      echo '<th scope="col">Total Amount Settled</th>';
      echo '<th scope="col">Status</th>';
      echo '<th scope="col">Payment Gateway</th>';
      echo '<th scope="col">Payment Ref</th>';
      echo '<th scope="col">Loan ID</th>';
      // user name
      echo '<th scope="col">User Name</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      // Loop through each loan and display data in table rows
      foreach ($settlements as $settlement) {

        echo '<tr>';
        echo '<td>' . $settlement['date'] . '</td>';
        echo '<td>' . comma_separate_amount($settlement['reconcile_amount']) . '</td>';
        echo '<td><span class="badge bg-success">' . $settlement['status'] . '</span></td>';
        echo '<td>' . $settlement['payment_authorizer'] . '</td>';
        echo '<td>' . $settlement['payment_reference'] . '</td>';
        echo '<td>' . $settlement['loan_id'] . '</td>';
        //firstname + lastname
        echo '<td>' . $settlement['firstname'] . ' ' . $settlement['lastname'] . '</td>';
        echo '</tr>';

        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
    }
    ?>


    <?php
    if (isset($GLOBALS['settlements']) && !empty($GLOBALS['settlements'])) {
      generateSettlementsTable();
    } else {
      echo '<p class="text-center">No settlements found.</p>';
    }
    ?>

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
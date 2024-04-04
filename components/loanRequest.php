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

<?php

$amount_err = '';
$amount = 0;
$repayment_plan = 12;

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $repayment_plan = $_POST['repayment_plan'];
    $loan_date = date('Y-m-d');
    $user_id = $_SESSION['id'];

    if (empty($amount)) {
        $amount_err = 'Amount is required';

    } else {
        $amount_err = '';

        // Process the form data...

        // Prepare an insert statement
        $sql = "INSERT INTO loan_request (user_id, loan_amount, repayment_plan, loan_date) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "iiss", $user_id, $amount, $repayment_plan, $loan_date);

        // Attempt to execute the statement
        $success = mysqli_stmt_execute($stmt);


        // Redirect or display a success message
        // Check if the insertion was successful
        if ($success) {
            echo '<div class="alert alert-success mt-1" role="alert">Loan Request Added successfully</div>';
            // clear the output buffer after 5 seconds with setTimeout and redirect to dashboard
            echo '<script>setTimeout(function() {document.querySelector(".alert").remove(); window.location.href = "/pages/dashboard.php";}, 1000);</script>';
            // If insertion was successful, redirect to a dashboard page
        } else {
            // If insertion failed, display an error message
            echo '<div class="alert alert-danger"> Error: Unable to process your request. </div>';
        }
    }

}


?>


<body>
    <div class="container mb-5 ">
        <div class="mb-5 pt-3">
            <h1>Loan Request</h1>
            <p class="text-muted">Fill appropiate details and loan informataion</p>
        </div>

        <div class="container">
            <h3>Loan Details</h3>

            <hr class="mb-5">


            <form action="" method="POST">
                <div class="input-group mb-3">
                    <span class="input-group-text">₦</span>
                    <input type="text" name="amount" aria-label="Amount (to the nearest dollar)"
                        class="form-control <?php echo (!empty($amount_err)) ? 'is-invalid' : ''; ?>" type="number"
                        value="<?php echo $amount; ?>" required>

                    <span class="input-group-text">.00</span>
                </div>
                <div id="amount-borrowed" class="form-text mb-5 d-flex align-center gap-2">
                    <img src="../icons/info-circle.png" alt="" width="20px">
                    <div>Amount Limited Based on organizational policy</div>
                </div>

                <h5>Repayment Plan</h5>

                <div class="row">
                    <div class="form-check col col-sm-12 col-md-6 mb-5">
                        <input class="form-check-input mt-auto" type="radio" name="repayment_plan"
                            id="flexRadioDefault1" value="6">
                        <label class="form-check-label" for="flexRadioDefault1">
                            6 Months settlement plan
                        </label>
                        <div class="form-text text-muted">
                            Offers a low interest rate of 10%, making it suitable for those who prefer a shorter
                            repayment period with lower overall interest costs.
                        </div>
                    </div>

                    <div class="form-check col col-sm-12 col-md-6 mb-5">
                        <input class="form-check-input" type="radio" name="repayment_plan" id="flexRadioDefault2"
                            value="12" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            12 Months settlement plan
                        </label>
                        <div class="form-text">
                            Has a higher interest rate of 15%, but allows for more extended durations resulting in lower
                            monthly payments for borrowers who need flexibility.
                        </div>
                    </div>

                    <div class="col col-sm-12 col-md-8 mb-5">
                        <div class="row" style="font-size: small;">
                            <div class="col">
                                <p class="m-0 text-muted">Total interest payable:</p>
                                <p class=" m-0 display-6" id="total-repayment">

                                    <!-- <?php
                                    echo comma_separate_amount(calculate_total_loan_repayment_amount($amount, $repayment_plan));
                                    ?> -->
                                </p>
                            </div>
                        </div>

                        <div id="amount-borrowed" class="form-text mt-3 d-flex align-center gap-2">
                            <img src="../icons/info-circle.png" alt="" width="20px" height="20px">
                            <div>The interest rates and repayment amounts are calculated based on the loan amount
                                entered</div>
                        </div>
                    </div>
                    <div class="col col-sm-12 col-md-4 mb-5 d-flex justify-content-end">

                        <div class="ml-5">
                            <button class="btn rounded-5 border border-solid text-white bg-dark btn-sm">
                                <div class="py-2 px-3">
                                    <div>Submit Request</div>
                                </div>
                            </button>
                        </div>
                    </div>
            </form>

        </div>
    </div>


    <script>
        // Function to recalculate total repayment amount
        function recalculateTotalRepayment() {
            // Get the amount and repayment plan values
            var amount = document.querySelector('input[name="amount"]').value;
            var repaymentPlan = document.querySelector('input[name="repayment_plan"]:checked').value;

            // Calculate total repayment amount
            var totalRepayment = calculate_total_loan_repayment_amount(amount, repaymentPlan);

            // Update the total repayment amount display
            document.getElementById('total-repayment').textContent = comma_separate_amount(totalRepayment);
        }

        // Add event listener to amount input field
        document.querySelector('input[name="amount"]').addEventListener('input', recalculateTotalRepayment);
        // Add event listener to repayment plan radio buttons
        document.querySelectorAll('input[name="repayment_plan"]').forEach(function (radio) {
            radio.addEventListener('change', recalculateTotalRepayment);
        });
    </script>

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
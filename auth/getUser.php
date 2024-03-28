<!-- this gets the user obj of the currently signed in user -->

<?php
// Initialize the session
session_start();


// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: /auth/login.php");
  exit;
}


// Include config file
require_once "../database/config.php";

// Prepare a select statement
$sql = "SELECT * FROM user WHERE user_id = ?";

// get the user obj and store in a user variable

if ($stmt = mysqli_prepare($link, $sql)) {
  // Bind variables to the prepared statement as parameters
  $stmt->bind_param("i", $param_id);

  // Set parameters
  $param_id = $_SESSION["id"];

  // Attempt to execute the prepared statement
  if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
      /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
      $user = $result->fetch_array(MYSQLI_ASSOC);
      // store the user obj in a session
      $_SESSION["user"] = $user;
    } else {
      // sign out and take user back to login page
      session_destroy();
    }
  } else {
    echo "Oops! Something went wrong. Please try again later.";
  }


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
             VALUES ('$date', $totalAmount, $user_id, $loan_id, '$status', 'Paystack', '$reference')";

    if ($link->query($insert_query) === TRUE) {
      //  take users to /pages/loan-settlement.php page with js
      echo "<script>window.location.href = '/pages/loan-settlement.php';</script>";

    } else {
      echo "Error: " . $insert_query . "<br>" . $link->error;
    }

    // Close connection
    $link->close();
  } else {
    // echo "Required parameters are missing";
  }

  // Close statement
  $stmt->close();
}


// collect paystack 

?>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>

  // catch unique on form submission on generatePayButto

  function payWithPaystack(loanID, totalAmount, email) {
    totalAmount = parseInt(totalAmount)

    // pull email and password from hidden from fields
    const formData = {
      email: email,
      name: "Customer Name",
      amount: totalAmount
    };


    var handler = PaystackPop.setup({
      key: 'pk_test_3bdb6f21126495dd4a554561943b4ba145859586', // Replace with your public key
      email: formData.email,
      amount: totalAmount * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
      currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
      ref: String(Date.now()), // Replace with a reference you generated
      callback: function (response) {
        console.log("response", response)
        // this happens after the payment is completed successfully
        var reference = response.reference;
        // alert('Payment complete! Reference: ' + reference);

        // Execute PHP code to insert into the database
        var xhr = new XMLHttpRequest();
        // post in this php file
        xhr.open("POST", "/auth/getUser.php", true);

        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.responseText);
          }
        };
        xhr.send("reference=" + reference + "&totalAmount=" + totalAmount + "&loanID=" + loanID + "&status=" + response.status);
      },
      onClose: function () {
        alert('Transaction was not completed, window closed.');
      },

    });
    handler.openIframe();
  }

</script>
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

  // Close statement
  $stmt->close();
}

?>
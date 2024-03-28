<!-- include getUser.php once -->
<?php
// Include necessary files
require_once "../auth/getUser.php";
require_once "../utils/utils.php";

// Include the navigation component
include_once "../components/nav.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Loan Request</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      font: 14px sans-serif;
      text-align: center;
    }
  </style>
</head>

<body>


  <!-- <h1 class="my-5">Hi, <b>
      <?php echo htmlspecialchars($_SESSION["email"]); ?>
      <?php echo htmlspecialchars($_SESSION["id"]); ?>
    </b>. Welcome to our site.</h1>
  <p>
    <a href="/auth/logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
  </p> -->

  <div class="container">

    <?php include "../components/loanRequest.php"; ?>
  </div>
</body>

</html>
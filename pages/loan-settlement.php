<!-- include getUser.php once -->
<?php require_once "../auth/getUser.php";
require_once "../utils/utils.php";
// if user is an admin redirect to admin page
if (is_user_admin()) {
  header("location: /admin-pages/dashboard.php");
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Settlements</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      font: 14px sans-serif;
      text-align: center;
    }
  </style>
</head>

<body>
  <?php require_once "../components/nav.php"; ?>


  <!-- <h1 class="my-5">Hi, <b>
      <?php echo htmlspecialchars($_SESSION["email"]); ?>
      <?php echo htmlspecialchars($_SESSION["id"]); ?>
    </b>. Welcome to our site.</h1>
  <p>
    <a href="/auth/logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
  </p> -->

  <div class="container">

    <?php include "../components/settlement.php"; ?>
  </div>
</body>

</html>
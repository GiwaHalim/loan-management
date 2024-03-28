<?php
include_once "../database/config.php";
include_once "../utils/utils.php";

if (is_user_admin()) {
  // count all user in the database with user_type = 'CUSTOMER', then set the count in GLOBALS['customers_count']
  $sql = "SELECT COUNT(*) as count FROM user WHERE user_type = 'CUSTOMER'";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  $GLOBALS['customers_count'] = $row['count'];
} else {
}
?>
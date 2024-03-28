<?php
// Include config file
require_once "config.php";

function create_table($sql)
{
  global $link;
  if (mysqli_query($link, $sql)) {
    echo "Table created successfully<br>";
  } else {
    echo "Error creating table: " . $link->error;
  }
}

function delete_table($table_name)
{
  global $link;
  if (mysqli_query($link, "DROP TABLE IF EXISTS $table_name")) {
    echo "Table deleted successfully<br>";
  } else {
    echo "Error deleting table: " . $link->error;
  }
}

// this file is used to seed the database with some initial data and create tables

$create_user_table_sql = "CREATE TABLE IF NOT EXISTS user (
  firstname varchar(45) NOT NULL,
  lastname varchar(45) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(300) NOT NULL,
  user_id int NOT NULL AUTO_INCREMENT,
  user_type enum('ADMIN', 'CUSTOMER') NOT NULL DEFAULT 'CUSTOMER',
  PRIMARY KEY (user_id)
)";

$create_loan_request_table_sql = "CREATE TABLE IF NOT EXISTS loan_request  (
  loan_id int NOT NULL AUTO_INCREMENT,
  user_id int NOT NULL,
  loan_amount decimal(10,0) NOT NULL,
  repayment_plan enum('6', '12') NOT NULL,
  loan_status enum('PENDING', 'APPROVED', 'REJECTED') NOT NULL DEFAULT 'PENDING',
  loan_date date NOT NULL,
  PRIMARY KEY (loan_id),
  KEY user_id (user_id),
  CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES user (user_id)
)";


$create_settle_reconcile_loan_sql = "CREATE TABLE IF NOT EXISTS settle_reconcile_loan (
  reconcile_id int NOT NULL AUTO_INCREMENT,
  date date NOT NULL,
  reconcile_amount decimal(10,0) NOT NULL,
  user_id int NOT NULL,
  loan_id int NOT NULL,
  total_paid_settlement decimal(10,0),
  unsettled_balance decimal(10,0),
  status varchar(200),
  payment_authorizer varchar(45),
  payment_reference varchar(200),
  PRIMARY KEY (reconcile_id),
  KEY loan_id_idx (loan_id),
  CONSTRAINT loan_id FOREIGN KEY (loan_id) REFERENCES loan_request (loan_id)
)";




// start create tables
create_table($create_user_table_sql);
create_table($create_loan_request_table_sql);
create_table($create_settle_reconcile_loan_sql);
// delete_table("settle_reconcile_loan");
// delete_table("loan_request");
// delete_table("user");

?>
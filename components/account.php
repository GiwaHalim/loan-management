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
// set vairables 

$firstname = $GLOBALS['user']['firstname'];
$lastname = $GLOBALS['user']['lastname'];
$email = $GLOBALS['user']['email'];

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validate first name
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter a first name.";
    } else {
        $firstname = trim($_POST["firstname"]);
    }

    // validate last name
    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter a last name.";
    } else {
        $lastname = trim($_POST["lastname"]);
    }

    // Check input errors before inserting in database
    if (empty($firstname_err) && empty($lastname_err)) {

        // Prepare an update statement
        $sql = "UPDATE user SET firstname = ?, lastname = ? WHERE user_id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_firstname, $param_lastname, $param_id);

            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_id = $GLOBALS['user']['user_id'];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo '<div class="alert alert-success mt-1" role="alert">Account updated successfully</div>';
                echo '<script>setTimeout(function() {document.querySelector(".alert").remove();window.history.replaceState( null, null, window.location.href ); location.reload();}, 2000);</script>';
                // update GLOBALS user
                $GLOBALS['user']['firstname'] = $firstname;
                $GLOBALS['user']['lastname'] = $lastname;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    $submitting_form = false;
    // Close connection
    mysqli_close($link);
}

?>

<body>
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1>Account</h1>
                <p class="text-muted">Fill appropiate details to be used for identification</p>
            </div>

        </div>


        <div class="container">
            <h3 class="mb-5">Contact Details</h3>


            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="firstname"
                        class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $firstname; ?>">
                    <span class="invalid-feedback">
                        <?php echo $firstname_err; ?>
                    </span>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lastname"
                        class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $lastname; ?>">
                    <span class="invalid-feedback">
                        <?php echo $lastname_err; ?>
                    </span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" disabled class="form-control" value="<?php echo $email; ?>">
                    <span class="invalid-feedback">
                        <?php echo $email_err; ?>
                    </span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" disable class="form-control" value="**********">
                    <span class="invalid-feedback">
                        <?php echo $password_err; ?>
                    </span>
                </div>


                <div class="mt-5">
                    <button class="btn rounded-5 border border-solid text-white bg-dark btn-sm">
                        <div class="py-2 px-3">
                            <div>Update Info</div>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
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
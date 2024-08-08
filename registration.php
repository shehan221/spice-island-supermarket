<?php
require 'register_config.php';

//error message handling
$error_message = "";

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $lastname = $_POST["lastname"];
    $mobile = $_POST["mobile"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    
    $duplicate = mysqli_query($conn, "SELECT * FROM register WHERE username='$username' OR email='$email'");/*save user information under register table*/ 
    
	//error message for each 
    if (mysqli_num_rows($duplicate) > 0) {
        $error_message = "* Username or Email already taken *";
    } else {
        if ($password == $confirmpassword) {
            $query = "INSERT INTO register (username, lastname, mobile, email, password) VALUES ('$username', '$lastname', '$mobile', '$email', '$password')";
            mysqli_query($conn, $query);

            echo "<script> alert('Registration successful'); </script>";
        } else {
            $error_message = "* Password does not match *";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url("images/profile pic and logo/register.jpeg") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .background-blur {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(10px);
            z-index: -1;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            overflow: hidden;
            max-width: 900px;
            width: 90%;
            display: flex;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .form-header {
            color: #fff;
            padding: 20px;
            text-align: center;
            width: 100%;
        }

        .form-header h2 {
            margin: 0;
        }

        .form-content {
            padding: 30px;
            flex: 3;
            box-sizing: border-box;
            color: #fff;
        }

        .form-content label {
            display: block;
            margin-bottom: 5px;
        }

        .form-content input[type="text"],
        .form-content input[type="email"],
        .form-content input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-content input[type="text"][name="mobile"] {
            pattern: "\d+";
        }

        .form-content button[type="submit"] {
            background-color: #03D606;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .form-content button[type="submit"]:hover {
            background-color: #028c04;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #007bff;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .side-description {
            background-color: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 30px;
            flex: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .side-description h3 {
            margin-top: 0;
            color: #03D606;
        }

        .side-description ul {
            list-style-type: disc;
            padding-left: 20px;
            color: #000000;
            font-weight: bold;
        }

        .side-description ul li {
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
            }

            .form-content, .side-description {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <div class="background-blur"></div>
    <div class="form-container">
        <div class="form-content">
            <div class="form-header">
                <h2>REGISTRATION</h2>
            </div>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div> <!--display error message on the header of the form-->
            <?php endif; ?>
			
            <form action="" method="post" autocomplete="off">
                <label for="username">First Name:</label>
                <input type="text" name="username" id="username" value="<?php echo isset($username) ? $username : ''; ?>" required>

                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo isset($lastname) ? $lastname : ''; ?>" required>

                <label for="mobile">Mobile No:</label>
                <input type="text" name="mobile" id="mobile" value="<?php echo isset($mobile) ? $mobile : ''; ?>" required pattern="\d+">

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo isset($email) ? $email : ''; ?>" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <label for="confirmpassword">Confirm Password:</label>
                <input type="password" name="confirmpassword" id="confirmpassword" required>

                <button type="submit" name="submit">Register</button>
                <div class="links">
                    Already have an account? <a href="login.php">Login</a><!--link to switch between pages-->
                </div>
            </form>
        </div>
        <div class="side-description">
            <h3>Why Register?</h3>
            <ul>
                <li>Access exclusive deals and discounts</li>
                <li>Track your orders easily</li>
                <li>Receive personalized recommendations</li>
                <li>Faster checkout process</li>
                <li>Enjoy members-only promotions</li>
            </ul>
        </div>
    </div>
</body>
</html>
<?php
require 'login_conn.php';

//error handling 
$error_message = "";

if(isset($_POST["submit"])){
    $usernameemail = $_POST["usernameemail"];
    $password = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM register WHERE username='$usernameemail' OR email='$usernameemail'");/*get the both email and password*/
	
    $row = mysqli_fetch_assoc($result);
     
    if(mysqli_num_rows($result) > 0){
        if($password == $row["password"]){
            session_start();
            $_SESSION["login"] = true; //after login get the user id as a session 
            $_SESSION["id"] = $row["id"];
            
            // Redirect to the script for sending email
            header("location: mail.php");
            exit();
        } else {
            $error_message = "* Wrong Password *";
        }
    } else {
        $error_message = "* User Not Registered *";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .form-content input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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
            padding: 30px;
            flex: 2;
            color: #000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #fff;
        }

        .side-description h2 {
            margin: 0 0 20px 0;
        }

        .side-description ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        .side-description ul li {
            margin-bottom: 10px;
        }

        .side-description a {
            color: #03D606;
            text-decoration: none;
        }

        .side-description a:hover {
            text-decoration: underline;
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
                <h2>USER LOGIN</h2>
            </div>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div> <!-- display error on the header of the form -->
            <?php endif; ?>
            
            <form action="" method="post" autocomplete="off">
                <label for="usernameemail">Username or Email:</label>
                <input type="text" name="usernameemail" id="usernameemail" value="<?php echo isset($usernameemail) ? $usernameemail : ''; ?>" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" name="submit">Login</button>

                <div class="links">
                    Don't have an account? <a href="registration.php">Register here</a>
                </div>
            </form>
        </div>
        <div class="side-description">
            <ul>
                <li>Shopped with us before? Log in with your details.</li>
                <li>New member? <a href="registration.php">Click here to register</a></li>
                <li>Have trouble logging in? Call us on 0112303500</li>
                <li>(Daily operating hours 8.00 a.m to 8.00 p.m)</li>
            </ul>
        </div>
    </div>
</body>
</html>
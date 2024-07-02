<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Signup
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/common.css">
    <link rel="stylesheet" href="../styles/signup.css">
    <script src="script.js"></script>

</head>

<body>
    <?php
    include ('../includes/header.php');
    ?>

    <div class="signup">
        <div class="signupImg">
            <img src="..\resources\login.jpg" alt="Sign Up">
        </div>
        <div class="signupForm">
            <form id="signupForm" action="signup-process.php" method="post" onsubmit="return ValidateSignupForm()">
                <table>
                    <tr>
                        <td>
                            <h5>Create an account</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Enter your details below</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="name" name="name" placeholder="Name" autocomplete="name" required>
                            <div id="nameError" style="color: red;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="email" name="email" placeholder="Enter your email or phone number" autocomplete="email" required>
                            <div id="emailError" style="color: red;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" id="signupPassword" name="signupPassword" placeholder="Enter your password" autocomplete="new-password" required>
                            <div id="passwordError" style="color: red;"></div>
                            <span class="password-toggle" onclick="signupTogglePasswordVisibility()">Show Password</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit">Create Account</button>   
                        </td>
                    </tr>
                </table>
            </form>
            <div class="haveAccount">
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </div>
        </div>
    </div>
    <?php
    include ('../includes/footer.php');
    ?>
</body>
    

</html>
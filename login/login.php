<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Login
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/common.css">
    <link rel="stylesheet" href="../styles/login.css">
    <script src="script.js"></script>

</head>

<body>
    <?php
    session_start();
    include ('../includes/header.php');
    ?>

    <div class="container">
        <div class="login">
            <div class="loginImg">
                <img src="resources\login.jpg" alt="Login">
            </div>
            <div class="loginForm">
                <form action="login-process.php" method="post" onsubmit="return ValidateLoginForm()" id="loginForm">
                    <table>
                        <tr>
                            <td>
                                <h5>Log in to Nicee</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Enter your details below</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="email" name="email" placeholder="Enter your email" required>
                                <div id="emailError" style="color: red;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" id="password" name="password" placeholder="Enter your password"
                                    required>
                                <div id="passwordError" style="color: red;"></div>
                                <span class="password-toggle" onclick="togglePasswordVisibility()">Show Password</span>
                                <?php if (isset($_GET['error'])) {
                                    echo "<div class='error' style='color:red; font-weight: 600; font-size: 18px;'>" . $_GET['error'] . "</div>";
                                } ?>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <button type="submit">Log In</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <?php
        include ('../includes/footer.php');
        ?>
    </div>

    <script>
        function ValidateLoginForm() {
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;

            var emailError = document.getElementById("emailError");
            var passwordError = document.getElementById("passwordError");

            emailError.innerHTML = "";
            passwordError.innerHTML = "";

            if (!emailValidation(email)) {
                emailError.innerHTML = "Invalid email format";
                document.getElementById("email").focus();
                return false;
            }

            if (password.trim() === "") {
                passwordError.innerHTML = "Password is required";
                document.getElementById("password").focus();
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
<html>

<head>
    <title>
        Contact
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/contact.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/common.css">


</head>

<body>
    <?php
    session_start();
    include ('../includes/header.php');
    ?>

    <div class="path">
        <br>
        <a href="../index.php" class="navigation">Home</a> / <a href="contact.php" class="navigation2">Contact</a>
    </div>

    <div class="left-column">
        <div id="top">
            <table>
                <tr>
                    <td>
                        <img src="resources/redPhone.jpg" alt="Phone Icon"
                            style="width:50px;height:50px;margin-left:60px;">
                    </td>
                    <td style="font-weight:bold;">Call To Us</td>
                </tr>
            </table>
            <table style="padding-left:65px;">
                <tr>
                    <td>We are available 24/7, 7 days a week</td>
                </tr>
                <tr>
                    <td>Phone: +8801611112222</td>
                </tr>
                <tr>
                    <td>
                        <hr>
                    </td>
                </tr>
            </table>
        </div>
        <div id="bottom">
            <table>
                <tr>
                    <td>
                        <img src="resources/redEmail.png" alt="Email Icon"
                            style="width:32px;height:32px;margin-left:70px;">
                    </td>
                    <td style="font-weight:bold; padding-left:10px;">Write To Us</td>
                </tr>
            </table>
            <table style="padding-left:65px;">
                <tr>
                    <td>Fill out our form and we will contact you</td>
                </tr>
                <tr>
                    <td>within 24 hours.</td>
                </tr>

                <tr>
                    <td>Email: customer@exclusive.com</td>
                </tr>
                <tr>
                    <td>Emails: support@exclusive.com</td>
                </tr>
                <tr>
                    <td>
                        <hr>
                    </td>
                </tr>
            </table>
        </div>
        <br>

    </div>
    <div class="right-column">
        <form method="post">
            <table>
                <tr>
                    <td><input type="text" name="fullName" class="top-input" placeholder="Your Name" required="required"
                            value="<?php echo $_SESSION['firstName'] ?>"></td>
                    <td><input type="email" id="email" name="email" class="top-input" placeholder="Your Email"
                            required="required" value="<?php echo $_SESSION['email'] ?>">

                    </td>
                    <td><input type="text" name="phone" class="top-input" placeholder="Your Phone" required="required">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div id="errEmail"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><input type="text" name="message" class="bottom-input" placeholder="Your Message"
                            required="required">
                    </td>
                </tr>
            </table>
            <input type="submit" name="submit_message" id="submitButton" value="Send Message"
                onclick="return validateEmail(document.getElementById('email'));"></td>
            </tr>
        </form>

    </div>
    <p> </p>
    <script src="script.js">
    </script>
    <?php
    include ('../includes/footer.php');
    ?>

    <?php
    if (isset($_POST['submit_message'])) {
        function validateEmail($email)
        {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        function validatePhone($phone)
        {
            // Remove all characters except digits
            $phone = preg_replace("/[^0-9]/", "", $phone);

            // Check if the phone number length is 10 digits
            return (strlen($phone) === 10);
        }

        $errors = [];
        if (empty($_POST['fullName'])) {
            $errors[] = "Name is required";
        }
        if (empty($_POST['email'])) {
            $errors[] = "Email is required";
        } elseif (!validateEmail($_POST['email'])) {
            $errors[] = "Invalid email format";
        }
        if (empty($_POST['phone'])) {
            $errors[] = "Phone is required";
        } elseif (!validatePhone($_POST['phone'])) {
            $errors[] = "Invalid phone number";
        }
        if (empty($_POST['message'])) {
            $errors[] = "Message is required";
        }

        if (empty($errors)) {
            include ("../includes/config.php");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO Contacts (Name, Email, Phone, Message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullName, $email, $phone, $message);

            $fullName = $_POST['fullName'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $message = $_POST['message'];

            if ($stmt->execute()) {
                echo '<script>alert("New record created successfully");</script>';
            } else {
                echo '<script>alert("Error: ' . $stmt->error . '");</script>';
            }

            $stmt->close();
            $conn->close();
        } else {
            foreach ($errors as $error) {
                echo '<script>alert("' . $error . '");</script>';
            }
        }
    }
    ?>
</body>

</html>
<footer>
    <button onclick="topFunction()" id="scrollToTopBtn" title="Go to top"><img src="resources\top.png" width="15px"
            height="15px"></button>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer1">
                    <ul>
                        <li><img class="logo" src="resources\Nicee_shoes_logo.png" alt="shop logo" width=50 height=50>
                        </li>
                    </ul>
                </div>
                <div class="footer1">
                    <h4>Support</h4>
                    <ul>
                        <li>
                            <p>111 Bijoy sarani, Dhaka, DH 1515, Bangladesh.</p>
                        </li>
                        <li><a href="https://mail.google.com/mail/u/0/?view=cm&fs=1&tf=1&source=mailto&to=customerservice@nicee.com"
                                target="_blank" title="Send Email">customerservice@nicee.com</a></li>
                        <li><a href="tel:88015-88888-9999">+88015-88888-9999</a></li>
                    </ul>
                </div>
                <div class="footer1">
                    <h4>Account</h4>
                    <ul>
                        <li><a href="http://localhost/Nicee/myaccount/myaccount.php">My Account</a></li>
                        <li><a href="http://localhost/Nicee/login/login.php">Login</a></li>
                        <li><a href="http://localhost/Nicee/login/signup.php">Register</a></li>
                        <li><a href="http://localhost/Nicee/cart/cart.php">Cart</a></li>
                    </ul>
                </div>
                <div class="footer1">
                    <h4>Quick Link</h4>
                    <ul>
                        <li><a href="http://localhost/Nicee/privacy/">Privacy Policy</a></li>
                        <li><a href="http://localhost/Nicee/terms/">Terms Of Use</a></li>
                        <li><a href="http://localhost/Nicee/faq/">FAQ</a></li>
                        <li><a href="http://localhost/Nicee/contact/contact.php">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer2">
            <h4>Follow us</h4>
            <a href="https://facebook.com" target="_blank"><img src="resources\facebook_logo.png"></a>
            <a href="https://twitter.com" target="_blank"><img src="resources\x_logo.png" width="100px"
                    height="100px"></a>
            <a href="https://instagram.com" target="_blank"><img src="resources\instagram_logo.png"></a>
            <a href="https://linkedin.com" target="_blank"><img src="resources\linkedin_logo.png"></a>
        </div>
    </div>
</footer>

<script>
    let mybutton = document.getElementById("scrollToTopBtn");

    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    function topFunction() {
        if (document.documentElement.scrollTo) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        } else {
            document.body.scrollTop = 0;
        }
    }
</script>
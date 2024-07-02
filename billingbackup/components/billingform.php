<div>
    <h3 class="billingLabel">Billing Details</h3>

    <div class="billingForm">
        <form id="billingForm" action="" method="post" onsubmit="return ValidateBillingForm()">
            <table>
                <tr>
                    <td>
                        <label for="name">Full Name<span style="color: red">*</span></label>
                        <input type="text" id="name" placeholder="" required>
                        <div id="nameError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="companyname">Company Name</label>
                        <input type="text" id="companyname" placeholder="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="streetaddress">Street Address<span style="color: red">*</span></label>
                        <input type="text" id="streetaddress" placeholder="" required>
                        <div id="streetaddressError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="apartmentfloor">Apartment, floor, etc. (optional)</label>
                        <input type="text" id="apartmentfloor" placeholder="">
                        <div id="apartmentfloorError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="towncity">Town City<span style="color: red">*</span></label>
                        <input type="text" id="towncity" placeholder="" required>
                        <div id="towncityError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="phonenumber">Phone Number<span style="color: red">*</span></label>
                        <input type="text" id="phonenumber" placeholder="" required>
                        <div id="phonenumberError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email<span style="color: red">*</span></label>
                        <input type="text" id="email" placeholder="" required>
                        <div id="emailError" style="color: red;"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="saveCheckBox">
                            <input type="checkbox" id="savebillinginfo" name="saveinfocheckbox">
                            <label for="savebillinginfo">Save this information for faster check-out next time</label>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
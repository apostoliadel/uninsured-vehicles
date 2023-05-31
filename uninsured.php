<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>
<body>

<h2>Generate Message</h2>

<form name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <table>
	
		<tr>
			<!-- Client's Name -->
            <td>
                <label for="name">Client's Full Name:</label>
                <input type="text" name="name" id="name" maxlength="60" class="input-text"><br>
            </td>
            <!-- Contract Duration -->
            <td>
                <label for="duration">Contract Duration:</label>
                <select name="duration" id="duration">
                    <option value="1">1 month</option>
                    <option value="45">45 days</option>
                    <option value="3">3 months</option>
                    <option value="6">6 months</option>
                    <option value="12">1 year</option>
                </select><br>
            </td>
        </tr>
			
        <tr>
		    <!-- License Plate and Vehicle Type -->
            <td>
                <label for="licensePlate">License Plate:</label>
                <input type="text" name="licensePlate" id="licensePlate" pattern="[\p{L}]{3}[0-9]{4}" class="input-text"
                       title="The registration number is wrong. The correct format is ABC1234"
                       minlength="7" maxlength="7"
                       oninput="this.value = this.value.toUpperCase();"><br>
            </td>
            <td>
                <label for="vehicleType">Vehicle Type:</label>
                <input type="text" name="vehicleType" id="vehicleType" class="input-text"><br>
            </td>
        </tr>
        
        <tr>
		    <!-- Renewal Price -->
            <td colspan="2">
                <label for="renewalPrice">Renewal Price:</label>
                <input type="text" name="renewalPrice" id="renewalPrice" pattern="[0-9,]+" class="input-text"
                       title="Please only use the comma and numbers"><br>
                <?php if (isset($licensePlateError)) : ?>
                    <span class="warning"><?php echo $licensePlateError; ?></span><br> <!-- License Plate Error -->
                <?php endif; ?>
                <?php if (isset($renewalPriceError)) : ?>
                    <span class="warning"><?php echo $renewalPriceError; ?></span><br> <!-- Renewal Price Error -->
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <input type="submit" name="submit" value="Generate Message" class="button"> <!-- Generate Message Button -->
</form>

</body>
</html>


<?php
// Function to greet based on time
function timeGreet()
{
    $hour = date('h');
    if ($hour > 12) {
        $dayTerm = "Evening";
    } else {
        $dayTerm = "Morning";
    }

    return "Good " . $dayTerm;
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'] ?? "";
    $duration = $_POST['duration'] ?? "";
    $licensePlate = $_POST['licensePlate'] ?? "";
    $vehicleType = $_POST['vehicleType'] ?? "";
    $renewalPrice = $_POST['renewalPrice'] ?? "";

    if (mb_strlen($licensePlate) !== 7) {
        echo '<p style="color: red;">The registration number is wrong. The correct format is ABC1234</p>';
    } elseif (!preg_match('/^[0-9,]+$/', $renewalPrice)) {
        echo '<p style="color: red;">Please enter numbers and the comma only for the renewal price</p>';
    } else {
        // Output the generated message
        echo timeGreet() . " ";
        echo "we inform you that the vehicle with the " . $licensePlate . " ";
        echo "(Owner: " . $name . ", Type: " . $vehicleType . ")";
        echo " appears uninsured and in movement in the new Open Car service via gov.gr. ";
        echo "Because it is very likely that uninsured vehicles will be checked electronically by the ADA ";
        echo "and the fines range from €100 to €500, ";
        echo "please ensure that the vehicle is immediately insured or declared immobile. ";
        echo "For anything you need please contact us at: 2221000000 or 2221000000 ";
        echo "(The last contract of the vehicle was at €" . $renewalPrice;

        // Use switch statement for duration
        switch ($duration) {
            case "45":
                echo " for " . $duration . " days.";
                break;
            case "1":
                echo " for " . $duration . " month.";
                break;
            case "3":
            case "6":
                echo " for " . $duration . " months.";
                break;
            case "12":
                echo " for 1 year.";
                break;
        }
        echo ")";
    }
}
?>

</body>
</html>

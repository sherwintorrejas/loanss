<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>billings</title>
</head>
<body>
    <h1>billings</h1>
    <button onclick="goBack()">Back</button>

<script>
    // Function to go back
    function goBack() {
        // Retrieve the account type from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const accountType = urlParams.get('accountType');

        // Determine the back URL based on the account type
        let backUrl;
        if (accountType === 'basic') {
            backUrl = 'basic.php';
        } else if (accountType === 'premium') {
            backUrl = 'premium.php';
        } else {
            // Default to basic.php if no or invalid account type is provided
            backUrl = 'basic.php';
        }

        // Redirect to the appropriate back URL
        window.location.href = backUrl;
    }
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>account details</title>
</head>
<body>
    <h1>Account details</h1>
    <button onclick="goBack()">Back</button>

<script>
 
    function goBack() {
        const urlParams = new URLSearchParams(window.location.search);
        const accountType = urlParams.get('accountType');
        let backUrl;
        if (accountType === 'basic') {
            backUrl = 'basic.php';
        } else if (accountType === 'premium') {
            backUrl = 'premium.php';
        } else {

            backUrl = 'basic.php';
        }
        window.location.href = backUrl;
    }
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Recharge Report</title>
</head>

<body>
    <h2>Search Recharge Report</h2>
    <form action="<?php echo site_url('report/search'); ?>" method="post">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <br><br>
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="">Select Status</option>
            <option value="Pending">Pending</option>
            <option value="Success">Success</option>
            <option value="Failure">Failure</option>
        </select>
        <br><br>
        <button type="submit">Search</button>
    </form>
</body>

</html>
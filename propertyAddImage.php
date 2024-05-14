<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property Image</title>
    <link rel="stylesheet" href="propertyAddImage.css">
</head>
<body>
    <div class="container">
        <h1>Add Property Image</h1>
        <form action="addImage.php" method="POST">
            <label for="property_id">Property ID:</label>
            <select name="property_id" id="property_id">
                <?php
                // Fetch property IDs from the database and populate the dropdown
                include_once 'db_connect.php';
                $sql = "SELECT property_id FROM property";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['property_id'] . '">' . $row['property_id'] . '</option>';
                    }
                }
                ?>
            </select>
            <br>
            <label for="image_url">Image URL:</label>
            <input type="text" id="image_url" name="image_url">
            <br>
            <input type="submit" value="Add Image">
        </form>
    </div>
</body>
</html>

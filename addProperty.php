<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
    <link rel="stylesheet" href="addProperty.css">
</head>
<body>
    <h1>Add Property</h1>
    <form action="processProperty.php" method="POST" enctype="multipart/form-data">
        <label for="property_type">Property Type:</label>
        <select name="property_type" id="property_type">
            <?php
            // Include your database connection
            include_once 'db_connect.php';

            // Fetch property types from the database
            $sql_property_types = "SELECT * FROM Property_Type";
            $result_property_types = $conn->query($sql_property_types);

            if ($result_property_types->num_rows > 0) {
                while($row = $result_property_types->fetch_assoc()) {
                    echo '<option value="' . $row['property_type_id'] . '">' . $row['property_type_name'] . '</option>';
                }
            }
            ?>
        </select><br><br>

        <label for="city">City:</label>
        <select name="city" id="city">
            <?php
            // Fetch cities from the database
            $sql_cities = "SELECT * FROM City";
            $result_cities = $conn->query($sql_cities);

            if ($result_cities->num_rows > 0) {
                while($row = $result_cities->fetch_assoc()) {
                    echo '<option value="' . $row['city_id'] . '">' . $row['city_name'] . '</option>';
                }
            }
            ?>
        </select><br><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required><br><br>

        <label for="floor_space">Floor Space (m²):</label>
        <input type="number" name="floor_space" id="floor_space" required><br><br>

        <label for="rooms">Number of Rooms:</label>
        <input type="number" name="rooms" id="rooms" required><br><br>

        <label for="bedrooms">Number of Bedrooms:</label>
        <input type="number" name="bedrooms" id="bedrooms" required><br><br>

        <label for="bathrooms">Number of Bathrooms:</label>
        <input type="number" name="bathrooms" id="bathrooms" required><br><br>

        <label for="garages">Number of Garages:</label>
        <input type="number" name="garages" id="garages" required><br><br>

        <label for="status">Property Status:</label>
        <select name="status" id="status">
            <?php
            // Fetch property statuses from the database
            $sql_statuses = "SELECT * FROM Property_Status";
            $result_statuses = $conn->query($sql_statuses);

            if ($result_statuses->num_rows > 0) {
                while($row = $result_statuses->fetch_assoc()) {
                    echo '<option value="' . $row['property_status_id'] . '">' . $row['property_status_name'] . '</option>';
                }
            }
            ?>
        </select><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" cols="30" rows="5" required></textarea><br><br>

        <label for="images">Upload Images:</label>
        <input type="file" name="images[]" id="images" multiple accept="image/*"><br><br>

        <label for="agent">Agent:</label>
        <select name="agent" id="agent">
            <?php
            // Fetch agents from the database
            $sql_agents = "SELECT * FROM Agent";
            $result_agents = $conn->query($sql_agents);

            if ($result_agents->num_rows > 0) {
                while($row = $result_agents->fetch_assoc()) {
                    echo '<option value="' . $row['agent_id'] . '">' . $row['agent_name'] . '</option>';
                }
            }
            ?>
        </select><br><br>

        <input type="submit" value="Add Property">
    </form>
</body>
</html>

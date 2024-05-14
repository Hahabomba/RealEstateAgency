<?php
// Include database connection
include_once 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $property_id = $_POST['property_id'];
    $image_url = $_POST['image_url'];

    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO property_images (property_id, image_url) VALUES (?, ?)");
    $stmt->bind_param("is", $property_id, $image_url);

    // Execute the query
    if ($stmt->execute()) {
        // Image added successfully
        echo "Image added successfully.";
        echo '<br><br><a href="propertyAddImage.php"><button>Add More</button></a>';
    } else {
        // Error adding image
        echo "Error: Unable to add image.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

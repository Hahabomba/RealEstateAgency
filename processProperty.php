<?php
// Include your database connection
include_once 'db_connect.php';

// Get form data
$price = $_POST['price'];
$city = $_POST['city'];
$property_type = $_POST['property_type'];
$floor_space = $_POST['floor_space'];
$rooms = $_POST['rooms'];
$bedrooms = $_POST['bedrooms'];
$bathrooms = $_POST['bathrooms'];
$status = $_POST['status'];
$description = $_POST['description'];

// Prepare and bind parameters for the stored procedure
$sql_insert_property = "CALL Insert_Property(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert_property);
$stmt->bind_param("iiiiiiiiiiiss", $price, $city, $property_type, $floor_space, $rooms, $balconies, $bedrooms, $bathrooms, $garages, $parking_spaces, $description, $status, $agent_id);

// Set default values for additional parameters
$balconies = 0;
$garages = 0;
$parking_spaces = 0;
$agent_id = 1;

// Execute the stored procedure
if ($stmt->execute()) {
     $property_id = $conn->insert_id;

     // Upload images
      if (!empty($_FILES['images']['name'][0])) {
          $total_images = count($_FILES['images']['name']);
          for ($i = 0; $i < $total_images; $i++) {
              $image_name = $_FILES['images']['name'][$i];
              $tmp_name = $_FILES['images']['tmp_name'][$i];

              // Insert image URL into property_images table
              $sql_insert_image = "INSERT INTO property_images (property_id, image_url) VALUES (?, ?)";
              $stmt_insert_image = $conn->prepare($sql_insert_image);
              $stmt_insert_image->bind_param("is", $property_id, $image_name);

              // Execute the statement
              if ($stmt_insert_image->execute()) {
                  echo "Image inserted successfully.<br>";
              } else {
                  echo "Error inserting image: " . $stmt_insert_image->error . "<br>";
              }
          }
      }

      // Redirect back to addProperty.php with success message
      header("Location: addProperty.php?success=1");
} else {
  // Redirect back to addProperty.php with error message
    header("Location: addProperty.php?error=1");
}

$stmt->close();
$conn->close();
?>

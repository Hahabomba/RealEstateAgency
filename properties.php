<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties</title>
    <link rel="stylesheet" href="properties.css">
    <!-- Add Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
</head>
<body>
    <div class="container">
        <h1>Properties Available:</h1>
        <!-- Filter options -->
        <div class="filter-options">
            <form method="GET" action="properties.php">
                <?php if(isset($_GET['type'])): ?>
                <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
                <?php endif; ?>
                <label for="property_type">Property Type:</label>
                <select name="property_type" id="property_type">
                    <option value="">All</option>
                    <?php
                    include_once 'db_connect.php';
                    $sql = "SELECT * FROM property_type";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['property_type_id'] . '">' . $row['property_type_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <br>
                <label for="price_min">Price Min:</label>
                <input type="number" name="price_min" id="price_min" min=0>
                <label for="price_max">Price Max:</label>
                <input type="number" name="price_max" id="price_max" min=0>
                <label for="floor_space_min">Floor Space Min:</label>
                <input type="number" name="floor_space_min" id="floor_space_min" min=0>
                <label for="floor_space_max">Floor Space Max:</label>
                <input type="number" name="floor_space_max" id="floor_space_max" min=0>
                <label for="city">City:</label>
                <select name="city" id="city">
                    <option value="">All</option>
                    <?php
                    $sql = "SELECT * FROM city";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['city_id'] . '">' . $row['city_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="Apply Filter">
            </form>
        </div>

        <div class="property-cards">
            <?php
            include_once 'db_connect.php';

                          $sql = "SELECT p.*, c.city_name, pt.property_type_name, a.agent_name, a.agent_phoneNum
                        FROM property p
                        INNER JOIN city c ON p.city_id = c.city_id
                        INNER JOIN property_type pt ON p.property_type_id = pt.property_type_id
                        INNER JOIN agent a ON p.agent_id = a.agent_id
                        INNER JOIN property_status ps ON p.property_status_id = ps.property_status_id
                        WHERE 1=1"; // Start with a basic condition

                // Check if type filter is set
                if (isset($_GET['type']) && ($_GET['type'] == 'rent' || $_GET['type'] == 'sale')) {
                    $status_name = ($_GET['type'] == 'rent') ? 'For Rent' : 'For Sale';
                    $sql .= " AND ps.property_status_name = '$status_name'";
                }

                // Check and add property type filter
                if (isset($_GET['property_type']) && !empty($_GET['property_type'])) {
                    $property_type_id = $_GET['property_type'];
                    $sql .= " AND p.property_type_id = $property_type_id";
                }

                // Check and add price range filter
                if (isset($_GET['price_min']) && isset($_GET['price_max']) && $_GET['price_min'] !== '' && $_GET['price_max'] !== '') {
                    $price_min = $_GET['price_min'];
                    $price_max = $_GET['price_max'];
                    $sql .= " AND p.price BETWEEN $price_min AND $price_max";
                }

                // Check and add floor space range filter
                if (isset($_GET['floor_space_min']) && isset($_GET['floor_space_max']) && $_GET['floor_space_min'] !== '' && $_GET['floor_space_max'] !== '') {
                    $floor_space_min = $_GET['floor_space_min'];
                    $floor_space_max = $_GET['floor_space_max'];
                    $sql .= " AND p.floor_space BETWEEN $floor_space_min AND $floor_space_max";
                }

                // Check and add city filter
                if (isset($_GET['city']) && !empty($_GET['city'])) {
                    $city_id = $_GET['city'];
                    $sql .= " AND p.city_id = $city_id";
                }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Output property card HTML for each property
                    echo '<div class="property-card">';
                    echo '<div class="property-details">';
                    echo '<h2>' . $row['property_type_name'] . '</h2>';
                    echo '<h2 class="property-description-heading">Description:</h2>';
                    echo '<p class="property-description">' . $row['property_description'] . '</p>';
                    echo '<p><strong>Price:</strong> €' . $row['price'] . '</p>';
                    echo '<p><strong>Floor Space:</strong> ' . $row['floor_space'] . ' m<sup>2</sup></p>';
                    echo '<p><strong>Rooms:</strong> ' . $row['rooms_count'] . '</p>';
                    echo '<p><strong>Bedrooms:</strong> ' . $row['bedrooms_count'] . '</p>';
                    echo '<p><strong>Bathrooms:</strong> ' . $row['bathrooms_count'] . '</p>';
                    echo '<p><strong>Location:</strong> ' . $row['city_name'] . '</p>';
                    echo '</div>'; // property-details
                    echo '<div class="property-image">';
                    // Output property images here
                    // Add the Slick Slider container
                    echo '<div class="slider">';
                    // Fetch property images for this property from the database
                    $property_id = $row['property_id'];
                    $sql_images = "SELECT * FROM property_images WHERE property_id = $property_id";
                    $result_images = $conn->query($sql_images);
                    if ($result_images->num_rows > 0) {
                        while($row_image = $result_images->fetch_assoc()) {
                            // Output each property image as a slide
                            echo '<div><img src="' . $row_image['image_url'] . '"></div>';
                        }
                    }
                    echo '</div>'; // slider
                    echo '</div>'; // property-image
                    echo '<button class="contact-agent-button" onclick="showAgentInfo(\'' . $row['agent_name'] . '\', \'' . $row['agent_phoneNum'] . '\')">Contact Agent</button>'; // Add a button to show agent info
                    echo '</div>'; // property-card
                }
            } else {
                echo "No properties found";
            }
            ?>
        </div> <!-- property-cards -->
    </div> <!-- container -->

    <!-- Container for the button -->
<div class="center-button">
    <button onclick="window.location.href = 'welcomePage.php';">Go Back</button>
</div>

    <!-- Modal for agent info -->
    <div id="agent-info-modal" class="agent-info-modal">
        <div class="agent-info-content">
            <span class="close" onclick="hideAgentInfo()">&times;</span>
            <h2 id="agent-name"></h2>
            <p><strong>Phone:</strong> <span id="agent-phone"></span></p>
        </div>
    </div>

    <!-- Add Slick Slider JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.slider').slick({
                dots: true,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear'
            });
        });

        function showAgentInfo(agentName, agentPhone) {
            document.getElementById('agent-name').innerText = agentName;
            document.getElementById('agent-phone').innerText = agentPhone;
            document.getElementById('agent-info-modal').style.display = 'block';
        }

        function hideAgentInfo() {
            document.getElementById('agent-info-modal').style.display = 'none';
        }
    </script>

</body>
</html>

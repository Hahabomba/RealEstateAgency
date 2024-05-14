<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Real Estate Website</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
</head>
<body>
    <!-- Top Bar (Navigation Bar) -->
    <div class="top-bar">
        <div class="container">
            <div class="logo">
                <img src="RN_Logo.png" alt="Real Home Logo">
                <span class="agency-name">Real Home</span>
            </div>
            <nav class="navigation">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="properties.php?type=rent">Properties for Rent</a></li>
                    <li><a href="properties.php?type=sale">Properties for Sale</a></li>
                    <li><a href="addProperty.php">Add Property</a></li>
                    <li><a href="contact_page.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1>Welcome to Our Real Estate Agency - <span class="company-name">Real Home</span></h1>
        <p>We are your trusted partner in finding the perfect property.</p>
        <br>

    <section class="about-us">
        <h2>About Us</h2>
        <p>We are a start up real estate agency dedicated to helping you find your dream home. With understanding of the industry, we may assist our clients in buying, selling, and renting properties. Our team of expert agents is committed to providing personalized service and guiding you through every step of the process.</p>
        <p>At Real Home, we believe in transparency, integrity, and customer satisfaction. Whether you are a first-time buyer or an experienced investor, we are here to meet your needs and exceed your expectations. Contact us today to discover the difference that Real Home can make in your real estate journey.</p>
    </section>
    <br>


    <!-- Featured Properties -->
       <section class="featured-properties">
           <h2>Featured Properties</h2>
           <div class="property-cards">
               <?php
               include_once 'db_connect.php';

               // Fetch and display featured properties (example: display 4 properties)
               $sql_featured = "SELECT p.*, c.city_name, pt.property_type_name, a.agent_name, a.agent_phoneNum
                                FROM property p
                                INNER JOIN city c ON p.city_id = c.city_id
                                INNER JOIN property_type pt ON p.property_type_id = pt.property_type_id
                                INNER JOIN agent a ON p.agent_id = a.agent_id
                                INNER JOIN property_status ps ON p.property_status_id = ps.property_status_id
                                LIMIT 4"; // Limit to 4 properties
               $result_featured = $conn->query($sql_featured);

               if ($result_featured->num_rows > 0) {
                   while($row = $result_featured->fetch_assoc()) {
                       // Output property card HTML for each featured property
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
                       echo '</div>'; // property-card
                   }
               } else {
                   echo "No featured properties found";
               }
               ?>
           </div> <!-- property-cards -->
       </section>
       <br>




    <section class="looking-for">
    <h2>What are you looking for?</h2>
    <div class="options-container">
        <a href="properties.php?type=sale" class="option buy">BUY</a>
        <a href="properties.php?type=rent" class="option rent">RENT</a>
    </div>
    </section>
    <br>

    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>Contact us: info@realhome.com | Phone: +359 111 111 111</p>
            <p>Real Home &copy; <?php echo date("Y"); ?>. All rights reserved.</p>
            <p>We are offering the best properties on the market, so do not hesitate to contact us!</p>
        </div>
    </footer>
</body>



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
</script>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Results</title>
    <link rel="stylesheet" href="display_contact_results.css">
</head>
<body>
    <div class="container">
        <h1>Contact Form Results</h1>
        <?php
        // Retrieve and display form data
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<div class='result'>";
            echo "<h2>Name:</h2>";
            echo "<p>" . htmlspecialchars($_POST["name"]) . "</p>";
            echo "</div>";

            echo "<div class='result'>";
            echo "<h2>Email:</h2>";
            echo "<p>" . htmlspecialchars($_POST["email"]) . "</p>";
            echo "</div>";

            echo "<div class='result'>";
            echo "<h2>Telephone:</h2>";
            echo "<p>" . htmlspecialchars($_POST["telephone"]) . "</p>";
            echo "</div>";

            echo "<div class='result'>";
            echo "<h2>Subject:</h2>";
            echo "<p>" . htmlspecialchars($_POST["subject"]) . "</p>";
            echo "</div>";

            echo "<div class='result'>";
            echo "<h2>Message:</h2>";
            echo "<p>" . htmlspecialchars($_POST["message"]) . "</p>";
            echo "</div>";
        }
        ?>
          <input type="button" value="Go Back" id="form_button" onclick="window.location.href='welcomePage.php'" />

    </div>
</body>
</html>

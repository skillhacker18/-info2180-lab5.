<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// Create connection to the database
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Get the country and lookup parameters from the GET request
$country = isset($_GET['country']) ? $_GET['country'] : '';
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

// If the lookup parameter is set to 'cities', run a different query to return the cities
if ($lookup === 'cities') {
    if ($country) {
        // SQL query to fetch cities for the specified country
        $stmt = $conn->prepare("SELECT cities.name AS city_name, cities.district, cities.population, countries.name AS country_name FROM cities JOIN countries ON cities.country_code = countries.code WHERE countries.name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output the results in an HTML table
        echo "<div class='table-container'>";
        echo "<table class='styled-table'>";
        echo "<tr><th>Name</th><th>District</th><th>Population</th></tr>";
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['district']) . "</td>";
            echo "<td>" . htmlspecialchars($row['population']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "Please enter a country name.";
    }
} else {
    // If no lookup parameter or lookup is not 'cities', fetch country information
    if ($country) {
        // SQL query with LIKE to perform partial search
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
    } else {
        // If no country is provided, fetch all countries
        $stmt = $conn->query("SELECT * FROM countries");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="table-container">
        <table class="styled-table">
            <tr>
                <th>Country Name</th>
                <th>Continent</th>
                <th>Independence Year</th>
                <th>Head of State</th>
            </tr>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name'] ?? 'N/A'); ?></td>
                <td><?= htmlspecialchars($row['continent'] ?? 'N/A'); ?></td>
                <td><?= htmlspecialchars($row['independence_year'] ?? 'N/A'); ?></td>
                <td><?= htmlspecialchars($row['head_of_state'] ?? 'N/A'); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php
}
?>

<?php
// set the URL for the API
$url= "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";

// fetch the data from the API and decode the JSON response
$response = file_get_contents($url);
$data = json_decode($response, true);

// extract the results if available
if(!$data || !isset($data ["results"])){
    die('Error fatching the data from the API')
}
$result = $data["results"];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment Data</title>
    <!-- Pico CSS for styling the table -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    </head>
    <body>
        <main class="container">
        <h1>UOB Student Enrollment Data</h1>
    <!-- wrap table in a container to make it scrollable on small screens -->
    <div class="table-container">>
        <table>
            <thead>
                <!-- table headers for student data -->
                <tr>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Program</th>
                    <th>Nationality</th>
                    <th>College</th>
                    <th>Number of Students</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($result)): ?>
                    <tr class="no-data">
                        <td colspan="6">No data available for the specified filters!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($result as $records): ?>
                        <?php $fields = $records ?? [];?>
                <tr>
                    <!-- use htmlspecialchars to prevent XSS -->
                    <td><?= htmlspecialchars($fields['year'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($fields['semester'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($fields['the_programs'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($fields['nationality'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($fields['colleges'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($fields['number_of_students'] ?? 'N/A') ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        </main>
    </body>
</html>
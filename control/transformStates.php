<?php
header('Content-Type: application/json');

// Include the database connection file
require_once './conn.php';

try {
    // Fetch the data from states.php
    $response = file_get_contents('http://localhost/home-control/dB/states.php');
    $data = json_decode($response, true);

    // Initialize transformed data
    $transformedData = array();

    // Check if the data is an array of objects
    if (is_array($data)) {
        foreach ($data as $item) {
            // Add each item to the dictionary with room number as the key
            $transformedData[$item['room']] = array(
                'room' => $item['room'],
                'state' => $item['state']
            );
        }
    } else {
        // Return an error if data format is not as expected
        $transformedData['error'] = 'Invalid data format';
    }

    // Output transformed data in JSON format
    echo json_encode($transformedData);
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['container']) && isset($_POST['state'])) {
        $container = intval($_POST['container']);
        $state = $_POST['state'] === 'on' ? 1 : 0; // Convert 'on' to 1 and 'off' to 0

        // Save the state to a file
        $filename = './light_states.txt';
        $lightStates = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];
        $lightStates[$container] = $state; // Corrected variable name
        file_put_contents($filename, json_encode($lightStates));

        echo "Container $container is now " . ($state ? 'on' : 'off');
    } else {
        echo "Required parameters missing.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3D1E2D; 
            color: #F5E6E8; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .output-container {
            background-color: #5A2837; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: left;
        }

        h2 {
            color: #F5E6E8; 
        }

        .output-list {
            background-color: #7A3D4C; 
            padding: 10px;
            border-radius: 5px;
            list-style-type: none;
        }

        .output-list li {
            margin: 5px 0;
        }

        a {
            color: #A64558; 
            text-decoration: none;
            font-weight: bold;
            display: block;
            margin-top: 20px;
            text-align: center;
        }

        a:hover {
            color: #872F47; 
        }
    </style>
</head>
<body>
    <div class="output-container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mac_address = $_POST["mac_address"];
            $dhcp_version = $_POST["dhcp_version"];
            
            // Calling the Python script
            $command = escapeshellcmd("python3 network_config.py $mac_address $dhcp_version");
            $output = shell_exec($command);

            // Decode JSON and display as a list
            $result = json_decode($output, true);
            echo "<h2>Assigned IP Details:</h2>";
            if ($result && is_array($result)) {
                echo "<ul class='output-list'>";
                foreach ($result as $key => $value) {
                    echo "<li><strong>" . htmlspecialchars($key) . ":</strong> " . htmlspecialchars($value) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Error processing the request. Please try again.</p>";
            }
        } else {
            echo "<h2>Error</h2>";
            echo "<p>No data received. Please go back and submit the form.</p>";
        }
        ?>
        <a href="form.php">Go Back</a>
    </div>
</body>
</html>

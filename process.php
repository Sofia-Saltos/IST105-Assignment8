<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3D1E2D; 
            color: #F5E6E8; 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .output-container {
            background-color: #5A2837; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #F5E6E8; 
        }

        pre {
            background-color: #7A3D4C; 
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
            color: #F5E6E8; 
        }

        a {
            color: #A64558; 
            text-decoration: none;
            font-weight: bold;
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
            
            echo "<h2>Assigned IP Details:</h2>";
            echo "<pre>$output</pre>";
        } else {
            echo "<h2>Error</h2>";
            echo "<p>No data received. Please go back and submit the form.</p>";
        }
        ?>
        <a href="form.php">Go Back</a>
    </div>
</body>
</html>

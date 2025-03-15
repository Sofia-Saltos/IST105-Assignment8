<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(149, 98, 123); 
            color: #F5E6E8; 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #5A2837; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #7A3D4C; 
            border-radius: 5px;
            background-color: #7A3D4C; 
            color: #F5E6E8; 
        }

        input[type="submit"] {
            background-color: #A64558; 
            color: #F5E6E8; 
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #872F47; 
        }
    </style>
</head>
<body>
    <form action="process.php" method="post">
        <label for="mac_address">MAC Address:</label>
        <input type="text" id="mac_address" name="mac_address" required>

        <label for="dhcp_version">DHCP Version:</label>
        <select id="dhcp_version" name="dhcp_version" required>
            <option value="DHCPv4">DHCPv4</option>
            <option value="DHCPv6">DHCPv6</option>
        </select>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

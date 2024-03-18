<?php
// Database configuration (same as your previous file)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "opinions";



$conn = new mysqli($servername, $username, $password, $dbname);

// Your database connection code (same as before)

// Select data from the database
$selectQuery = "SELECT id, `To`, opinion FROM opinion";
$result = $conn->query($selectQuery);

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  







    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .table-container {
            max-height: 400px; /* Adjust this height based on your preference */
            overflow: auto;
        }



        /* Responsive styles for mobile view */
        /* Responsive styles for mobile view */
/* Responsive styles for mobile view */



        #background-iframe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            border: none;
        }

        #content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-height: 80vh; /* Maximum height for scrolling */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
            color: black;
        }

        th {
            background-color: #212f45;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            #content {
                margin: 20px;
            }
            table {
                font-size: 14px;
            }
            th, td {
                padding: 8px;
            }
        }
    </style>

    <!-- Additional styles for buttons -->
    <style>
        .btn {
            margin: 10px;
            padding: 15px 40px;
            border: none;
            outline: none;
            color: #FFF;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 12px;
        }

        .btn::after {
            content: "";
            z-index: -1;
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #333;
            left: 0;
            top: 0;
            border-radius: 10px;
        }

        /* Responsive styles for mobile view */
        @media only screen and (max-width: 600px) {
            .btn {
                display: block;
                margin: 10px auto;
            }

            .btn + .btn {
                margin-top: 10px;
            }
        }

        /* glow */
        .btn::before {
            content: "";
            background: linear-gradient(
                45deg,
                #FF0000, #FF7300, #FFFB00, #48FF00,
                #00FFD5, #002BFF, #FF00C8, #FF0000
            );
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 600%;
            z-index: -1;
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            filter: blur(8px);
            animation: glowing 20s linear infinite;
            transition: opacity .3s ease-in-out;
            border-radius: 10px;
            opacity: 0;
        }

        @keyframes glowing {
            0% { background-position: 0 0; }
            50% { background-position: 400% 0; }
            100% { background-position: 0 0; }
        }

        /* hover */
        .btn:hover::before {
            opacity: 1;
        }

        .btn:active:after {
            background: transparent;
        }

        .btn:active {
            color: #000;
            font-weight: bold;
        }


    </style>




    
</head>
<body>
    <!-- Spline iframe as background -->
    <iframe id="background-iframe" src='https://my.spline.design/molang3dcopy-7ea025cad6138a9cd1e36e135003fae5/' frameborder='0' width='100%' height='100%'></iframe>

    <!-- Content -->
    <div id="content">
    <h2 style="text-align: center; color: #3498db; font-family: 'Pacifico', cursive; font-size: 2em; text-shadow: 2px 2px 4px #666;">Opinions</h2>
        



    <div class="table-container">
    <table>
            <tr>
                <th>S_No</th>
                <th>TO</th>
                <th>Opinion</th>
            </tr>
            <?php
            $counter = 1;
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' .$counter . '</td>
                        <td>' . $row["To"] . '</td>
                        <td>' . $row["opinion"] . '</td>
                    </tr>';
                $counter++;
            }
            ?>
        </table>
    </div>

    
    
    
   
        <button class="btn" onclick="clearTable()">Clear</button>

<!-- Download Button -->
<button class="btn" onclick="downloadTable()">Download</button>
    </div>

    <script>
function clearTable() {
    // Send AJAX request to clear the table
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "clear.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Reload the page after the backend process is completed
            location.reload();
        }
    };
    xhr.send();
}

function downloadTable() {
    // Trigger download of CSV file
    exportTableToCSV();
}

function exportTableToCSV() {
    var table = document.querySelector('table');
    var rows = table.querySelectorAll('tr');
    var csvContent = '';

    // Iterate through rows and columns to build CSV content
    rows.forEach(function (row) {
        var rowData = [];
        var columns = row.querySelectorAll('td');
        columns.forEach(function (column) {
            rowData.push(column.innerText);
        });
        csvContent += rowData.join(',') + '\n';
    });

    // Create a Blob from the CSV content
    var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

    // Create a link element and set its download attribute to the desired file name
    var a = document.createElement('a');
    a.href = window.URL.createObjectURL(blob);
    a.download = 'opinions.csv';

    // Append the link to the body and click it programmatically
    document.body.appendChild(a);
    a.click();

    // Remove the link from the document
    document.body.removeChild(a);
}
</script>



    
</body>
</html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBORD</title>
    <link rel="stylesheet" href="Style/dashbord1.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="website icon"  type="png" href="image/MD-removebg-preview.png">

   
    
</head>

<?php



    include 'connixen.php';
    

    

    // Now, let's count the number of rows in the `order` table where boutique matches client's boutique
    
    $sql_count_orders = "SELECT COUNT(botique) AS order_count FROM client";
    $stmt_count_orders = $con->prepare($sql_count_orders);
    $stmt_count_orders->execute();
    $result_count_orders = $stmt_count_orders->get_result();

    // Fetching the row from the result set
    $row_count_orders = $result_count_orders->fetch_assoc();

    // Order complete
    $sql_count_orders_complete = "SELECT COUNT(Statu) AS count_orders_complete FROM `order` where Statu='Livree'";
    $stmt_count_orders_complete = $con->prepare($sql_count_orders_complete);
    $stmt_count_orders_complete->execute();
    $result_count_orders_complete = $stmt_count_orders_complete->get_result();
    // Fetch result
    $row_count_orders_complete = $result_count_orders_complete->fetch_assoc();

    // Order Annule
    $sql_count_orders_Annule = "SELECT COUNT(Statu) AS count_orders_Annule FROM `order` where Statu='Annule'";
    $stmt_count_orders_Annule = $con->prepare($sql_count_orders_Annule);
    $stmt_count_orders_Annule->execute();
    $result_count_orders_Annule = $stmt_count_orders_Annule->get_result();
    // Fetch result
    $row_count_orders_Annule = $result_count_orders_Annule->fetch_assoc();

?>
<body>
    <div class="contner">
    <div class="nav-bar" id="navBar">
        <img src="image/MD-removebg-preview.png" alt="" class="nav-logo">

        <ul>
            <li class="active"><a href="">HOME</a></li>
            <li><a href="Order_admin.php"  class="disactive">Orders</a></li>

            <li><a href="reportadmin.php" class="disactive">Reports</a></li>
            <li><a href="client.php" class="disactive">Database</a></li>
        </ul>
    </div>
    <div class="hedbar">
         <input type="checkbox" id="checkbox">
    <label for="checkbox" class="toggle">
        <div class="bars" id="bar1"></div>
        <div class="bars" id="bar2"></div>
        <div class="bars" id="bar3"></div>
    </label>
    <div class="barx">
        <h3>Overview</h3>
        <h4>WELCOME,Admin</h4>
        <div class="profile">
            <a href="login.php" ><img src="image/images.png" alt=""></a>
        </div></div>
    </div>
</div>
<div class="card-contenar">
<div class="card">
            <?php
            if(isset($row_count_orders['order_count'])) {
                $order_count = $row_count_orders['order_count'];
                echo "<h1>" . $order_count . "</h1>";
            }
            ?>
            <img src="image/complete-order-icon-in-flat-style-for-any-projects-vector-35503994-removebg-preview.png" alt="" class="im-card">
            <h3>Total Users</h3>
        </div>
        <div class="card1">
            <h1><?php echo isset($row_count_orders_complete['count_orders_complete']) ? $row_count_orders_complete['count_orders_complete'] : '0'; ?></h1>
            <img src="image/124295101-boîte-en-carton-de-vecteur-avec-coche-cargaison-livrée-livraison-vérifiée-livraison-par-e-mail-removebg-preview.png" alt="" class="im-card">
            <h3>Orders Complete</h3>
        </div>
        <div class="card2">
            <h1><?php echo isset($row_count_orders_Annule['count_orders_Annule']) ? $row_count_orders_Annule['count_orders_Annule'] : '0'; ?></h1>
            <h3>Orders Annule</h3>
            <img src="image/download__4_-removebg-preview.png" alt="" class="im-card">
        </div>
</div>
<?php
include 'connixen.php';

// Error handling for database connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get current year
$currentYear = date('Y');

// Prepare the SQL query to fetch data for each month
$sql = "SELECT MONTH(date) AS month, YEAR(date) AS year, 
               SUM(CASE WHEN Statu = 'Livree' THEN 1 ELSE 0 END) AS delivered_count,
               SUM(CASE WHEN Statu = 'Annule' THEN 1 ELSE 0 END) AS canceled_count,
               COUNT(*) AS total_orders
        FROM `order`
        WHERE YEAR(date) = ?
        GROUP BY YEAR(date), MONTH(date)
        ORDER BY YEAR(date), MONTH(date)";

// Prepare and execute the statement
if ($stmt = $con->prepare($sql)) {
    $stmt->bind_param("i", $currentYear);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize arrays to hold the data
    $labels = [];
    $deliveredData = [];
    $canceledData = [];
    $totalOrdersData = [];

    // Fetching and storing data for the chart
    while ($row = $result->fetch_assoc()) {
        $labels[] = date('F Y', mktime(0, 0, 0, $row['month'], 1, $row['year']));
        $deliveredData[] = $row['delivered_count'];
        $canceledData[] = $row['canceled_count'];
        $totalOrdersData[] = $row['total_orders'];
    }
} else {
    echo "Error in preparing statement: " . $con->error;
}

// Close the statement and connection
$stmt->close();
$con->close();
?>

<!-- HTML Canvas and JavaScript Chart.js code -->
<canvas id="livreeChart" style="width: 100%;" height="300"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample data for the bar chart
    var data = {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Orders Delivered',
            data: <?php echo json_encode($deliveredData); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }, {
            label: 'Orders Canceled',
            data: <?php echo json_encode($canceledData); ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: 'Total Orders',
            data: <?php echo json_encode($totalOrdersData); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    // Configuration options
    var options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Get the canvas element
    var ctx = document.getElementById('livreeChart').getContext('2d');

    // Create the bar chart
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
    












        

    // Function to generate month labels
    function generateMonthLabels(startMonthIndex, startYear, numMonths) {
        var labels = [];
        for (var i = 0; i < numMonths; i++) {
            var monthIndex = (startMonthIndex + i) % 12; // Ensure the index stays within the range 0-11
            var year = startYear + Math.floor((startMonthIndex + i) / 12);
            labels.push(getMonthYear(monthIndex, year));
        }
        return labels;
    }

    // Function to get month and year
    function getMonthYear(monthIndex, year) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var monthName = months[monthIndex];
        if (monthIndex >"December") { // Check if the month is December
            return monthName + ' ' + (year + 1);
        } else {
            return monthName + ' ' + year;
        }
    }

    
</script>

</body>
</html>
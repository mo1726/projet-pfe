<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBORD</title>
    <link rel="stylesheet" href="Style/dashbord1.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="website icon"  type="png" href="image/MD-removebg-preview.png">
    
</head>


<body>
    <div class="contner">
    <div class="nav-bar" id="navBar">
        <img src="image/MD-removebg-preview.png" alt="" class="nav-logo">

        <ul>
            <li class="active"><a href=""  >HOME</a></li>
            <li ><a href="orders.php" class="disactive">Orders</a></li>
            <li><a href="ramassage.php" class="disactive">Ramassage</a></li>
            <li><a href="" class="disactive">Products</a></li>
            <li><a href="report.php" class="disactive">Reports</a></li>
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
        <?php
session_start();
if (isset($_SESSION['Email'])) {
    $Email = $_SESSION['Email'];
    include 'connixen.php';
    $sqll = "SELECT name, Prenom, botique FROM client WHERE Email=?";
    $add = $con->prepare($sqll);
    $add->bind_param("s", $Email);
    $add->execute();
    $result_client = $add->get_result();

    // Fetching the row from the result set
    $row_client = $result_client->fetch_assoc();

    // Displaying the client's name if logged in
    echo "<h4>" .'WELCOME '. $row_client["name"] . ' ' . $row_client['Prenom'] . "</h4>";

    // Now, let's count the number of rows in the `order` table where botique matches client's botique
    $client_botique = $row_client['botique'];
    $sql_count_orders = "SELECT COUNT(*) AS order_count FROM `order` WHERE botique = ?";
    $stmt_count_orders = $con->prepare($sql_count_orders);
    $stmt_count_orders->bind_param("s", $client_botique);
    $stmt_count_orders->execute();
    $result_count_orders = $stmt_count_orders->get_result();

    // Fetching the row from the result set
    $row_count_orders = $result_count_orders->fetch_assoc();


    

    // Order complete
    
    $sql_count_orders_complete = "SELECT COUNT(Statu) AS count_orders_complete FROM `order` where Statu='Livree' AND botique=?";
    $stmt_count_orders_complete = $con->prepare($sql_count_orders_complete);
    $stmt_count_orders_complete->bind_param("s", $client_botique);
    $stmt_count_orders_complete->execute();
    $result_count_orders_complete = $stmt_count_orders_complete->get_result();
    //Fetch result
    $row_count_orders_complete = $result_count_orders_complete->fetch_assoc();
    
    
    // Order Annule
    
    $sql_count_orders_Annule = "SELECT COUNT(Statu) AS count_orders_Annule FROM `order` where Statu='Annule' AND botique=?";
    $stmt_count_orders_Annule = $con->prepare($sql_count_orders_Annule);
    $stmt_count_orders_Annule->bind_param("s", $client_botique);
    $stmt_count_orders_Annule->execute();
    $result_count_orders_Annule = $stmt_count_orders_Annule->get_result();
    //Fetch result
    $row_count_orders_Annule = $result_count_orders_Annule->fetch_assoc();
    
} else {
    // Handle case where user is not logged in
    echo "<h4>Welcome Ghost</h4>";
}
?>

        <div class="profile">
            <a href="PAGE_Sitting.php"><img src="image/images.png" alt=""></a>
        </div></div>
    </div>
</div>
<div class="card-contenar">
<div class="card">
    <h1><?php
    $order_count = $row_count_orders['order_count'];
    echo "<h1>" . $order_count . "</h1>";
    
    
    
    ?></h1>
    <img src="image/complete-order-icon-in-flat-style-for-any-projects-vector-35503994-removebg-preview.png" alt="" class="im-card">
    <h3>Total Orders</h3>
</div>
<div class="card1">
<h1><?php
    $orders_complete = $row_count_orders_complete['count_orders_complete'];
    echo "<h1>" . $orders_complete . "</h1>";
    
    
    
    ?></h1>
    <img src="image/124295101-boîte-en-carton-de-vecteur-avec-coche-cargaison-livrée-livraison-vérifiée-livraison-par-e-mail-removebg-preview.png" alt="" class="im-card">
    <h3>Orders Complete</h3>
</div>
<div class="card2">
<h1><?php
    
    $orders_Annule = $row_count_orders_Annule['count_orders_Annule'];
    echo "<h1>" . $orders_Annule . "</h1>";
    
    
    ?></h1>
    <h3>Orders Annule</h3>
    <img src="image/download__4_-removebg-preview.png" alt="" class="im-card">
</div>
</div>
<?php

$currentMonth = date('m');
$currentYear = date('Y');

// Prepare the SQL query to fetch data for each month
$sql = "SELECT MONTH(date) AS month, YEAR(date) AS year, 
               SUM(CASE WHEN Statu = 'Livree' THEN 1 ELSE 0 END) AS delivered_count,
               SUM(CASE WHEN Statu = 'Annule' THEN 1 ELSE 0 END) AS canceled_count,
               COUNT(*) AS total_orders
        FROM `order`
        WHERE botique = ? AND YEAR(date) = ?
        GROUP BY YEAR(date), MONTH(date)
        ORDER BY YEAR(date), MONTH(date)";

$stmt = $con->prepare($sql);
$stmt->bind_param("si", $client_botique, $currentYear);
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
?>

<canvas id="livreeChart" style="width: 100%;" height="300"></canvas>
<script>
    function generateRandomDeliveryData(numMonths) {
        var data = [11,29,35,75,26, 71,98,29]; // Removed the extra comma
        for (var i = 0; i < numMonths; i++) {
            data.push(Math.floor(Math.random() * 50) + 1); // Random value between 1 and 50 for demonstration
        }
        return data;
    }

    // Function to add a new month and remove the last month
    function updateChartData(chart, newMonth) {
        var currentData = chart.data.datasets[0].data;
        var currentLabels = chart.data.labels;

        // Remove the first element (oldest month)
        currentData.shift();
        currentLabels.shift();

        // Add a new month
        currentData.push(newMonth);
        var d = new Date();
        currentLabels.push(getMonthYear(d.getMonth(), d.getFullYear()));

        chart.update(); // Update the chart to reflect changes
    }

    // Sample data for the bar chart
    var d = new Date();
    var numMonths = 8; // Number of months to display initially
    var deliveryData = generateRandomDeliveryData(numMonths);
    
   // Sample data for the bar chart
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
        if (monthIndex === 11) { // Check if the month is December
            return monthName + ' ' + (year + 1);
        } else {
            return monthName + ' ' + year;
        }
    }
</script>


</body>
</html>
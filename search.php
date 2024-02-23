<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logbook";


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination
$results_per_page = 10;
$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = intval($_GET['page']);
}
$start_from = ($page - 1) * $results_per_page;

// Search query
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);    // Remove leading and trailing spaces
    $search = mysqli_real_escape_string($conn, $search);      // Prevent SQL injection
    $sql = "SELECT COUNT(*) AS total FROM personal_info WHERE fname LIKE '%$search%'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_records = $row["total"];
    $total_pages = ceil($total_records / $results_per_page);
    $sql = "SELECT * FROM personal_info WHERE fname LIKE '%$search%' LIMIT $start_from, $results_per_page";
} else {
    $sql = "SELECT COUNT(*) AS total FROM personal_info";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_records = $row["total"];
    $total_pages = ceil($total_records / $results_per_page);
    $sql = "SELECT * FROM personal_info LIMIT $start_from, $results_per_page";
}

$result = $conn->query($sql);

// Display search results
$search_results = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ccc;
            margin-right: 5px;
        }
        .pagination a.active {
            background-color: #ccc;
        }
    </style>
</head>

<body>
    <h1>Search Results</h1>

    <!-- Search form -->
    <form action="search.php" method="GET">
        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Display search results -->
    <?php if (!empty($search_results)): ?>
        <ul>
            <?php foreach ($search_results as $result): ?>
                <li><?php echo htmlspecialchars($result['fname']); ?></li>
                <li><?php echo htmlspecialchars($result['lname']); ?></li>
                <li><?php echo htmlspecialchars($result['address']); ?></li>
                <li><?php echo htmlspecialchars($result['contact']); ?></li>
                <li><?php echo htmlspecialchars($result['vehicle_info']); ?></li>


            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No results found</p>
    <?php endif; ?>

    <!-- Pagination links -->
    <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>&search=<?php echo urlencode($search); ?>">Previous</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo ($page + 1); ?>&search=<?php echo urlencode($search); ?>">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>

</html>
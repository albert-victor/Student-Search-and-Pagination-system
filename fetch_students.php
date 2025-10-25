<?php
// Include the database connection file to connect to the database
include('db.php');

// RECEIVE PARAMETERS: Get values from the URL query string (GET parameters) and sanitize them to prevent SQL injection
$search     = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';  // Search term for first_name, last_name, or email
$gender     = isset($_GET['gender']) ? $conn->real_escape_string($_GET['gender']) : '';  // Gender filter
$classFilter = isset($_GET['classFilter']) ? $conn->real_escape_string($_GET['classFilter']) : '';  // Class filter
$sort_by    = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';  // Column to sort by (default: created_at)
$order      = isset($_GET['order']) ? $_GET['order'] : 'DESC';  // Sort order: ASC or DESC (default: DESC)
$page       = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Current page number (default: 1)
$limit      = 5;  // Number of records to show per page
$start      = ($page - 1) * $limit;  // Calculate the starting row for the LIMIT clause in SQL

// BUILD WHERE CONDITIONS: Create an array of SQL WHERE clauses based on filters
$where = [];  // Start with an empty array
if ($search != '') {
    // If search is provided, add a condition to match first_name, last_name, or email
    $where[] = "(first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%')";
}
if ($gender != '') {
    // If gender is provided, add a condition to match gender exactly
    $where[] = "gender = '$gender'";
}
if ($classFilter != '') {
    // If classFilter is provided, add a condition to match class exactly
    $where[] = "class = '$classFilter'";
}
// Combine all WHERE conditions into a single SQL string, or leave empty if no filters
$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

// TOTAL COUNT: Query to count total records matching the filters (for pagination)
$countQuery = "SELECT COUNT(*) AS total FROM students $whereSQL";  // SQL query to get total count
$countRes = $conn->query($countQuery);  // Execute the query
$total = $countRes->fetch_assoc()['total'];  // Get the total number of records
$totalPages = ceil($total / $limit);  // Calculate total pages (round up)

// MAIN QUERY: Fetch the actual records for the current page, with filters and sorting
$query = "SELECT * FROM students $whereSQL ORDER BY $sort_by $order LIMIT $start, $limit";  // SQL query with WHERE, ORDER BY, and LIMIT
$result = $conn->query($query);  // Execute the query
?>

<!-- Start of the HTML table to display student data -->
<table>
<!-- Table header with column names -->
<thead>
<tr>
    <!-- Sortable column for Name (first_name) -->
    <th class="sortable" data-column="first_name" data-order="<?php echo $order; ?>">Name</th>
    <!-- Non-sortable column for Email -->
    <th>Email</th>
    <!-- Non-sortable column for Gender -->
    <th>Gender</th>
    <!-- Non-sortable column for Class -->
    <th>Class</th>
    <!-- Sortable column for Created At -->
    <th class="sortable" data-column="created_at" data-order="<?php echo $order; ?>">Created At</th>
</tr>
</thead>
<!-- Table body to display the data rows -->
<tbody>

<?php if ($result->num_rows > 0):  // Check if there are any results from the query ?>
    <?php while ($row = $result->fetch_assoc()):  // Loop through each row of results ?>
    <tr>
        <!-- Display full name (first_name + last_name), escaped for security -->
        <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
        <!-- Display email, escaped for security -->
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <!-- Display gender (no escaping needed if it's controlled data) -->
        <td><?php echo $row['gender']; ?></td>
        <!-- Display class (no escaping needed if it's controlled data) -->
        <td><?php echo $row['class']; ?></td>
        <!-- Display created_at timestamp -->
        <td><?php echo $row['created_at']; ?></td>
    </tr>
    <?php endwhile;  // End the loop ?>
<?php else:  // If no results, show a message ?>
    <tr><td colspan="5" style="text-align:center;">No records found</td></tr>
<?php endif;  // End the if-else ?>

</tbody>
</table>

<!-- PAGINATION: Section for page navigation links -->
<div class="pagination">
    <!-- CHANGE APPLIED HERE: Added conditional "Previous" button -->
    <!-- Only show "Previous" if not on the first page (page > 1) -->
    <?php if ($page > 1): ?>
        <a href="#" class="page-link prev-btn" data-page="<?php echo $page - 1; ?>">Previous</a>
    <?php endif; ?>
    
    <!-- Existing page number links (unchanged) -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="#" class="page-link <?php echo ($i == $page) ? 'active' : ''; ?>" data-page="<?php echo $i; ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    
    <!-- CHANGE APPLIED HERE: Added conditional "Next" button -->
    <!-- Only show "Next" if not on the last page (page < totalPages) -->
    <?php if ($page < $totalPages): ?>
        <a href="#" class="page-link next-btn" data-page="<?php echo $page + 1; ?>">Next</a>
    <?php endif; ?>
</div>

<!-- JavaScript for handling pagination clicks (unchanged) -->
<script>
// Pagination links reload data dynamically when clicked
$('.page-link').click(function(e){
    e.preventDefault();  // Prevent default link behavior
    let page = $(this).data('page');  // Get the page number from the data attribute
    let search = $('#search').val();  // Get current search value
    let gender = $('#gender').val();  // Get current gender filter
    let classFilter = $('#class').val();  // Get current class filter
    // Call loadData function to reload the page with new parameters (assuming loadData is defined elsewhere)
    loadData(search, gender, classFilter, '<?php echo $sort_by; ?>', '<?php echo $order; ?>', page);
});
</script>

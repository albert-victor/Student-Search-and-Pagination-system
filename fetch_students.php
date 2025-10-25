<?php
include('db.php');



// RECEIVE PARAMETERS
$search     = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$gender     = isset($_GET['gender']) ? $conn->real_escape_string($_GET['gender']) : '';
$classFilter = isset($_GET['classFilter']) ? $conn->real_escape_string($_GET['classFilter']) : '';
$sort_by    = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
$order      = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$page       = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit      = 5;
$start      = ($page - 1) * $limit;

// BUILD WHERE CONDITIONS
$where = [];
if ($search != '') {
    $where[] = "(first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%')";
}
if ($gender != '') {
    $where[] = "gender = '$gender'";
}
if ($classFilter != '') {
    $where[] = "class = '$classFilter'";
}
$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

// TOTAL COUNT
$countQuery = "SELECT COUNT(*) AS total FROM students $whereSQL";
$countRes = $conn->query($countQuery);
$total = $countRes->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// MAIN QUERY
$query = "SELECT * FROM students $whereSQL ORDER BY $sort_by $order LIMIT $start, $limit";
$result = $conn->query($query);
?>

<table>
<thead>
<tr>
    <th class="sortable" data-column="first_name" data-order="<?php echo $order; ?>">Name</th>
    <th>Email</th>
    <th>Gender</th>
    <th>Class</th>
    <th class="sortable" data-column="created_at" data-order="<?php echo $order; ?>">Created At</th>
</tr>
</thead>
<tbody>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo $row['gender']; ?></td>
        <td><?php echo $row['class']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr><td colspan="5" style="text-align:center;">No records found</td></tr>
<?php endif; ?>

</tbody>
</table>

<!-- PAGINATION -->
<div class="pagination">
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="#" class="page-link <?php echo ($i == $page) ? 'active' : ''; ?>" data-page="<?php echo $i; ?>">
        <?php echo $i; ?>
    </a>
<?php endfor; ?>
</div>


<script>
// Pagination links reload data dynamically
$('.page-link').click(function(e){
    e.preventDefault();
    let page = $(this).data('page');
    let search = $('#search').val();
    let gender = $('#gender').val();
    let classFilter = $('#class').val();
    loadData(search, gender, classFilter, '<?php echo $sort_by; ?>', '<?php echo $order; ?>', page);
});
</script>

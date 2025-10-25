<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Records | Search, Filter & Sort</title>
<link rel="stylesheet" href="style.css">
<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
<h1>🎓 Student Records</h1>

<!-- SEARCH + FILTER FORM -->
<div class="search-filter">
    <input type="text" id="search" placeholder="🔍 Search student by name or email...">

    <select id="gender">
        <option value="">All Genders</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>

    <select id="class">
        <option value="">All Classes</option>
         <option value="Networking">Networking</option>
        <option value="Graphics">Graphics</option>
        <option value="Software">Software</option>
        <option value="ICT">ICT</option>
        <option value="Form 1">Form 1</option>
        <option value="Form 2">Form 2</option>
        <option value="Form 3">Form 3</option>
        <option value="Form 4">Form 4</option>
        
       
    </select>
</div>

<!-- TABLE SECTION -->
<div id="table-data">
    <!-- Data from fetch_students.php will load here via AJAX -->
</div>

</div>


<script>
/*
    EXPLANATION:
    - function loadData() inatumia AJAX kuleta data kutoka fetch_students.php
    - inatuma parameters (search, gender, class, sort) bila ku-refresh page
    - tunaitwa kila mara user akiandika search au kubadilisha filter
*/

function loadData(search = '', gender = '', classFilter = '', sort_by = 'created_at', order = 'DESC', page = 1) {
    $.ajax({
        url: 'fetch_students.php',
        method: 'GET',
        data: { search, gender, classFilter, sort_by, order, page },
        success: function(response) {
            $('#table-data').html(response);
        }
    });
}

// Initial load
loadData();

// Event listeners for search and filters
$('#search, #gender, #class').on('input change', function() {
    loadData($('#search').val(), $('#gender').val(), $('#class').val());
});

// Sorting listener (delegated since table loads dynamically)
$(document).on('click', '.sortable', function() {
    let sort_by = $(this).data('column');
    let order = $(this).data('order');
    order = order === 'ASC' ? 'DESC' : 'ASC'; // toggle
    loadData($('#search').val(), $('#gender').val(), $('#class').val(), sort_by, order);
});
</script>

</body>
</html>

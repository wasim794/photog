<?php include 'dbconnect.php';

$cate = $_GET['cate'];
$query = $conn->query("SELECT * FROM subcategory WHERE cate like '%$cate%' order by sub asc");
while($row = $query->fetch_array()) {
	echo "<option value='$row[cid]'>$row[sub]</option>";
}
?>
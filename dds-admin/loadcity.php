<?php include 'dbconnect.php';
echo $state = $_GET['state'];
echo "<option value=' '> Select City</option>";
$query = $conn->query("SELECT * FROM city WHERE state = '$state' order by cities asc");
while($row = $query->fetch_array()) {
	echo "<option value='$row[cities]'>$row[cities]</option>";
}
?>
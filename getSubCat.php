<?php 
include "connect.php";
include "includes/functions/functions.php";
	function user_info(){
		global $conn;
		$q = isset($_GET['q']) && is_numeric($_GET['q']) ? intval($_GET['q']) : 0;

		$stmtSub = $conn->prepare("SELECT * FROM subcategories JOIN categories ON categories.Cat_ID = subcategories.Cat_ID && categories.Cat_ID = ?");

		$stmtSub->execute(array($q));

		$rows = $stmtSub->fetchAll();

		foreach($rows as $row){
			echo "<option value='".$row["subCatId"]."' >".$row["subCatName"]."</option>";
		}
	}

	?>
	<select class="form-control" name="subCatSelect">
		<option>----------Select Sub Categoury----------</option>
		<?php user_info();?>
	</select>


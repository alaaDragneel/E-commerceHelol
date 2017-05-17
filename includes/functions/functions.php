<?php
	/*
	** title function V1.0  that echo the page title in 
	**case the page has variable $pageTitle and echo defult title for other pages
	*/
	/*start function title*/
	function getTitle() {

		global $pageTitle;

		if (isset($pageTitle)) {

			echo $pageTitle;
		} else {

			echo 'Defult';
		}

	}

	/*end function title*/


	/*start check item function V1.0 */

	/*
	**function accept parameters
	** $select = the item to select [Example: user, item]
	** $from = the table to select from [Example: user, item]
	** $value = the value of select 
	*/

	function checkItme($select, $from, $value) {
		global $conn;

		$st = $conn->prepare("SELECT $select FROM $from WHERE $select = ? ");
		$st->execute(array($value));

		$count = $st->rowCount();

		return $count;

	}

	/*end check item function V1.0 */

	/*redirect function start*/

	/*
	** Home Redirect Function[This Function Accept Prameters]V2.0
	** $msg = echo the massage [ error | scusess| warning ]
	** $url = the link that will make redirect
	** $secong = seconds before redirecting
	*/

	function redirect($msg, $url = null, $page = 'home ', $seconds = 3) {

		if ($url === null) {
			$url = 'index.php';
		} else {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

			$url = $_SERVER['HTTP_REFERER'];
			
			} else {
				$url = 'index.php';
			}


		}


			echo $msg;
			//the massage style that will change [ <div class='alert alert-danger' style='font-family: cursive; font-size: 17px;'>$msg<strong></strong></div> ]

			echo "<div class='alert alert-info' style='font-size: 17px; text-align: center; '>you will direct to the $page page after $seconds seconds</div>";
	

		header("refresh: $seconds;url=$url");

		exit();

	}

	/*redirect function end*/


	/* start category function V1.0
	** this function accept parameters
	** $selectname	    => the name of the select
	** $item 			=> the item that will select it 						[ ID | Name of category | Name of product ]
	** $table 			=> the table that will select from it 					[ users | products ]
	** $valueId 		=> the value of the option that get by the loop 		[ ID ]
	** $valueName 		=> the name that shows to the users in the check box 	[ Title | Name ]
	*/
	function comboSelect($selectname, $selectOptionName,$item, $table, $valueId, $valueName, $where='', $more='') {
		//global the connection
		global $conn;
		//start the select the category
		$selectCat = $conn->prepare("SELECT $item FROM $table $where");
		//execute the functuion
		$selectCat->execute();
		//start count
		$count = $selectCat->rowCount();
		if ($count > 0) {
			//start fetch
			$rows  = $selectCat->fetchAll();
			echo'<select onChange="'.$more.'" class="form-control" name="'.$selectname.'"  >';
				echo "<option>-----$selectOptionName-----</option>";
			//start loop
			foreach ($rows as $row) {
				echo "<option value='".$row["$valueId"]."' >".$row["$valueName"]."</option>";
			}
			echo'</select>';
		}
	}

	/* start check item count function V1.0 */
	
	/*
	**function use to count the items rows
	** function use parameter
	** $item = use item to count about it [ users | items ]
	** $table = the required table to count from [ users | product ] 
	*/

	function countItem($item, $table, $value) {
		global $conn;

		$stmt2 = $conn->prepare("SELECT COUNT($item) FROM $table WHERE UserID = ?");

		$stmt2->execute(array($value));

		return $stmt2->fetchColumn();
	}

	/* end check item count function V1.0 */

	/* start check item count function V1.5 */
	
	/*
	**function use to count the items rows
	** function use parameter
	** $item = use item to count about it [ users | items ]
	** $table = the required table to count from [ users | product ] 
	** $rate = the required condition item
	*/

	function countLikes($item, $table, $value, $rate, $pro) {
		global $conn;

		$stmt2 = $conn->prepare("SELECT COUNT($item) FROM $table WHERE $rate = ? && product_id = ?");

		$stmt2->execute(array($value, $pro));

		return $stmt2->fetchColumn().' Times';
	}

	/* end check item count function V1.5 */
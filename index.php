<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="slika_zaposlenici.jpg">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Zaposlenici</title>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>

<body>
	<center><img src="zaposlenici.png" width="200px" /></center>
	<div id="placeHolder">

		
		<center><h2>Lista zaposlenika</h2></center>

		<br>
		<?php
		// Include config file
		require_once 'config.php';

		// Attempt select query execution
		$sql = "SELECT * FROM employees";
		if($result = mysqli_query($link, $sql)){
			if(mysqli_num_rows($result) > 0){
				echo "<table id=read>";
					echo "<thead>";
						echo "<tr>";
							echo "<th>ID</th>";
							echo "<th align=center>Ime i Prezime</th>";
							echo "<th>Adresa</th>";
							echo "<th>Visina plaće</th>";
							echo "<th>Mogućnosti</th>";
						echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					while($row = mysqli_fetch_array($result)){
						echo "<tr>";
							echo "<td>" . $row['id'] . "</td>";
							echo "<td>" . $row['name'] . "</td>";
							echo "<td>" . $row['address'] . "</td>";
							echo "<td>" . $row['salary'] . "</td>";
							echo "<td>";
								echo "<a id=action href='read.php?id=". $row['id'] ."' title='Pogledaj zapis' data-toggle='tooltip'><span>Pogled</span></a>";
								echo "<a id=action href='update.php?id=". $row['id'] ."' title='Ažuriraj zapis' data-toggle='tooltip'><span>Ažuriranje</span></a>";
								echo "<a id=action href='delete.php?id=". $row['id'] ."' title='Izbriši zapis' data-toggle='tooltip'><span>Brisanje</span></a>";
							echo "</td>";
						echo "</tr>";
					}
					echo "</tbody>";                            
				echo "</table>";
				// Free result set
				mysqli_free_result($result);
			} else{
				echo "<center><p><em>No records were found.</em></p></center>";
			}
		} else{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}

		// Close connection
		mysqli_close($link);
		?>
		<br>
		<center>
			<form action="create.php">
				<input type="submit" value="Dodaj novog zaposlenika">
			</form>
		</center>
	</div>
</body>
</html>

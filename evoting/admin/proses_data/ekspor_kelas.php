<?php 

include '../template/database.php';
$getsetting = mysqli_query($koneksi,"SELECT * FROM settings WHERE id_setting=1");
$setting = mysqli_fetch_array($getsetting);
if (isset($_GET['kelas'])) { ?>


	<html>
	<head>
		<title>LIST OF E-VOTING VOTERS</title>
	</head>
	<body>
		<style type="text/css">
			body{
				font-family: sans-serif;
			}
			table{
				margin: 20px auto;
				border-collapse: collapse;
			}
			table th,
			table td{
				border: 1px solid #3c3c3c;
				padding: 3px 8px;

			}
			a{
				background: blue;
				color: #fff;
				padding: 8px 10px;
				text-decoration: none;
				border-radius: 2px;
			}
		</style>

		<?php
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=LIST OF E-VOTING VOTERS.xls");
		?>

		<center>
			<h3>LIST OF E-VOTING VOTERS</h3>
		</center>

		<table border="1">
			<tr>
				<th>No</th>
				<th>Matrix</th>
				<th>Full name</th>
				<th>Faculty</th>
				<th>Access Code</th>
				<th>Status</th>
			</tr>
			<?php 
			
			$facultyId = $_GET['kelas'];
			$getFaculty = mysqli_query($koneksi,"SELECT * FROM voter, faculties WHERE voter.voter_faculty=faculties.faculty_id AND faculties.faculty_id='$facultyId'");

			$no = 1;
			while ($faculty = mysqli_fetch_array($getFaculty)) { ?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo htmlspecialchars($faculty['voter_nis']); ?></td>
					<td><?php echo htmlspecialchars($faculty['voter_name']); ?></td>
					<td><?php echo htmlspecialchars($faculty['faculty_name']); ?></td>
					<td><?php echo htmlspecialchars($faculty['voter_code']); ?></td>
					<td>
						<?php 
						if ($faculty['voter_status'] == 0) {
							echo 'Have not chosen yet';
						}elseif ($faculty['voter_status'] == 1) {
							echo 'Already Chosen';
						} 
						?>
					</td>
				</tr>
			<?php }?>
		</table>
	</body>
	</html>

	<?php } ?>
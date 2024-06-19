<?php
include '../template/database.php';
$getSetting = mysqli_query($koneksi, "SELECT * FROM settings WHERE id_setting=1");
$setting = mysqli_fetch_array($getSetting);

if (isset($_GET['file'])) { ?>

	<?php if ($_GET['file'] == "pdf") {  ?>

		<?php

		$getVoter = mysqli_query($koneksi, "SELECT * FROM voter, faculties WHERE voter.voter_faculty=faculties.faculty_id");

		// memanggil library FPDF
		require('pdf/fpdf.php');
		// intance object dan memberikan pengaturan halaman PDF
		$pdf = new FPDF('P', 'mm', 'A4');
		// membuat halaman baru
		$pdf->AddPage();
		// setting jenis font yang akan digunakan
		$pdf->SetFont('Arial', 'B', 16);
		// mencetak string 
		$pdf->Cell(190, 7, 'LIST OF E-VOTING VOTERS', 0, 1, 'C');

		// Memberikan space kebawah agar tidak terlalu rapat
		$pdf->Cell(10, 7, '', 0, 1);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(10, 10, 'NO', 1, 0);
		$pdf->Cell(25, 10, 'MATRIX', 1, 0);
		$pdf->Cell(60, 10, 'FULL NAME', 1, 0);
		$pdf->Cell(30, 10, 'FACULTY', 1, 0);
		$pdf->Cell(40, 10, 'CODE', 1, 0);
		$pdf->Cell(30, 10, 'STATUS', 1, 1);

		$pdf->SetFont('Arial', '', 10);

		$no = 1;

		while ($row = mysqli_fetch_array($getVoter)) {
			$pdf->Cell(10, 8, $no++, 1, 0);
			$pdf->Cell(25, 8, $row['voter_nis'], 1, 0);
			$pdf->Cell(60, 8, $row['voter_name'], 1, 0);
			$pdf->Cell(30, 8, $row['faculty_name'], 1, 0);
			$pdf->Cell(40, 8, $row['voter_code'], 1, 0);
			if ($row['voter_status'] == 0) {
				$pdf->Cell(30, 8, 'Have not chosen yet', 1, 1);
			} elseif ($row['voter_status'] == 1) {
				$pdf->Cell(30, 8, 'Already Chosen', 1, 1);
			}
		}

		$pdf->Output();
		?>

	<?php } elseif ($_GET['file'] == "excel") { ?>

		<html>

		<head>
			<title>LIST OF E-VOTING VOTERS</title>
		</head>

		<body>
			<style type="text/css">
				body {
					font-family: sans-serif;
				}

				table {
					margin: 20px auto;
					border-collapse: collapse;
				}

				table th,
				table td {
					border: 1px solid #3c3c3c;
					padding: 3px 8px;

				}

				a {
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
					<th>
						Matrix
					</th>
					<th>Full Name</th>
					<th>Faculty</th>
					<th>Access Code </th>
					<th>Status</th>
				</tr>
				<?php

				$getVoter = mysqli_query($koneksi, "SELECT * FROM voter, faculties WHERE voter.voter_faculty=faculties.faculty_id ORDER BY faculties.faculty_name ASC");

				$no = 1;
				while ($voter = mysqli_fetch_array($getVoter)) { ?>
					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo htmlspecialchars($voter['voter_nis']); ?></td>
						<td><?php echo htmlspecialchars($voter['voter_name']); ?></td>
						<td><?php echo htmlspecialchars($voter['faculty_name']); ?></td>
						<td><?php echo htmlspecialchars($voter['voter_code']); ?></td>
						<td>
							<?php
							if ($voter['voter_status'] == 0) {
								echo 'Have not chosen yet';
							} elseif ($voter['voter_status'] == 1) {
								echo 'Already Chosen';
							}
							?>
						</td>
					</tr>
				<?php } ?>
			</table>
		</body>

		</html>

	<?php } ?>

<?php } ?>
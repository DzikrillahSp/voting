<?php if (isset($_GET['file'])) { ?>

	<?php if ($_GET['file'] == "pdf") {  ?>

		<?php
		include '../template/database.php';
		$getSetting = mysqli_query($koneksi, "SELECT * FROM pengaturan WHERE id_pengaturan=1");
		$setting = mysqli_fetch_array($getSetting);
		$getVoter = mysqli_query($koneksi, "SELECT count(id_pemilih) AS jumlah_pemilih FROM pemilih");
		$voter = mysqli_fetch_array($getVoter);

		$getDoneVoter = mysqli_query($koneksi, "SELECT count(pemilih_status) AS jumlah_sudah FROM pemilih WHERE pemilih_status='1'");
		$done = mysqli_fetch_array($getDoneVoter);
		$getNotYetVoted = mysqli_query($koneksi, "SELECT count(pemilih_status) AS jumlah_belum FROM pemilih WHERE pemilih_status='0'");
		$notYet = mysqli_fetch_array($getNotYetVoted);

		$getVoter = mysqli_query($koneksi, "SELECT * FROM pemilih");
		$voterRows = mysqli_num_rows($getVoter);

		$getCandidate = mysqli_query($koneksi, "SELECT * FROM kandidat");

		// memanggil library FPDF
		require('pdf/fpdf.php');
		// intance object dan memberikan pengaturan halaman PDF
		$pdf = new FPDF('P', 'mm', 'A4');
		// membuat halaman baru
		$pdf->AddPage();
		// setting jenis font yang akan digunakan
		$pdf->SetFont('Arial', 'B', 16);
		// mencetak string 
		$pdf->Cell(190, 7, 'E-VOTING RECAPITULATION RESULTS', 0, 1, 'C');

		// Memberikan space kebawah agar tidak terlalu rapat
		$pdf->Cell(10, 7, '', 0, 1);

		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(140, 10, 'CANDIDATE NAME', 1, 0);
		$pdf->Cell(50, 10, 'NUMBER OF VOTES', 1, 1);

		$pdf->SetFont('Arial', '', 10);
		$candidateRows = mysqli_num_rows($getCandidate);

		if ($candidateRows != "") {
			while ($row = mysqli_fetch_array($getCandidate)) {
				$candidateId = $row['id_kandidat'];
				$getVotes = mysqli_query($koneksi, "SELECT count(suara_id_kandidat) AS jumlah_suara FROM suara_pemilih WHERE suara_id_kandidat='$candidateId'");
				$votes = mysqli_fetch_array($getVotes);

				$pdf->Cell(140, 8, $row['kandidat_nama'], 1, 0);
				$pdf->Cell(50, 8, $votes['jumlah_suara'], 1, 1);
			}
		}

		$pdf->Cell(140, 8, "", 0, 0);
		$pdf->Cell(50, 8, "", 0, 1);

		if ($voterRows != "") {
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(140, 8, "Total Number of Voters", 1, 0);
			$pdf->Cell(50, 8, $voter['jumlah_pemilih'], 1, 1);


			$persentasi = round($done['jumlah_sudah'] / $voter['jumlah_pemilih'] * 100, 2);
			$valid = "" . $persentasi . "% (" . $done['jumlah_sudah'] . " Suara)";
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(140, 8, "Number of Valid Votes", 1, 0);
			$pdf->Cell(50, 8, $valid, 1, 1);

			$persen = round($notYet['jumlah_belum'] / $voter['jumlah_pemilih'] * 100, 2);
			$Unused = "" . $persen . "% (" . $notYet['jumlah_belum'] . " Suara)";
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(140, 8, "Number of Unused Votes", 1, 0);
			$pdf->Cell(50, 8, $Unused, 1, 1);
		}
		$pdf->Output();
		?>


	<?php } elseif ($_GET['file'] == "excel") { ?>

		<html>

		<head>
			<title>E-VOTING RECAPITULATION RESULTS</title>
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
			header("Content-Disposition: attachment; filename=E-VOTING RECAPITULATION RESULTS.xls");
			?>

			<center>
				<h3>E-VOTING RECAPITULATION RESULTS</h3>
			</center>

			<table border="1">
				<tr>
					<th>Candidate Name</th>
					<th width="20%">Number of Votes</th>
				</tr>
				<?php
				include '../template/database.php';

				$getVoter = mysqli_query($koneksi, "SELECT count(id_pemilih) AS jumlah_pemilih FROM pemilih");
				$voter = mysqli_fetch_array($getVoter);

				$getDoneVoter = mysqli_query($koneksi, "SELECT count(pemilih_status) AS jumlah_sudah FROM pemilih WHERE pemilih_status='1'");
				$done = mysqli_fetch_array($getDoneVoter);
				$getNotYetVoted = mysqli_query($koneksi, "SELECT count(pemilih_status) AS jumlah_belum FROM pemilih WHERE pemilih_status='0'");
				$notYet = mysqli_fetch_array($getNotYetVoted);

				$getCandidate = mysqli_query($koneksi, "SELECT * FROM kandidat");
				$candidateRows = mysqli_num_rows($getCandidate);

				$getVoter = mysqli_query($koneksi, "SELECT * FROM pemilih");
				$voterRows = mysqli_num_rows($getVoter);

				if ($candidateRows != "") {
					while ($kandidat = mysqli_fetch_array($getCandidate)) {

						$id_kandidat = $kandidat['id_kandidat'];
						$getVotes = mysqli_query($koneksi, "SELECT count(suara_id_kandidat) AS jumlah_suara FROM suara_pemilih WHERE suara_id_kandidat='$id_kandidat'");
						$voted = mysqli_fetch_array($getVotes);
				?>
						<tr>
							<td><?php echo htmlspecialchars($kandidat['kandidat_nama']); ?></td>
							<td>
								<?php echo htmlspecialchars($voted['jumlah_suara']); ?>
							</td>
						</tr>
				<?php }
				} ?>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<?php if ($voterRows != "") { ?>
					<tr>
						<td><b> Total Number of Voters</b></td>
						<td>
							<?php echo $pemilih['jumlah_pemilih']; ?>
						</td>
					</tr>
					<tr>
						<td><b> Number of Valid Votes</b></td>
						<td>
							<?php
							$persentasi = round($done['jumlah_sudah'] / $voter['jumlah_pemilih'] * 100, 2);
							echo $persentasi;
							?>% <?php echo "(" . $done['jumlah_sudah'] . " Suara)" ?>
						</td>
					</tr>
					<tr>
						<td><b> Number of Unused Votes</b></td>
						<td>
							<?php
							$persentasi = round($notYet['jumlah_belum'] / $voter['jumlah_pemilih'] * 100, 2);
							echo $persentasi;
							?>% <?php echo "(" . $notYet['jumlah_belum'] . " Suara)" ?>
						</td>
					</tr>
				<?php } ?>
			</table>
		</body>

		</html>

	<?php } ?>

<?php } ?>
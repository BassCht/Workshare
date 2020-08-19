<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Home</title>
		<?php include 'head.php'; ?>
	</head>
	<body>
		<?php include 'navbar.php'; ?>
		<div class="container">
			<table>
				<tr>
					<th>Date</th>
					<th>User</th>
					<th>Work</th>
					<th>Status</th>
				</tr>
				<?php
					if (isset($work_list)) {
						foreach ($work_list as $val) {
							if($val->status == 1) {
								$status = '<span style="color:red;">To do</span>';
							} else if($val->status == 2) {
								$status = '<span style="color:green;">Done</span>';
							}
				?>
							<tr>
								<td><?=$val->date_created;?></td>
								<td><a href="<?php echo base_url('account/detail?id=').$val->user_id ?>"><?=$val->username;?></a></td>
								<td><?=$val->work_detail;?></td>
								<td><?=$status;?></td>
							</tr>
				<?php
						}
					} else {
				?>
					<tr>
						<td colspan="4" style="text-align:center;color:red;">No Data</td>
					</tr>
				<?php
					}
				?>
			</table>
		</div>
		<?php include 'foot.php'; ?>
	</body>
</html>
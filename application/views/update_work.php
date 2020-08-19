<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Update Work</title>
		<?php include 'head.php'; ?>
	</head>
	<body>
        <?php include 'navbar.php'; ?>
		<div class="container">
            <div class="w-100 head-bar">
                <button id="clear-work" class="btn">CLEAR</button>
            <div>
            <table id="update-work">
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
								$checked = '';
							} else if($val->status == 2) {
								$checked = 'checked';
							}
				?>
							<tr>
								<td><?=$val->date_created;?></td>
								<td><?=$val->username;?></td>
								<td><?=$val->work_detail;?></td>
								<td>
                                    To do
                                    <label class="switch">
                                        <input type="checkbox" w-id="<?=$val->work_id;?>" <?=$checked;?>>
                                        <span class="slider round"></span>
                                    </label>
                                    Done
                                </td>
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
        <script>
            $('#update-work :checkbox').change(function() {
                var work_id = $(this).attr('w-id');
                var status = 1;
                if (this.checked) {
                    status = 2;
                }
                $.ajax({
                    method: "POST",
                    url: '<?php echo base_url("work/update_work_status/")?>',
                    data: { 
                        work_id: parseInt(work_id),
                        status: status
                    },
                    dataType: "json"
                }).done(function(data) {
                    // console.log("Return data :", data);
                });
            });

            $("#clear-work").on( "click", function() {
                if (confirm("ต้องการล้างข้อมูลหรือไม่ ?")) {
                    $.ajax({
                        method: "POST",
                        url: '<?php echo base_url("work/clear_work/")?>',
                        data: {},
                        dataType: "json"
                    }).done(function(data) {
                        // console.log("Return data :", data);
                        if(data != 0){
                            location.reload();
                        }else{
                            alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                        }
                    });
                }
            });

        </script> 
	</body>
</html>
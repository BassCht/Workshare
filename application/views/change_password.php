<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Change Password</title>
		<?php include 'head.php'; ?>
	</head>
	<body>
        <?php include 'navbar.php'; ?>
		<div class="container">
            <div class="row">
                <?php include 'account_menu.php' ?>
                <div class="col-8 col-md-8">
                    <div class="profile col-content">
                        <h1>Change Password</h1>
                            <div class="form-group">
                                <input type="password" class="form-control" id="old-pass" placeholder="Old Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="new-pass" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="confirm-pass" placeholder="Confirm Password">
                            </div>
                            <button id="save" class="">SAVE</button>
                            <button id="cancel" class="" onclick="goToHome()">CANCEL</button>
                    </div>
                </div>
            </div>
		</div>
		<?php include 'foot.php'; ?>
        <script>
            function goToHome() {
                location.href = '<?php echo base_url('account')?>';
            }
            $("#save").on( "click", function() {
                var old_pass = $('#old-pass').val();
                var new_pass = $('#new-pass').val();
                var confirm_pass = $('#confirm-pass').val();

                if(new_pass != confirm_pass){
                    $.notify("รหัสผ่านไม่ตรงกัน", "error");
                }else{
                    $.ajax({
                        method: "POST",
                        url: '<?php echo base_url("account/update_password/")?>',
                        data: { 
                            old_pass: old_pass,
                            new_pass: new_pass
                        },
                        dataType: "json"
                    }).done(function(data) {
                        console.log("Return data :", data);
                        if(data == 1){
                            $.notify("เปลี่ยนรหัสผ่านเรียบร้อย", "success");
                            $('.profile input').val('');
                        }else if(data == 2) {
                            $.notify("รหัสผ่านเดิมไม่ถูกต้อง", "error");
                        } else {
                            $.notify("เกิดข้อผิดพลาดในการอัพเดทข้อมูล", "error");
                        }
                    });
                }
            });
        </script> 
	</body>
</html>
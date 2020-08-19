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
                          
                        <button id="save" class="hidden">SAVE</button>
                        <button id="cancel" class="hidden">CANCEL</button>
                    </div>
                </div>
            </div>
		</div>
		<?php include 'foot.php'; ?>
        <script>
            // $("#save").on( "click", function() {
            //     var username = $('.data-input.username').val();
            //     var fullname = $('.data-input.fullname').val();
            //     var tel = $('.data-input.tel').val();
            //     $.ajax({
            //         method: "POST",
            //         url: '<?php echo base_url("account/update_profile/")?>',
            //         data: { 
            //             username: username,
            //             fullname: fullname,
            //             tel: tel,
            //         },
            //         dataType: "json"
            //     }).done(function(data) {
            //         // console.log("Return data :", data);
            //         if(data != 0){
            //             $('.data-txt.username').text(username);
            //             $('.data-txt.fullname').text(fullname);
            //             $('.data-txt.tel').text(tel);
            //             $('.data-input.username').val(username);
            //             $('.data-input.fullname').val(fullname);
            //             $('.data-input.tel').val(tel);

            //             $('#save').addClass('hidden');
            //             $('#cancel').addClass('hidden');
            //             $("#edit-profile").removeClass('hidden');
            //             $('.data-txt').removeClass('hidden');
            //             $('.data-input').addClass('hidden');
            //         }else{
            //             alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            //         }
            //     });
            // });
        </script> 
	</body>
</html>
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
            <div class="row">
                <?php include 'account_menu.php' ?>
                <div class="col-8 col-md-8">
                    <div class="profile col-content">
                        <h1>My Profile</h1>
                        <?php
                            if(isset($userdata)){
                                foreach($userdata as $val){
                                    $username = $val->username;
                                    $fullname = $val->fullname;
                                    $tel = $val->tel;
                                    $img_name = $val->img_name;
                                }

                                $imgpath = base_url('assets/images/no-image.jpg');
                                if($img_name != '' || $img_name != NULL){
                                    $imgpath = base_url('uploads/'.$img_name);
                                }
                        ?>
                            <div>
                                <div>
                                    <img id="user-img" src="<?=$imgpath?>">
                                </div>
                                <form id="upload-form" method="post" enctype="multipart/form-data" class="hidden" style="margin-top: 5px;">
                                    <input type="file" name="userfile">
                                    <button id="save-upload" type="button">UPLAOD</button>
                                    <button id="cancel-upload" type="button">CANCEL</button>
                                </form>
                                <button id="edit-img" style="margin-top: 5px;">EDIT</button>
                            </div>
                            <table id="profile-information">
                                <tr>
                                    <td class="left">Username :</td>
                                    <td>
                                        <span class="data-txt username"><?=$username?></span>
                                        <input class="form-control data-input username hidden" value="<?=$username?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="left">Full Name :</td>
                                    <td>
                                        <span class="data-txt fullname"><?=$fullname?></span>
                                        <input class="form-control data-input fullname hidden" value="<?=$fullname?>">
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="left">Tel :</td>
                                    <td>
                                        <span class="data-txt tel"><?=$tel?></span>
                                        <input class="form-control data-input tel hidden" value="<?=$tel?>">
                                    </td>
                                </tr>
                            </table>
                        <?php
                            }else{
                               echo '<h5>Can not get your data</h5>'; 
                            }
                        ?>
                        
                        <button id="edit-profile">EDIT PROFILE</button>
                        <button id="save" class="hidden">SAVE</button>
                        <button id="cancel" class="hidden">CANCEL</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'foot.php'; ?>
        <script>
            function stripHtml(html) {
                var tmp = document.createElement("DIV");
                tmp.innerHTML = html;
                return tmp.textContent || tmp.innerText || "";
            }

            $("#edit-profile").on( "click", function() {
                $('.data-txt').addClass('hidden');
                $('.data-input').removeClass('hidden');
                $(this).addClass('hidden');
                $('#save').removeClass('hidden');
                $('#cancel').removeClass('hidden');
            });

            $("#cancel").on( "click", function() {
                $(this).addClass('hidden');
                $('#save').addClass('hidden');
                $("#edit-profile").removeClass('hidden');
                $('.data-txt').removeClass('hidden');
                $('.data-input').addClass('hidden');
            });
            
            $("#save").on( "click", function() {
                var username = $('.data-input.username').val();
                var fullname = $('.data-input.fullname').val();
                var tel = $('.data-input.tel').val();
                $.ajax({
                    method: "POST",
                    url: '<?php echo base_url("account/update_profile/")?>',
                    data: { 
                        username: username,
                        fullname: fullname,
                        tel: tel,
                    },
                    dataType: "json"
                }).done(function(data) {
                    // console.log("Return data :", data);
                    if(data != 0){
                        $.notify("แก้ไขข้อมูลเรียบร้อย", "success");
                        $('#nav-username').text(username);
                        $('.data-txt.username').text(username);
                        $('.data-txt.fullname').text(fullname);
                        $('.data-txt.tel').text(tel);
                        $('.data-input.username').val(username);
                        $('.data-input.fullname').val(fullname);
                        $('.data-input.tel').val(tel);

                        $('#save').addClass('hidden');
                        $('#cancel').addClass('hidden');
                        $("#edit-profile").removeClass('hidden');
                        $('.data-txt').removeClass('hidden');
                        $('.data-input').addClass('hidden');
                    }else{
                        $.notify("เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง", "error");
                    }
                });
            });

            $("#edit-img").on( "click", function() {
                $(this).addClass('hidden');
                $('#upload-form').removeClass('hidden');
            });

            $("#cancel-upload").on( "click", function() {
                $("#edit-img").removeClass('hidden');
                $('#upload-form').addClass('hidden');
            });

            $("#save-upload").click(function(event) {
                event.preventDefault();
                var form_data = new FormData($('#upload-form')[0]);
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url('Account/upload_profile_image'); ?>",
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if(res){
                            var obj = JSON.parse(res);
                            // console.log(obj);
                            if (typeof obj.error !== 'undefined') {
                                $.notify(stripHtml(obj.error), "error");
                            }
                            if (typeof obj.done !== 'undefined') {
                                $.notify("อัพเดทรูปภาพเรียบร้อย", "success");
                                var new_img = "<?php echo base_url('uploads/'); ?>"+obj.done.file_name;
                                $('#user-img').attr('src', new_img);
                                $('#edit-img').removeClass('hidden');
                                $('#upload-form').addClass('hidden');
                            }
                        }
                    }
                }); 
            });

        </script> 
	</body>
</html>
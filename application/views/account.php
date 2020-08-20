<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Home</title>
		<?php include 'head.php'; ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
	</head>
	<body>
        <?php include 'navbar.php'; ?>
		<div class="container">
            <div class="row">
                <?php include 'account_menu.php' ?>
                <div class="col-8 col-md-8">
                    <div class="profile col-content">
                        <h1 style="width:100%;">My Profile</h1>
                        <div class="row">
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
                            <div class="col-left">
                                <div>
                                    <img id="user-img" src="<?=$imgpath?>">
                                    <div id="preview-crop-image" class="hidden"></div>
                                </div>
                                <button class="edit-img" data-toggle="modal" data-target="#uploadModal">EDIT</button>
                                <!-- Modal -->
                                <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">                    
                                                    <div class="col-md-6 text-center">
                                                        <div id="upload-demo"></div>
                                                    </div>
                                                    <div class="col-md-6" style="padding:5%;">
                                                        <strong>Select image to crop:</strong>
                                                        <input type="file" id="image">
                                                        <button class="btn btn-success btn-block btn-upload-image" style="margin-top:2%">Upload Image</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                            </div>
                            <div class="col-right">
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
                                <div class="tools-bottom">
                                    <button id="edit-profile">EDIT PROFILE</button>
                                    <button id="save" class="hidden">SAVE</button>
                                    <button id="cancel" class="hidden">CANCEL</button>
                                </div>
                            </div>
                        </div>
                        <?php
                            }else{
                               echo '<h5>Can not get your data</h5>'; 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'foot.php'; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
        <script>
            function stripHtml(html) {
                var tmp = document.createElement("DIV");
                tmp.innerHTML = html;
                return tmp.textContent || tmp.innerText || "";
            }

            var resize;
            function createCroppie() {
                resize = $('#upload-demo').croppie({
                    enableExif: true,
                    enableOrientation: true,    
                    viewport: { 
                        width: 200,
                        height: 200,
                        type: 'circle' //square
                    },
                    boundary: {
                        width: 300,
                        height: 300
                    }
                });
            }
            createCroppie();

            $('#image').on('change', function () { 
            var reader = new FileReader();
                reader.onload = function (e) {
                resize.croppie('bind',{
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('.btn-upload-image').on('click', function (ev) {
                resize.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (img) {
                    if( $('#uploadModal #image').val() == '' ) {
                        $.notify("กรุณาเลือกรูปภาพก่อนทำการอัพโหลด", "error");
                        $('#upload-demo').croppie('destroy');
                        createCroppie();
                    }else{
                        $.ajax({
                            url: "<?php echo base_url('account/upload_crop_image'); ?>",
                            type: "POST",
                            data: {"image":img},
                            success: function (data) {
                                console.log(data);
                                if(data == 'done'){
                                    html = '<img src="' + img + '" />';
                                    $("#preview-crop-image").html(html);
                                    $.notify("อัพเดทรูปภาพเรียบร้อย", "success");
                                    $('#user-img').addClass('hidden');
                                    $('#preview-crop-image').removeClass('hidden');
                                    $('#uploadModal').modal('toggle');

                                    $('#uploadModal #image').val('');
                                    $('#upload-demo').croppie('destroy');
                                    createCroppie()
                                    
                                    resize.croppie('bind', {
                                        url : ''
                                    }).then(function () {
                                        console.log('reset complete');
                                    });
                                }else{
                                    $.notify("เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง", "error");
                                }
                            }
                        });
                    }
                });
            });

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

        </script> 
	</body>
</html>
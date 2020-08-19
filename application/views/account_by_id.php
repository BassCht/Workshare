<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Profile Detail</title>
		<?php include 'head.php'; ?>
	</head>
	<body>
        <?php include 'navbar.php'; ?>
		<div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="profile col-content">
                        <h1>Profile Detail</h1>
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
                            </div>
                            <table id="profile-information">
                                <tr>
                                    <td class="left">Username :</td>
                                    <td>
                                        <span class="data-txt username"><?=$username?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="left">Full Name :</td>
                                    <td>
                                        <span class="data-txt fullname"><?=$fullname?></span>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="left">Tel :</td>
                                    <td>
                                        <span class="data-txt tel"><?=$tel?></span>
                                    </td>
                                </tr>
                            </table>
                        <?php
                            }else{
                               echo '<h5>Can not get data</h5>'; 
                            }
                        ?>
                    </div>
                    <a href="<?=base_url()?>">Back</a>
                </div>
            </div>
        </div>
        <?php include 'foot.php'; ?>
        <script>

        </script> 
	</body>
</html>
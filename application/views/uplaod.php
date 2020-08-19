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
            <form method="post" action="<?=base_url('upload/do_upload')?>" enctype="multipart/form-data">
                <input type="file" id="img-file" name="img-file" style="margin-bottom: 10px;">
                <br>
                <input type="submit" value="Upload Image">
            </form>
            <?php
                if(isset($error)){
                    // print_r($error);
                    echo '<span style="color:red;font-size:12px;">'.$error.'</span>';
                }
                if(isset($image_metadata)){
                    // print_r($image_metadata);
                    echo '<span style="color:green;font-size:12px;">Upload success</span>';
                }
            ?>
		</div>
		<?php include 'foot.php'; ?>
	</body>
</html>
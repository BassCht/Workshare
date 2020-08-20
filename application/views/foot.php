<script src="<?php echo base_url('assets/jquery/jquery-3.5.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-4.4.1/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/notify/notify.min.js'); ?>"></script>
<script>
    $.ajax({
        method: "GET",
        url: '<?php echo base_url("account/get_prfile_img/")?>',
        dataType: "json"
    }).done(function(data) {
        var stringified = JSON.stringify(data);
        var parsedObj = JSON.parse(stringified);
        
        console.log("Return data :", parsedObj);
        var pimg = '<?php echo base_url(); ?>'+'uploads/'+parsedObj[0].img_name;
        $('#nav-user-img').attr('src', pimg);
    });
</script>
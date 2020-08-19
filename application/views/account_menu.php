<div class="col-4 col-md-4">
    <ul class="account-menu">
        <a href="<?=base_url('account')?>">
            <li class="<?php echo $this->subactive == 'profile' ? "active" : '' ?>">My Profile</li>
        </a>
        <a href="<?=base_url('account/changepassword')?>">
            <li class="<?php echo $this->subactive == 'changepass' ? "active" : '' ?>">Change Password</li>
        </a>
    </ul>
</div>
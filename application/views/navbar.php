<nav id="main-nav" class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item <?php echo $this->active == 'home' ? "active" : '' ?>">
            <a class="nav-link" href="<?php echo base_url(); ?>">home</a>
        </li>
        <?php if(isset($_SESSION['user_id'])) { ?>
        <li class="nav-item <?php echo $this->active == 'addwork' ? "active" : '' ?>">
            <a class="nav-link" href="<?php echo base_url('work'); ?>">add work</a>
        </li>
        <li class="nav-item <?php echo $this->active == 'updatework' ? "active" : '' ?>">
            <a class="nav-link" href="<?php echo base_url('work/update'); ?>">update work</a>
        </li>
        <li class="nav-item <?php echo $this->active == 'account' ? "active" : '' ?>">
            <a class="nav-link" href="<?php echo base_url('account'); ?>">profile</a>
        </li>
        <?php } ?>
    </ul>
</nav>
<nav id="user-nav" class="navbar navbar-expand-sm bg-light navbar-light">
    <ul class="navbar-nav">
        <?php if(!isset($_SESSION['user_id'])) { ?>
        <li class="nav-item">
        </li>
        <li class="nav-item <?php echo $this->active == 'login' ? "active" : '' ?>">
            <a class="nav-link login" href="<?php echo base_url('login'); ?>">login</a>
        </li>
        <?php } else { ?>
        <li class="nav-item">
           <img id="nav-user-img"><b id="nav-username"><?php echo $_SESSION['username'];?></b>
        </li>
        <li class="nav-item">
            <a class="nav-link logout" href="<?php echo base_url('login/logout'); ?>">logout</a>
        </li>
        <?php } ?>
    </ul>
</nav>


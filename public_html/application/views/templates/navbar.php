<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
			<nav id="navbar-main" class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="<?php echo base_url(); ?>">Tutor Center</a>
					</div>
					<ul class="nav navbar-nav">
						<li <?php if ($active === 0) echo 'class="active"';?>><a href="<?php echo base_url(); ?>"><i class="glyphicon glyphicon-home"> Home</i></a></li>
						<li <?php if ($active === 1) echo 'class="active"';?>><a href="<?php echo base_url(); ?>Guest/subjects"><i class="glyphicon glyphicon-list-alt"> Subjects</i></a></li>
						<li <?php if ($active === 7) echo 'class="active"';?>><a href="<?php echo base_url(); ?>Guest/posts"><i class="glyphicon glyphicon-tower"> Posts</i></a></li>
            <li <?php if ($active === 2) echo 'class="active"';?>><a href="<?php echo base_url(); ?>Guest/tutors"><i class="glyphicon glyphicon-education"> Tutors</i></a></li>
                                                <?php if (isset($this->session->actor) && $this->session->actor->getRawRank() == Rank::Administrator)
                                                      {
                                                        echo '<li '; if ($active === 5) echo 'class="active"'; echo '>';
                                                        echo '<a href="'; echo base_url(); echo 'Guest/users"><i class="glyphicon glyphicon-user"> Users</i></a></li>';
                                                      }
                                                ?>
                                                <li <?php if ($active === 3) echo 'class="active"';?>><a href="<?php echo base_url(); ?>Guest/library"><i class="glyphicon glyphicon-briefcase"> Library</i></a></li>
						<li <?php if ($active === 4) echo 'class="active"';?>><a href="<?php echo base_url(); ?>Guest/about"><i class="glyphicon glyphicon-info-sign"> About</i></a></li>
                                                <?php if (isset($this->session->actor) && $this->session->actor->getRawRank() >= Rank::Moderator)
                                                      {
                                                        echo '<li '; if ($active === 6) echo 'class="active"'; echo '>';
                                                        echo '<a href="'; echo base_url(); echo 'Guest/promotions"><i class="glyphicon glyphicon-arrow-up"> Promotions</i></a></li>';
                                                      }
                                                ?>
					</ul>
				</div>
			</nav>
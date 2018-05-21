<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
			<nav id="navbar-main" class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="index.html">Tutor Center</a>
					</div>
					<ul class="nav navbar-nav">
						<li <?php if ($active === 0) echo 'class="active"';?>><a href="index.html"><i class="glyphicon glyphicon-home"> Home</i></a></li>
						<li <?php if ($active === 1) echo 'class="active"';?>><a href="subjects.html"><i class="glyphicon glyphicon-list-alt"> Subjects</i></a></li>
						<li <?php if ($active === 2) echo 'class="active"';?>><a href="tutors.html"><i class="glyphicon glyphicon-education"> Tutors</i></a></li>
						<li <?php if ($active === 3) echo 'class="active"';?>><a href="library.html"><i class="glyphicon glyphicon-briefcase"> Library</i></a></li>
						<li <?php if ($active === 4) echo 'class="active"';?>><a href="about.html"><i class="glyphicon glyphicon-info-sign"> About</i></a></li>
					</ul>
				</div>
			</nav>
<div class="jumbotron no-padding-bottom text-center text-secondary" style = "background-color:inherit">
<?php if (isset($this->session->actor) && $actor->getId() === $this->session->actor->getId()) { ?>
		<img class="rounded-oval" src="<?php echo base_url().'assets/storage/users/'.$actor->getId().'/avatar.png'; ?>" width="120" height="120" onclick="$('#attach-profile-pic').click();"/>
		<input id="attach-profile-pic" type="file" style="display: none;">
		<script type="text/javascript">
			$("#attach-profile-pic").change(function(event)
			{
				var files = [];
				$.each($("input#attach-profile-pic").prop("files"), function(index, file) { files.push(file); });
				
				if (files.length === 1) changeProfilePic(files[0]);
				//else Alert.New("You must select one file");
			});
		</script>
<?php } else { ?>
		<img class="rounded-oval" src="<?php echo base_url().'assets/storage/users/'.$actor->getId().'/avatar.png'; ?>" width="120" height="120"/>
<?php } ?>
		<p class="font-times-new-roman" style = "font-size : 50px"><?php echo $actor->getFirstName().' '.$actor->getLastName() ?></p>
</div>
<div class = "row">
    <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class = "text-center font-times-new-roman" style="font-size:20px;">
				<?php
				if ($actor->getRawRank() == 2) echo '<h2>About user:</h2>';
                    else if ($actor->getRawRank() == 3) echo '<h2>About tutor:</h2>';
                    else if ($actor->getRawRank() == 4) echo '<h2>About moderator:</h2>';
                    else if ($actor->getRawRank() == 5) echo '<h2>About administrator:</h2>';
				  if ($actor->getDescription() != null)
				  {
					  echo '<p id = "aboutTutor">'.$actor->getDescription().'</p>';
				  }
				  else echo '<br/><br/>';
				if(isset($this->session->actor) && $actor->getId() == $this->session->actor->getId())
				echo '<center><button class = "btn rounded-md btn-info font-rammetto-one" onclick = "aboutPopupFeed.Toggle(0);">Change</button></center>';
				?>
		</div>	
		<div class = "font-md text-center font-times-new-roman">
               
                <?php
                    if ($actor->getRawRank() != 2) echo '<h2>Online tutoring section:</h2>';
                  if ($sections != null)
                  {
                    foreach($sections as $section)
                    {
                       if ($section->getDeleted() == 0)
                       echo '<a href = "'.base_url().'Guest\section\\'.$section->getId().'" class = "btn rounded-md btn-info font-rammetto-one">'.$section->getName().'</a>&nbsp;&nbsp;';  
                    }
                  }
                  else echo '<br/><br/>';
                ?>
		</div>		   
    </div>
    <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 font-times-new-roman text-center" style = "font-size: 25px">
            <?php
               if ($actor->getRawRank() == Rank::User) echo '<h2>User details:</h2>';
                else if ($actor->getRawRank() == Rank::Tutor) echo '<h2>Tutor details:</h2>';
                else if ($actor->getRawRank() == Rank::Moderator) echo '<h2>Moderator details:</h2>';
                else if ($actor->getRawRank() == Rank::Administrator) echo '<h2>Administrator details:</h2>';
            ?>
            <table class = "table table-hover text-center font-times-new-roman " >
               <tr>
                     <td>FirstName: </td>
                         <td><b><?php echo $actor->getFirstName(); ?></b></td>
                   </tr>
                   <tr>
                     <td>LastName:</td>
                         <td><b><?php echo $actor->getLastName(); ?></b></td>
                   </tr>
                   <tr>
                     <td>Email:</td>
                     <td><b><?php echo $actor->getEmail(); ?></b></td>
                   </tr>
                   <tr>
                     <td>BirthDate:</td>
                         <td><b><?php echo $actor->getBirthDate()->format('Y-m-d'); ?></b></td>
                   </tr>
                   <?php 
                    
                      if ($actor->getRawRank() != Rank::Guest && $avg != 0)
                      {
                         echo '<tr>';
                         echo '<td>Completed:</td>';
                         echo '<td><b>'.$degree.'</b></td>';
                         echo '</tr>';
                         
                         echo '<tr>';
                         echo '<td>Degree:</td>';
                         echo '<td>';
                         
                         for($count = 0; $count <= $avg - 1; $count++)
                         { 
                             echo '<span class="glyphicon glyphicon-star text-warning"></span>';
                         }							
                         echo '</td>';
                         echo '</tr>';
                      }
                    ?>

            </table>
            <?php
            if(isset($this->session->actor) && $actor->getId()==$this->session->actor->getId())
            echo '<center><button class = "btn rounded-md btn-info font-rammetto-one" onclick = "detailsPopupFeed.Toggle(0);">Change</button></center>';
            ?>
       </div>					   
</div>    
<div id ="ban" class ="row">
    <div class ="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php
           if (isset($this->session->actor) && $this->session->actor->getRawRank() == Rank::Administrator && $actor->getRawRank() != Rank::Administrator)
           {
              if ($actor->getBanned() == 0)
              {
                echo '<center><button class ="btn rounded-md btn-danger font-rammetto-one" onclick = "banUser('.$actor->getId().')">BAN USER</button></center>';
              }
              else 
              {
                  echo '<center><button class ="btn rounded-md btn-info font-rammetto-one" onclick = "unbanUser('.$actor->getId().')">UNBAN USER</button></center>';
              }
           }
        ?>
    </div>
</div>
<div id = "tutor-review" class = "row">
    <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <table class = "table table-bordered table-striped table-dark">
                 <?php 
                 if ($reviews == null) echo '<br/><br/>';
                 echo '<h2>Tutor-review:</h2>';
                 foreach($reviews as $review)
                 {
                     echo '<tr>';
                     echo '<td style = "width:15%">Degree:<br/>';
                     for($count = 0; $count <= $review->getGrade() - 1; $count++)
                     { 
                        echo '<span class="glyphicon glyphicon-star text-warning"></span>';
                     }
                     echo '<td style = "width: 85%">Comment: '.$review->getDescription().'</td>';
                     echo '</tr>';
                 }
                 ?>                   
           </table>
    </div>
</div>

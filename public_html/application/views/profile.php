<div class="jumbotron no-padding-bottom text-center text-secondary" style = "background-color:inherit">
        <img class="rounded-oval" src="<?php echo base_url().'assets\storage\users\\'.$actor->getId().'\avatar.png'; ?>" width="120" height="120"/>
        <p class="font-times-new-roman" style = "font-size : 50px"><?php echo $actor->getFirstName().' '.$actor->getLastName() ?></p>
</div>
<div class = "row">
     <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12">
	<div class = "font-md text-center font-times-new-roman">
               
                <?php
                    if ($actor->getRawRank() != 2) echo '<h2>Online tutoring section:</h2>';
                  if ($sections != null)
                  {
                    foreach($sections as $section)
                    {
                       echo '<a href = "'.base_url().'Guest\section\\'.$section->getId().'" class = "btn rounded-md btn-info font-rammetto-one">'.$section->getName().'</a>&nbsp;&nbsp;';  
                    }
                  }
                  else echo '<br/><br/>';
                  if ($actor->getRawRank() == 2) echo '<h2>About user:</h2>';
                    else if ($actor->getRawRank() == 3) echo '<h2>About tutor:</h2>';
                    else if ($actor->getRawRank() == 4) echo '<h2>About moderator:</h2>';
                    else if ($actor->getRawRank() == 5) echo '<h2>About administrator:</h2>';
                ?>
	 </div>
        <div class = "text-justify font-times-new-roman">
            <?php
              if ($actor->getDescription() != null)
              {
                  echo '<p id = "aboutTutor">'.$actor->getDescription().'</p>';
              }
              else echo '<br/><br/>';
            ?>
            <center><button class = "btn rounded-md btn-info font-rammetto-one" onclick = "aboutPopupFeed.Toggle(0);">Change</button></center>
        </div>					   
        </div>
      <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 font-times-new-roman text-center" style = "font-size: 25px">
            <?php
               if ($actor->getRawRank() == Rank::User) echo '<h2>About user:</h2>';
                else if ($actor->getRawRank() == Rank::Tutor) echo '<h2>About tutor:</h2>';
                else if ($actor->getRawRank() == Rank::Moderator) echo '<h2>About moderator:</h2>';
                else if ($actor->getRawRank() == Rank::Administrator) echo '<h2>About administrator:</h2>';
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
                         for($count = 0; $count < $avg - 1; $count++)
                         { 
                             echo '<span class="glyphicon glyphicon-star text-warning"></span>';
                         }							
                         echo '</td>';
                         echo '</tr>';
                      }
                    ?>

            </table>
            <center><button class = "btn rounded-md btn-info font-rammetto-one" onclick = "detailsPopupFeed.Toggle(0);">Change</button></center>
       </div>					   
</div>    
<div id = "tutor-review" class = "row">
    <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <table class = "table table-bordered table-striped table-dark">
                 <?php 
                 if ($reviews == null) echo '<br/><br/>';
                 foreach($reviews as $review)
                 {
                     echo '<h2>Tutor-review:</h2>';
                     echo '<tr>';
                     echo '<td style = "width:15%">Degree:<br/>';
                     for($count = 0; $count < $review->getGrade() - 1; $count++)
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

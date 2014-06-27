 
  <div class="container">
      <div class="innerpage pollreg">
        <h1>Create Poll</h1>
        <div class="steppoll">
          <div class="create_poll">Create Poll</div>
          <div class="visibility">Visibility</div>
          <div class="payment">Payment</div>
        </div>
        <div class="filterpage rowmain custinput">
 
 <?php

	$questions = array();
	$setScale =  false;
	$scaleQuestion = false;
	$setNumber = false;
	$singleSet = false;
	$multipleSet = false;
	$scaleQues = 1;
	
	
	$q= 0;
	foreach($completePollDetails as $key=>$value){

			

			if(!isset($questions[$value->question_id])){
				$q++;
				if(count($questions)!=0)
					echo "</div>";
								
				echo "<div class='quescol'>";
				$questions[$value->question_id] = false ;
				echo '<h3>Q'.$q.'&nbsp;'.$value->question.'</h3>';

				
			}	
		
		
		switch($value->type){
	
		
	
		case 'SINGLE':
			
		if(!$singleSet) {
			echo '<ul class="sinlist">';
			$singleSet = true;
		}

			 echo '<li>
                <input type="radio" id="radio-1" checked>
                <label for="radio-1">&nbsp; '.$value->answer.'</label>
              </li>';
			$k = $key+1;
			
			if($key == count($completePollDetails) - 1){ /*
				if($value->allow_text == 'Y'){
						echo '<textarea rows="20" cols="50"></textarea>';
					}*/
				continue; 
			}
			
			if($completePollDetails[$k]->question_id != $value->question_id){ /*
				if($value->allow_text == 'Y'){
					echo '<textarea rows="20" cols="20"></textarea>';
				}	*/	
			}
		
			if($completePollDetails[$k]->question_id != $value->question_id){ 
					$singleSet = false;
					echo '</ul>';
			}

		break;	
		
		
	

		case 'MULTIPLE':
		if(!$multipleSet) {
			echo '<ul class="sinlist">';
			$multipleSet = true;
		}

			 echo '<li>
                <input type="checkbox" id="check-1" checked>
                <label for="check-1">&nbsp; '.$value->answer.'</label>
              </li>';
			$k = $key+1;
			
			if($key == count($completePollDetails) - 1){ /*
				if($value->allow_text == 'Y'){
						echo '<textarea rows="20" cols="50"></textarea>';
					}*/
				continue; 
			}
			
			if($completePollDetails[$k]->question_id != $value->question_id){ /*
				if($value->allow_text == 'Y'){
					echo '<textarea rows="20" cols="20"></textarea>';
				}	*/	
			}
		
			if($completePollDetails[$k]->question_id != $value->question_id){ 
					$multipleSet = false;
					echo '</ul>';
			}
			
		
		break;


		case 'TEXT':
		if($setNumber==true){
			$setNumber = false;
			continue;
		}
		
		if($value->text=='Y'){
		
			echo '<textarea rows="4" cols="50"></textarea>';
		
		}
		else{
			$setNumber = true;
			$k = $key+1;
			
			$start = $value->answer;
			$end = $completePollDetails[$k]->answer;
			echo form_input(array('name'=>'mimmax','placeholder'=>'Enter a value between '.$start.' and '.$end,'class'=>'logininp','style'=>'margin-bottom:30px'));
		
		
		}
		
		
		break;


		case 'SCALE':
		
			if($setScale == true){
				$setScale = false;
				continue;
			}
			if($value->scale_question == NULL){
			

				$setScale = true;
				$k = $key+1;				
				

				$start = $value->answer;				
				$end = $completePollDetails[$k]->answer;

			?>	
				
            <div class="pagination">
              <div class="rangecontent"> <span class="fllef"><?php echo $value->label; ?></span> <span class="flrig"><?php echo $completePollDetails[$k]->label; ?></span>
                <div class="clear"></div>
              </div>
              <ul>
               <?php
				for($i=$start;$i<=$end;$i++){
                echo '<li><a href="#">'.$i.'</a></li>';
				} ?>
              </ul>
            </div>				

				
		<?php		
				
				
				
			}
			else {
				$setScale = true;
				$k = $key+1;
				$start = $value->answer;				
				$end = $completePollDetails[$k]->answer;

			?>
			
			<?php

				$tempkey = $key - 1;
				

			if($tempkey != -1) {		
				if($completePollDetails[$key]->question_id == $completePollDetails[$tempkey]->question_id ){
					$scaleQues++;	
				} else {
						$scaleQues = 1;
				}
			}	
			
				
				
			?>
			
			  <div class="subquecol">
              <h3>Q<?php echo $scaleQues; ?>&nbsp;<?php echo $value->scale_question; ?></h3>
   
              <div class="pagination">
                <div class="rangecontent"> <span class="fllef"><?php echo $value->label; ?></span> <span class="flrig"><?php echo $completePollDetails[$k]->label; ?></span>
                  <div class="clear"></div>
                </div>
                <ul>
				<?php
				for($i=$start;$i<=$end;$i++){
					echo "<li><a href='#'>".$i."</a></li>";
				}				
				?>  
                </ul>
              </div>
            </div>		
			<?php
			}
		break;
	}	
}			
?>
<p><a href="<?php echo $this->config->item('base_url')?>/poll/createPoll/ADD_TYPE/<?php echo $this->uri->segment(4); ?>" class="bluebtn">Back</a></p>
</div>
</div>
		
		
		
		
		

		  
		  
		  


   
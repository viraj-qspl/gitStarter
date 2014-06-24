<script type="text/javascript">
//$(document).on("submit", '#next', function(e)
//{
//    defaultPrevented;
//    
//    var formData = $("#user_registration").serializeArray();
//    var URL = $("#user_registration").attr("action");
//    
//    
//     $.ajax({
//        url: URL,
//        type: 'POST',
//        async: false,
//        success: function(data)
//        {
//            var json = jQuery.parseJSON(data);
//
//            if (json.isSuccessful)
//            {
//                $("#display_questions").replaceWith(json.message);
//            }
//            else
//            {
//                alert("error");
//            }
//        }
//    });
//});

</script>
<!--<div class="innerpage" id="display_questions">
    <h1>First Poll</h1>

    <div class="totalque">
        <strong><span class="totaltxt">Remaining <?php if(isset($qn_count)){ echo $qn_count; } ?>/10</span></strong>
    </div>
    
    <form id="user_registration" method ="post" action="<?php echo $this->config->item('userRegistrationQuestions'); ?>">
    <div>
    <?php if(isset($errorMsg))
    {echo "<font color='red'>".$errorMsg ."</font>";} ?>
    </div>
   
    <?php
    global $cnt;   //Declared global as $cnt variable be used throught the page for setting id's of form element.
    $cnt = 0;
    $q_id = "";
    $field = "";
    
    if (isset($regionObjArr)) { 
        
    $q_id = $regionObjArr['q_id'];
    $field = "region_id";
    ?>
           
    <div class="quescol custinput" id="<?php echo $regionObjArr['q_id']; ?>">
        <h3>Q1. <?php echo $regionObjArr['text']; ?> </h3>
       
        <ul class="sinlist">
        <?php 
        foreach ($regionObjArr['answer'] as $id => $answer) {
            $cnt++; ?>
            <li>
                <input type="radio" id="radio-<?php echo $cnt; ?>" name="region_id" value="<?php echo $answer['ans_id']; ?>">
                <label for="radio-<?php echo $cnt; ?>">&nbsp; <?php echo $answer['ans_text']; ?></label>
                            <input type="hidden" name="country_id" value="<?php // echo $region_obj['country_id']; ?>" />
            </li>
        <?php } ?>
        </ul>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
     </p>
    <?php } ?> 
    
    <?php if(isset($qn_count) && $qn_count != 10) { ?>
     <p>
        <button type="submit" class="bluebtn" id="next">Next</button>
    </p>
    <?php } else {?>
      <p>
        <button type="submit" class="bluebtn" id="done" >Done</button>
    </p>
    <?php } ?>
    </form>
</div>-->

 <div class="middle">
     <div class="container">
 <h1>First Poll</h1>
    
    <div class="totalque">
        <strong><span class="totaltxt">Remaining <?php if(isset($qn_count)){ echo $qn_count; } ?>/10</span></strong>
    </div>
    
    <form id="user_registration" method ="post" action="<?php echo $this->config->item('userRegistrationQuestions'); ?>">
    <div>
    <?php if(isset($errorMsg))
    {echo "<font color='red'>".$errorMsg ."</font>";} ?>    

        
    </div>
   
    <?php
    global $cnt;   //Declared global as $cnt variable be used throught the page for setting id's of form element.
    $cnt = 0;
    $q_id = "";
    $field = "";
                
    if (isset($regionObjArr)) { 
        
    $q_id = $regionObjArr['q_id'];
    $field = "region_id";
    ?>
           
    <div class="quescol custinput" id="<?php echo $regionObjArr['q_id']; ?>">
        <h3>Q1. <?php echo $regionObjArr['text']; ?> </h3>
       
        <ul class="sinlist">
        <?php 
        foreach ($regionObjArr['answer'] as $id => $answer) {
            $cnt++; ?>
            <li>
                <input type="radio" id="radio-<?php echo $cnt; ?>" name="region_id" value="<?php echo $answer['ans_id']; ?>">
                <label for="radio-<?php echo $cnt; ?>">&nbsp; <?php echo $answer['ans_text']; ?></label>
    <!--                        <input type="hidden" name="country_id" value="<?php // echo $region_obj['country_id']; ?>" />-->
            </li>
        <?php } ?>
        </ul>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
     </p>
    <?php } 
    if (isset($provinceObjArr)) {
        $q_id = $provinceObjArr['q_id'];
        $field = "province_id";
    ?>
    <div class="quescol" id="<?php echo $provinceObjArr['q_id']; ?>">
        <h3>Q2. <?php echo $provinceObjArr['text']; ?></h3>
        <p>
            <select class="selmonth" name="province_id">
                <option>Please Select Province</option>
            <?php
                foreach($provinceObjArr['answer'] as $id => $answer){
                    //$cnt++;
                ?>
                <option value="<?php echo $answer['ans_id']; ?>"><?php echo $answer['ans_text']; ?></option>
            <?php } ?>
            </select>
        </p>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
     </p>
    <?php } 
    if (isset($genderObjArr)) {
        $q_id = $genderObjArr['q_id'];
        $field = "gender";
    ?>
    <div class="quescol custinput" id="<?php echo $genderObjArr['q_id']; ?>">
        <h3>3. <?php echo $genderObjArr['text']; ?></h3>
        <ul class="sinlist">
            <?php
            foreach($genderObjArr['answer'] as $id => $answer){
                    $cnt++;
            ?>
            <li>
                <input type="radio" id="radio-<?php echo $cnt; ?>" name="gender" value="<?php echo $answer['ans_id']; ?>">
                <label for="radio-<?php echo $cnt; ?>">&nbsp; <?php echo $answer['ans_text']; ?></label>
            </li>
            <?php } ?>
        </ul>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
     </p>
    <?php } 
    if (isset($dobObjArr)) {
        $q_id = $dobObjArr['q_id'];
        $field = "dob";
        
    ?>
    <div class="quescol" id="<?php echo $dobObjArr['q_id']; ?>">
        <h3>4. <?php echo $dobObjArr['text']; ?></h3>
        <ul class="sinlist">
            <li>
                <select class="selmonth" name="year">
                    <option>Year</option>
                    <option value='1990'>1990</option>
                    <option value='1991'>1991</option>
                    <option value='1992'>1992</option>
                    <option value='1993'>1993</option>
                    <option value='1994'>1994</option>
                </select>
                
                <select class="selmonth" name="month">
                    <option>Month</option>
                    <option value='01'>January</option>
                    <option value='02'>February</option>
                    <option value='03'>March</option>
                    <option value='04'>April</option>
                    <option value='05'>May</option>
                    <option value='06'>June</option>
                    <option value='07'>July</option>
                    <option value='08'>August</option>
                    <option value='09'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                </select>
                
                <select class="selmonth" name="day">
                    <option>Day</option>
                    <option value='01'>01</option>
                    <option value='02'>02</option>
                    <option value='03'>03</option>
                    <option value='04'>04</option>
                    <option value='05'>05</option>
                    <option value='06'>06</option>
                    <option value='07'>07</option>
                    <option value='08'>08</option>
                    <option value='09'>09</option>
                    <option value='10'>10</option>
                    <option value='11'>11</option>
                    <option value='12'>12</option>
                    <option value='13'>13</option>
                    <option value='14'>14</option>
                    <option value='15'>15</option>
                    <option value='16'>16</option>
                    <option value='17'>17</option>
                    <option value='18'>18</option>
                    <option value='19'>19</option>
                    <option value='20'>20</option>
                    <option value='21'>21</option>
                    <option value='22'>22</option>
                    <option value='23'>23</option>
                    <option value='24'>24</option>
                    <option value='25'>25</option>
                    <option value='26'>26</option>
                    <option value='27'>27</option>
                    <option value='28'>28</option>
                    <option value='29'>29</option>
                    <option value='30'>30</option>
                    <option value='31'>31</option>
                </select>
            </li>
        </ul>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
     </p>
    <?php } 
    if (isset($educationObjArr)) {
        $q_id = $educationObjArr['q_id'];
        $field = "education_id";
    ?>
    <div class="quescol custinput" id="<?php echo $educationObjArr['q_id']; ?>">
        <h3>5. <?php echo $educationObjArr['text']; ?> </h3>
        <ul class="sinlist">
           <?php
            foreach($educationObjArr['answer'] as $id => $answer){
                    $cnt++;
            ?>
                <li>
                    <input type="radio" id="radio-<?php echo $cnt; ?>" name="education_id" value="<?php echo $answer['ans_id']; ?>">
                    <label for="radio-<?php echo $cnt; ?>">&nbsp; <?php echo $answer['ans_text']; ?></label>
                </li>
            <?php }  ?>
        </ul>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
     </p>
    <?php }
    if (isset($incomeObjArr)) {
         $q_id = $incomeObjArr['q_id'];
         $field = "income_group_id";
    ?>
    <div class="quescol custinput" id="<?php echo $incomeObjArr['q_id']; ?>">
        <h3>6. <?php echo $incomeObjArr['text']; ?></h3>
        <ul class="sinlist">
            <?php 
            foreach($incomeObjArr['answer'] as $id => $answer){
                    $cnt++;
                ?>
                <li>
                    <input type="radio" id="radio-<?php echo $cnt; ?>" name="income_group_id" value="<?php echo $answer['ans_id']; ?>">
                    <label for="radio-<?php echo $cnt; ?>">&nbsp; <?php echo $answer['ans_text']; ?></label>
                </li>
            <?php } ?>
        </ul>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
     </p>
    <?php } 
    if (isset($jobFucntionObjArr)) {
         
        $q_id = $jobFucntionObjArr['q_id'];
        $field = "job_function_id";
    ?>
    <div class="quescol custinput" id="<?php echo $jobFucntionObjArr['q_id']; ?>">
        <h3>7. <?php echo $jobFucntionObjArr['text']; ?></h3>
        <p>
            <select class="selmonth" name="job_function_id">
                <option>Please Select Job Function</option>
                
                <?php foreach($jobFucntionObjArr['answer'] as $id => $answer){
                    $cnt++;
                ?>
                
                <option value="<?php echo $answer['ans_id']; ?>"><?php echo $answer['ans_text']; ?></option>
                
                <?php } ?>
            </select>
        </p>
        <?php }
//        if (isset($jobStatusObjArr)) {
//              $q_id = $jobStatusObjArr['q_id'];
//              $field = "job_status";
        
        if(isset($jobFucntionObjArr['subQuestions'])){
            $sub_field = "job_status_id";
        ?>
        <p>
            <!--<input type="hidden" name="job_status_id" value="<?php echo $jobFucntionObjArr['subQuestions']['subQ_id']; ?>"/>-->
            <strong><?php echo $jobFucntionObjArr['subQuestions']['text']; ?></strong></p>
        <ul class="sinlist">
            <?php 
           foreach($jobFucntionObjArr['subQuestions']['answer'] as $id => $answer){
                    $cnt++;
                ?>
                <li>
                    <input type="radio" id="radio-<?php echo $cnt; ?>" name="job_status_id" value="<?php echo $answer['ans_id']; ?>">
                    <label for="radio-<?php echo $cnt; ?>">&nbsp; <?php echo $answer['ans_text']; ?></label>
                </li>
            <?php } ?>
        </ul>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
          <input type="hidden" name="sub_field" value="<?php echo $sub_field; ?>"/>
     </p>
    <?php }
    if (isset($relationshipStatusObjArr)) {
         $q_id = $relationshipStatusObjArr['q_id'];
         $field = "relationship_id";
    ?>
    <div class="quescol custinput" id="<?php echo $relationshipStatusObjArr['q_id']; ?>">
        <h3>8. <?php echo $relationshipStatusObjArr['text']; ?></h3>
        <ul class="sinlist">
            <?php 
                foreach($relationshipStatusObjArr['answer'] as $id => $answer){
                    $cnt++;
                ?>
                <li>
                    <input type="radio" id="radio-<?php echo $cnt; ?>" name="relationship_id" value="<?php echo $answer['ans_id']; ?>">
                    <label for="radio-<?php echo $cnt; ?>">&nbsp; <?php echo $answer['ans_text']; ?></label>
                </li>
            <?php } ?>
        </ul>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
     </p>
    <?php }
    if (isset($familyStatusObjArr)) {
        $q_id = $familyStatusObjArr['q_id'];
        $field = "family_status_id";
    ?>
    <div class="quescol custinput" id="<?php echo $familyStatusObjArr['q_id']; ?>" >
        <h3>9. <?php echo $familyStatusObjArr['text']; ?></h3>
        <ul class="sinlist">
           <?php 
                foreach($familyStatusObjArr['answer'] as $id => $answer){
                    $cnt++;
                ?>
                <li>
                    <input type="radio" id="radio-<?php echo $cnt; ?>" name="family_status_id" value="<?php echo $answer['ans_id']; ?>">
                    <label for="radio-<?php echo $cnt; ?>">&nbsp; <?php echo $answer['ans_text']; ?></label>
                </li>
            <?php } ?>
        </ul>
    </div>
     <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
     </p>
    <?php } if (isset($interestObjArr)) {
           $q_id = $interestObjArr['q_id'];
           $field = "interest_id";
    ?>    
    <div class="quescol custinput" id="<?php echo $interestObjArr['q_id']; ?>">
        <h3>10. <?php echo $interestObjArr['text']; ?> </h3>
        <ul class="sinlist">
            <?php foreach($interestObjArr['answer'] as $id => $answer){ ?>
            <li><?php echo $id  . " " . count($answer); ?></li>
            <?php
                foreach($answer as $sub_interest){
                $cnt++;
            ?>
            <li>
                <input type="checkbox" id="check-<?php echo $cnt; ?>" name="interest_id[]" value="<?php echo $sub_interest['ans_id']; ?>">
                <label for="check-<?php echo $cnt; ?>">&nbsp; <?php echo $sub_interest['ans_text']; ?></label>
                
            </li>
            <?php } } ?>
        </ul>
    </div>
    <p>
          <input type="hidden" name="q_id" value="<?php echo $q_id; ?>"/>
          <input type="hidden" name="field" value="<?php echo $field; ?>"/>
    </p>
    <?php } if(isset($qn_count) && $qn_count != 10) { ?>
    <p>
        <button type="submit" class="bluebtn" id="next">Next</button>
    </p>
    <?php } else {?>
    <p>
        <button type="submit" class="bluebtn" id="done" >Done</button>
    </p>
    <?php } ?>
    </form>
     </div>
 </div>
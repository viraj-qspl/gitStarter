
<div class="middle">
    <div class="container">
        <div class="innerpage pollpage">
            <h1>First Poll</h1>
            <p><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/pollimg.jpg" alt=""></p>
            <h2>First poll title</h2>
            <p><span class="graytxt">Total number of questions in this poll: 10</span></p>
            <p>The first Poll is to capture your basic profile details.<br>
                Here goes Poll description… Here goes Poll description…Here goes Poll description… Here goes Poll description… Here goes Poll description… Here goes Poll description… Here goes Poll description…</p>
            
            <?php if(!isset($last_question_answered)){ $last_question_answered = "1"; } ?>
            <p><a href="<?php echo $this->config->item('userRegistrationQuestions').'/'.$last_question_answered; ?>" class="bluebtn">Show Questions</a></p>
 
        </div>
    </div>
</div>
 <div class="middle">
     <div class="container">
<div class="innerpage pollreg">
    <div class="regtitle">Registration Successful</div>
    <p><span class="midfont">Your registration was successful.</span></p>
    <p>&nbsp;</p>
    <h1>Take poll and earn reward points</h1>
    <p>You can now take poll and earn reward points.<br>
        Go ahead and take “<a href="<?php echo $this->config->item('userRegistrationQuestions').'/1'; ?>">First Poll</a>” below and your account will be credited with reward points.</p>
    <div class="bluebox">
        <div class="bluelef">
            <div class="firsttxt">First Poll</div>
            <p>Answer few basic questions to the best of your knowledge</p>
        </div>
        <div class="bluerig">
            <div class="pointbox">
                <div class="point"><?php if(isset($pollPoints)) { echo $pollPoints; } ?></div>
                <div class="pointtxt">points</div>
            </div>
        </div>
    </div>
</div>
     </div>
 </div>
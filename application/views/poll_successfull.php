<div class="middle">
    <div class="container">
        <div class="innerpage pollreg">
            <div class="regtitle">Thank you!</div>
            <p><span class="midfont">You have successfully completed your <strong>First Poll.</strong></span></p>
            <div class="bluebox">
                <div class="bluelef">
                    <div class="wonpoint">You have won <strong> <?php if(isset($firstPollRewardPoints)) { echo $firstPollRewardPoints; }?> points!</strong></div>
                    <div class="congtxt">Congratulations!</div>
                    <p> <?php if(isset($firstPollRewardPoints)) { echo "Your account is credited with " .$firstPollRewardPoints ." reward points."; }?> </p>
                </div>
                <div class="bluerig">
                    <div class="pointbox">
                        <div class="point"><?php if(isset($firstPollRewardPoints)) { echo $firstPollRewardPoints; }?></div>
                        <div class="pointtxt">points</div>
                    </div>
                </div>
            </div>
            <h1>Take another poll and earn more reward points</h1>
            <p><a href="#" class="bluebtn">Take Poll</a></p>
        </div>
    </div>
    </div>
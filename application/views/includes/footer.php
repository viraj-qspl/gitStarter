<div class="graycol">
    <div class="container">
        <div class="appcol"><a href="#"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/app_store.png" alt=""></a></div>
        <div class="appcoltxt">Don't forget to get the app for your favorite<br>
            <strong>Mobile Device and Smartphone!</strong></div>
        <div class="appcol"><a href="#"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/google_play.png" alt=""></a></div>
    </div>
</div>
<div class="footerbtn">
    <div class="container"><a class="fotmenu">Footer Menu</a></div>
</div>
<div class="footer">
    <div class="footertop">
        <div class="container">
            <div class="footcol">
                <ul>
                    <li><a href="<?php echo $this->config->item('homeAction'); ?>">Home</a></li>
                    <li><a href="<?php echo $this->config->item('aboutUsAction'); ?>">About Us</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Terms</a></li>
                </ul>
            </div>
            <div class="footcol">
                <ul id="fot1">
                    <li><a href="<?php echo $this->config->item('contactUsAction'); ?>">Contact Us</a></li>
                    <li><a href="<?php echo $this->config->item('faqAction'); ?>">FAQ</a></li>
                    <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#what-you-earn">What you earn</a></li>
                    <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#where-you-can-use">Where you can use</a></li>
                </ul>
            </div>
            <div class="footcol">
                <ul id="fot2">
                    <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#answer-win">Answer & Win</a></li>
                    <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#create-share">Create & Share</a></li>
                    <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#partnership">Partnership</a></li>
                </ul>
            </div>
            <div class="footcolrig">
                <p>Also Find us on:</p>
                <p>&nbsp;</p>
                <p><a href="#"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/app_store_fo.png" alt=""></a> &nbsp; <a href="#" target="_blank"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/fb.gif" alt=""></a> &nbsp; <a href="#" target="_blank"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/tw.gif" alt=""></a></p>
            </div>
        </div>
    </div>
    <div class="footerbot">
        <div class="container">Copyright @ ThaiPoll</div>
    </div>
</div>
<p style="display: none;" id="back-top"> <a href="#top"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/top.png" alt=""></a> </p>
</div>

<div id="login" class="mainpopup">
    <div class="closebtn"><a class="login_close"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/close.png" alt=""></a></div>
    <div class="loginpop">
        <?php if(isset($url)){ ?>
        <div class="fblogin"><a href="<?php echo $url; ?>"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/fblogin.gif" alt=""></a></div>       
        <div class="or">-- OR --</div>
        <?php } ?>
        <div class="maintitle">Log In</div>
        <div class="loginfoam">
            <form name="login" action="<?php echo $this->config->item('loginAction'); ?>" method="post">
                <p>
                    <?php
                    if (isset($login_errorMsg)) {
                        echo "<font color='red'>" . $login_errorMsg . "</font>";
                    }
                    ?>
                </p>

                <p>
                    <input type="text" placeholder="Username" class="logininp" name="email">
                </p>
                <p>
                    <input type="password" placeholder="Password" class="logininp" name="password">
                </p>
                <p>
                    <input type="hidden" width="220px" name="oprType" id="oprType" value="<?php echo OPR_ADD; ?>" />
                </p>
                <p class="fortxt">
                    <a href="#" class="login_close forgot_open">Forgot Password?</a>
                </p>
                <p class="txtlef">
                    <input type="submit" value="Log In" class="bluebtn">
                </p>
            </form>
        </div>
    </div>
</div>

<div id="forgot" class="mainpopup">
    <div class="closebtn"><a class="forgot_close"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/close.png" alt=""></a></div>
    <div class="loginpop">
        <div class="maintitle">Forgot Password</div>
        <div class="loginfoam">
            <form name="forgot_password" action="<?php echo $this->config->item('userForgotPasswordFeAction'); ?>" method="post">
                <p>No problem. Please enter your email below and we will send you the details</p>
                <p>
                    <?php
                    if (isset($forgot_password_errorMsg)) {
                        echo "<font color='red'>" . $forgot_password_errorMsg . "</font>";
                    }

                    if (isset($forgot_password_successMsg)) {
                        echo "<font color='green'>" . $forgot_password_successMsg . "</font>";
                    }
                    ?>
                </p>
                <p>
                    <input type="text" placeholder="Email Address" class="logininp" name="email">
                </p>
                <p> 
                    <input type="hidden" width="220px" name="oprType" id="oprType" value="<?php echo OPR_EDIT; ?>" />
                </p>
                <p class="txtlef">
                    <input type="submit" value="Send" class="bluebtn">
                </p>
            </form>
        </div>
    </div>
</div>

<div id="signup" class="mainpopup">
    <div class="closebtn"><a class="signup_close"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/close.png" alt=""></a></div>
    <div class="loginpop">
        <?php if(isset($url)){ ?>
        <div class="fblogin"><a href="<?php echo $url; ?>"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/fblogin.gif" alt=""></a></div>       
        <div class="or">-- OR --</div>
        <?php } ?>
        
        <div class="maintitle">Sign Up</div>
        <div class="loginfoam custinput">
             <form name="signup" action="<?php echo $this->config->item('userSaveFeAction');?>" method="post" >
                <p>
                <?php
                if (isset($signup_errorMsg)) {
                    echo "<font color='red'>" . $signup_errorMsg . "</font>";
                }
                ?>
                </p>

                <p>
                    <input type="text" placeholder="Email" class="logininp" name="email">
                </p>
                <p>
                    <input type="password" placeholder="Password" class="logininp" name="password">
                </p>
                <p>
                    <input type="password" placeholder="Re-enter Password" class="logininp" name="confirm_password">
                </p>
                <p class="txtlef">Birthday</p>
                <p class="txtlef">
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
                    <select class="selmonth" name="year">
                        <option>Year</option>
                        <option value='1990'>1990</option>
                        <option value='1991'>1991</option>
                        <option value='1992'>1992</option>
                        <option value='1993'>1993</option>
                        <option value='1994'>1994</option>
                    </select>
                </p>
                <p class="txtlef">
                    <input type="radio" id="male" name="gender" value="<?php echo MALE ?>">
                    <label for="female">Female</label>
                    &nbsp; &nbsp;
                    <input type="radio" id="female" name="gender" value="<?php echo FEMALE ?>">
                    <label for="male">Male</label>
                </p>
                <p>
                    <input type="hidden" name="id" id="id" value="X"/>
                    <input type="hidden" name="user_type" id="user_type" value="user"/>
                    <input type="hidden" name="oprType" id="oprType" value="<?php echo OPR_ADD; ?>"/>
                </p>
                <p class="txtlef">
                    <input type="submit" value="Sign Up" class="bluebtn">
                </p>
            </form>
        </div>
    </div>
</div>
<div class="modal"><!-- Place at bottom of page --></div>
</body>
</html>

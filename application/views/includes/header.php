<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ThaiPoll</title>

        <link href="<?php echo $this->config->item('base_url') . '/assets/' ?>css/style.css" type="text/css" rel="stylesheet">
        <link href="<?php echo $this->config->item('base_url') . '/assets/' ?>css/responsive.css" type="text/css" rel="stylesheet">
        <link href="<?php echo $this->config->item('base_url') . '/assets/' ?>css/flexslider.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->config->item('base_url') . '/assets/' ?>css/css_radio/all.css" rel="stylesheet">
        
        <script src="<?php echo $this->config->item('base_url') . '/assets/' ?>js/jquery-1.7.2.min.js" type="text/javascript" ></script>
        <script defer src="<?php echo $this->config->item('base_url') . '/assets/' ?>js/jquery.flexslider.js"></script>
		<script src="<?php echo $this->config->item('base_url'); ?>/assets/js/verify.notify.min.js" type="text/javascript"></script>
		
        <script src="<?php echo $this->config->item('base_url') . '/assets/' ?>js/jquery.popupoverlay.js"></script>
        <script src="<?php echo $this->config->item('base_url') . '/assets/' ?>js/jquery.placeholder.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('base_url') . '/assets/' ?>js/icheck.js"></script>
        <script src="<?php echo $this->config->item('base_url').'/assets/'?>js/jquery.cookie.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('base_url').'/assets/'?>js/jquery.treeview.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('base_url'); ?>/js/validate/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('base_url') . '/assets/' ?>js/jquery.scrollTo.js"></script>
        <script src="<?php echo $this->config->item('base_url') . '/assets/' ?>js/jquery.nav.js"></script>

        <script src="<?php echo $this->config->item('base_url') . '/assets/' ?>js/main.js"></script>
        <script src="<?php echo $this->config->item('base_url') . '/assets/' ?>js/script.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function($) {
                $(":input[placeholder]").placeholder();
            });

            $(window).load(function(){
                $('.flexslider').flexslider({
                        animation: "slide",
                        start: function(slider){
                          $('body').removeClass('loading');
                        }
                });

            });

            $(document).ready(function() {
    
                $('#login').popup();
                $('#forgot').popup();
                $('#signup').popup();

                var $nav = $('#nav');
                var $nav2 = $('#nav-2');
                var $fot1 = $('#fot1','#fot2');

                $nav.onePageNav();

                $nav2.on('click', 'a', function(e) {
                    var currentPos = $(this).parent().prevAll().length;

                    $nav.find('li').eq(currentPos).children('a').trigger('click');

                    e.preventDefault();
                });

                $fot1.on('click', 'a', function(e) {
                    var currentPos = $(this).parent().prevAll().length;

                    $nav.find('li').eq(currentPos).children('a').trigger('click');

                    e.preventDefault();
                });

                $('.custinput input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });

                $(".fotmenu").click(function(){
                    $(".footer").toggle();
                });

          });

          function DropDown(el) {
            this.dd = el;
            this.initEvents();
          }
		
          DropDown.prototype = {
            initEvents : function() {
            var obj = this;
            obj.dd.on('click', function(event){
            $(this).toggleClass('active');
                    event.stopPropagation();
                                    });	
                            }
            }
            $(function() {
                            var dd = new DropDown( $('#dd1') );
                            $(document).click(function() {
                                    // all dropdowns
                                    $('.wrapper-dropdown-3').removeClass('active');
                            });

                         });
    </script>
	
	
	
<link href="<?php echo $this->config->item('base_url').'/assets/'?>css/responsiveTabs.css" type="text/css" rel="stylesheet">		
<script src="<?php echo $this->config->item('base_url').'/assets/'?>js/jquery.responsiveTabs.js" type="text/javascript"></script>		
<script type="text/javascript">
        $(document).ready(function () {
            $('#horizontalTab').responsiveTabs({
                rotate: false,
                startCollapsed: 'accordion',
                collapsible: 'accordion',
                setHash: false,
            });
			$('.select-tab').on('click', function() {
                $('#horizontalTab').responsiveTabs('activate', $(this).val());
            });

         });
</script>		
	
	
	
	
	
    </head>
    
    <body>
        <div id="wrapper">
            <!--<div class="header headinner">-->
            <div class="header">
                <div class="mainheader">
                    <div class="logo"><a href="<?php echo $this->config->item('actionFeUrl'); ?>"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/logo.png" alt=""></a></div>
                    <div class="heder_rig">
                        <div class="navigation"> <a class="toggleMenu" href="#"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/menu.png" alt=""></a>
                            <ul class="nav">
                                <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>">Home</a></li>
                                
                                <?php // if(empty($this->session->userdata('user_id')) != 1){ ?>
                                <?php if($this->session->userdata('user_id')){ ?>
                                <li><a href="#">Take Poll</a></li>
                                <li><a href="<?php echo $this->config->item('actionFeUrl').'/poll/createPoll'; ?>">Create Poll</a></li>
                                <li><a href="#">Result</a></li>
                                <li><a href="#">Redeem Reward</a></li>
                                
                                <?php } else { ?>
                                <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#how-it-works">How it works</a></li>
                                <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#what-you-earn">What you earn</a></li>
                                <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#where-you-can-use">Where you can use</a></li>
                                <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#answer-win">Answer & Win</a></li>
                                <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#create-share">Create & Share</a></li>
                                <li><a href="<?php echo $this->config->item('actionFeUrl'); ?>#partnership">Partnership</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        
                        <?php // if(empty($this->session->userdata('user_id')) != 1) { ?>
                        <?php if($this->session->userdata('user_id')){ ?>
                        <div class="nav_btn">
<!--                            <div id="dd1" class="wrapper-dropdown-3" tabindex="1" style="float:left;"> <?php// if(!empty($this->session->userdata('email'))){ echo $this->session->userdata('email'); } else { echo "USER"; } ?> &nbsp;<img src="<?php // echo $this->config->item('base_url') . '/assets/' ?>images/userarrow.png" alt="" align="absmiddle" />-->
                               <div id="dd1" class="wrapper-dropdown-3" tabindex="1" style="float:left;"> <?php if($this->session->userdata('email')){ echo $this->session->userdata('email'); } else { echo "USER"; } ?> &nbsp;<img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/userarrow.png" alt="" align="absmiddle" />

                                <ul class="dropdown">
                                    <li><a href="#"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/profile.png" alt="">&nbsp; My Profile</a></li>
                                    <li><a href="web.html"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/setting.png" alt="">&nbsp; Setting</a></li>
                                    <li><a href="web.html"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/earn.png" alt="">&nbsp; Earned Points (<strong>2000</strong>)</a></li>
                                   
                                    <?php if(isset($logout_url)){?>
                                    <li><a class="helpguide_btn"  href="<?php echo $logout_url; ?>"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/logout.png" alt="">&nbsp; Logout from Facebook</a></li>
                                    <?php } else { ?>
                                    <li><a class="helpguide_btn" href="<?php echo $this->config->item('userLogoutFeAction');?>"><img src="<?php echo $this->config->item('base_url') . '/assets/' ?>images/logout.png" alt="">&nbsp; Logout</a></li>
                                    <?php } ?>
                                </ul>
                                
                            </div>
                        </div>
                        <?php } ?>
                        
                        <?php // if(empty($this->session->userdata('user_id'))) { ?>
                        <?php if(!$this->session->userdata('user_id')){ ?>
                        <div class="nav_btn"> 
                            <a class="signup_open bluebtn" href="#signup">Sign up</a>
                            <a href="#" class="login_open bluebtn">Log In</a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
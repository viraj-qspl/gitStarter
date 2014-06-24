<?php
/*
* Page Name: layout.php
* Purpose: Displays header- dynamic midsection - footer and all other common files
*/
?>

<!-- load session library -->
<?php
$this->load->library('session');
$this->load->helper('array');
?>

<!-- Load Header -->
<?php $this->load->view('includes/header');?>

<!-- Load Dynamic View Page -->
<?php 

//if($this->session->userdata('session_id') != "" )// if logged in
if($this->session->userdata('user_id') != "" ) 
{
	if(!isset($viewArr))
		$viewArr = array();
	
	$this->load->view($viewPage,$viewArr);
} 
else if(isset($viewPage))//if dynamic view is not supplied, load default page
{	
    if($viewPage == "about_us" || $viewPage == "contact_us" || $viewPage == "faq")
    {
        $this->load->view($viewPage);
    }
    else
    {
	$this->load->view('newhome');
    }
}
else
    {
	$this->load->view('newhome');
    }
?>

<!-- Load  Footer -->
<?php 
if(isset($viewArr['url']))
{
    $this->load->view('includes/footer',$viewArr);
} else { 
    $this->load->view('includes/footer');   
}
?>
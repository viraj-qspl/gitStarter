<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div style="height: 0; line-height: 0; clear: both;"></div>
            <div style="width: 93.5%; padding: 15px 20px; margin: 0; font-family: Arial;">

            <!--mail content here start-->

            <p>Thank you for your enquiry!</p>
            <p>Your credential details are as given below!</p>
            <p>Email: <?php echo $email; ?> </p>
            <p>New Password: <?php echo $password; ?></p>   
            <br>    	 	    
            Also you may change your password by copy and pasting the following URL into your internet browser 
            (if the link is split into two lines, be sure to copy both lines): <br><br>
            <?php echo base_url().'home/change_pass_edit/'.base64_encode($user_id); ?>
    </body>
</html>

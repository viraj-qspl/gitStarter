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
        <form name="forgot_password" action="<?php echo $this->config->item('userGetForgotPasswordFeAction');?>" method="post">			
            <table><tr><td>Email</td></tr>
              <tr>
                <td>
                  <input type="text" width="220px" name="email" id="email" />
                   <input type="hidden" width="220px" name="oprType" id="oprType" value="<?php echo OPR_EDIT; ?>" />
                  <input type="submit" name="Submit" id="Submit" value="Submit" />
                </td>
                <td>
                    <?php
                    if (isset($errorMsg))
                    { 
                        echo "<font color='red'>".$errorMsg ."</font>";
                    }
                 
                    if(isset($successMsg))
                    {
                        echo "<font color='green'>".$successMsg ."</font>";
                    }
                    ?>
                </td>
              </tr>
            </table>
        </form>	
    </body>
</html>

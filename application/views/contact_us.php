<div class="middle">
    <div class="container">
        <div class="innerpage contpage">
            <form action="<?php echo $this->config->item('contactUsFeAction'); ?>" method="post">
            <h1>Contact Us</h1>
            
            <p>
                <?php
                if (isset($errorMsg)) {
                    echo "<font color='red'>" . $errorMsg . "</font>";
                } else if(isset($successMsg)) {
                    echo "<font color='red'>" . $successMsg . "</font>";
                } ?>
                </p>
                
            <p>
                <input type="text" placeholder="NAME" id= "name" name= "name" class="continp">
            </p>
            <p>
                <input type="text" placeholder="Email" id= "email" name= "email" class="continp">
            </p>
            <p>
                <input type="text" placeholder="Subject" name= "subject" class="continp">
            </p>
            <p>
                <textarea placeholder="Message" name="message" class="conttxt"></textarea>
            </p>
            <p>
                <input type="submit" value="Submit" class="bluebtn">
            </p>
            </form>
        </div>
    </div>
</div>
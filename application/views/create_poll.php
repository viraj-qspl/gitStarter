<style type="text/css">
    .question_type_box {
        width:400px;
        height:100px;
    }

</style>

<?php


if ($action == SELECT_TYPE) {
    ?>


    <div class="middle">
        <div class="container">
		<?php if(trim($this->session->userdata('scs_msg'))!='') { ?>
		<div id="success_message">
		<?php
			echo $this->session->userdata('scs_msg');
			$this->session->unset_userdata('scs_msg');
		?>
		</div> <?php } ?>
		
		
            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
                <div class="treestruc">
                    <ul class="treeview-red treeview" id="red">
                        <li class="expandable"><!-- div class="hitarea expandable-hitarea"></div --><span class=""><a href="<?php echo $this->config->item('base_url') . '/poll/createPoll/SCRATCH'; ?>">Create from Scratch</a></span>
                            <!--ul style="display: none;">
                              <li class="last"><span>Demo</span></li>
                            </ul -->
                        </li>
                        <li class="expandable lastExpandable"><div class="hitarea expandable-hitarea lastExpandable-hitarea"></div><span class="">Create from Template</span>
                            <ul style="display: none;">
    <?php
    foreach ($pollTemplates as $key => $value) {
        if (count($value->polls) == 0)
            continue;
        ?>	
                                    <li class="expandable"><div class="hitarea expandable-hitarea"></div><span><?php echo $value->pollCategoryName; ?></span>
                                        <ul style="display: none;">
                                    <?php
                                    foreach ($value->polls as $k => $v) {
                                        echo '<li class="last"><span><a href="' . $this->config->item('base_url') . '/poll/createPoll/TEMPLATE/0/' . $v->id . '">' . $v->title . '</a></span></li>';
                                    }
                                    ?>

                                        </ul>
                                    </li>

    <?php } ?>

                            </ul>
                        </li>
                    </ul>
                </div>

    <?php if (count($draft_polls) != 0) { ?>
                    <div class="draftpage">
                        <h3>My Poll (Drafts)</h3>
                        <div class="draftitle">Drafts</div>
                        <ul class="altbg">
    <?php
    }

    foreach ($draft_polls as $key => $value) {
        echo '<li style="background-color: rgb(232, 243, 250);"><a href="' . $this->config->item('base_url') . '/poll/createPoll/ADD_TYPE/' . $value->id . '/0/true">' . $value->title . '</a></li>';
    }

    if (count($draft_polls) != 0) {
        ?>
                        </ul></div>
                        <?php } ?>	








            </div>
        </div>
    </div>

    <?php
} elseif ($action == ENTER_POLL_DETAILS) {
    ?>


    <div class="middle">
        <div class="container">
            <div id="error_block">
    <?php
    echo validation_errors();
    $options = array();

    foreach ($pollCategories as $key => $value)
        $options[$value->id] = $value->category_name;
    ?>
            </div>


            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
                <div class="filterpage rowmain">

    <?php echo form_open_multipart('poll/save', array('name' => 'poll_details'), array('oprType' => $oprType)) . '<br/><br/>'; ?>		
                    <div class="rowfifty">
                        <h3>Poll header image</h3>

    <?php
    if (trim($recordObj->getImage()) != '')
        echo "<p><img width='355' src='" . $this->config->item('base_url') . '/uploads/' . $recordObj->getImage() . "' /></p>";
    else
        echo '<p><img width=\'355\' alt=""  src="' . $this->config->item('base_url') . '/assets/images/default.jpg"></p>';
    ?>				


                        <p><span class="graytxt">Upload image type: JPG, PNG, GIF.  Max size - 1 MB</span><br>
    <?php echo form_input(array('name' => 'image', 'type' => 'file','data-validate'=>'checkFileSize','id'=>'image')); ?>
                        </p>
                        <p>
                            <span class="character"><span id="100chars">100</span> characters left</span>
    <?php echo form_input(array('name' => 'title', 'value' => $recordObj->getTitle(), 'placeholder' => "Enter Poll title", "class" => "logininp", "data-validate" => "required")); ?>

                        </p>
                        <p>		
    <?php
    if ($pollCategoryId == NULL)
        $pollCategoryId = $recordObj->getPollCategory_id();
    ?>
                            <?php echo form_dropdown('pollCategory_id', $options, $pollCategoryId, "class='loginsel'"); ?>  		  
                        </p>
                        <p> <span class="character"> <span id="140chars">140</span> characters left</span>
                            <textarea name="descp" data-validate="required" value="<?php echo $recordObj->getDescp(); ?>" placeholder="Enter Poll description" class="logintext"></textarea>
                        </p>
    <?php
    
        echo form_hidden('upl_image', trim($recordObj->getImage()));

    if (trim($recordObj->getPoll_type()) != '') {
        $poll_type = $recordObj->getPoll_type();
    } else {
        if ($this->uri->segment(3) == 'SCRATCH') {
            $poll_type = 'POLL';
            $templateId = '';
        } else {
            $poll_type = 'TEMPLATE';
            $templateId = $templateId;
        }
    }

    if (trim($recordObj->getTemplate_id() != '')) {

        $templateId = $recordObj->getTemplate_id();
    }




    echo form_hidden('poll_type', $poll_type);
    echo form_hidden('templateId', $templateId);
    ?>


                        <p><?php echo form_submit('mysubmit', 'Submit', 'class="bluebtn"'); ?></p>
                    </div>
                        <?php form_close(); ?>

                </div>
            </div>
        </div>
    </div>

                    <?php
                } elseif ($action == ADD_TYPE) {
                    ?>
    <div class="middle">
        <div class="container">
            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
                <div class="draftpage">
                    <p><span class="mandatory">Poll must have at least one question</span></p>
                    <h3>Questions</h3>
                    <p><a href="<?php echo $this->config->item('base_url') . "/poll/createPoll/ADD_QUESTION/" . $poll_id; ?>"><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url') ?>/assets/images/add.png"> &nbsp; Add a question</a></p>

    <?php if (count($questions) != 0) { ?>
                        <div class="draftitle">Question List</div>
                        <ul class="altbg">

        <?php
        $i = 1;



        foreach ($questions as $key => $value) {

            $background = '';
            if ($i % 2 != 0)
                $background = 'background-color: rgb(232, 243, 250)';

            echo "<li style='" . $background . "'><a href='" . $this->config->item('base_url') . "/poll/createPoll/EDIT_QUESTION/" . $this->uri->segment(4) . "/" . $value->id . "'>" . $value->question . "</a></li>";
            $i++;
        }
        ?>
                        </ul>
                        <?php } ?> 

                    <p>&nbsp;
                        <input type="hidden" name="num_questions" id="num_questions" value="<?php echo count($questions); ?>"/>
						<input type="hidden" name="skip_questions" id="skip_questions" value="<?php echo count($skip_questions); ?>"/>
                    </p>
                    <h3>Skip flow logic</h3>
                    <p><a href="javascript:void(0)" name='add_skip_logic' id='add_skip_logic' onClick='addSkipLogic("<?php echo $poll_id; ?>")'><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url') ?>/assets/images/add.png"> &nbsp; Add Skip flow logic</a></p>
                        <?php if (count($skips) != 0) { ?>
                        <div class="draftitle">Skip flow logic List</div>
                        <ul class="altbg">

                        <?php
                        $i = 1;
                        foreach ($skips as $key => $value) {
                            echo "<li style='background-color: rgb(232, 243, 250);'><a href='" . $this->config->item('base_url') . "/poll/createPoll/EDIT_SKIP_LOGIC/" . $this->uri->segment(4) . "/" . $value->id . "'>Skip Logic #" . $i . "</a></li>";
                            $i++;
                        }
                        ?>
                        </ul>
                    <?php } ?>


                    <p>&nbsp;</p>			

                    <p><a class="bluebtn" href="javascript:void(0)" onClick="saveDraft('<?php echo $poll_id; ?>')" >Save as Draft</a> &nbsp; <a  class="bluebtn" href="javascript:void(0)" onClick="preview('<?php echo $poll_id; ?>')">Preview</a> &nbsp; <a onClick="pollSubmit('<?php echo $poll_id; ?>')"  class="bluebtn" href="javascript:void(0)">Submit</a></p>
                </div>
            </div>
        </div>
    </div>



    <?php
} elseif ($action == ADD_QUESTION) {
    ?>
    <div class="middle">
        <div class="container">
    <?php echo form_open('poll/addQuestion', array('name' => 'add_question', 'id' => 'add_question')); ?>
            <div class="innerpage pollreg" >
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
                <div class="filterpage custinput">
                    <h3>Questions</h3>
                    <p>
            <?php echo form_input(array('name' => 'question', 'id' => 'question', 'class' => 'logininp', 'placeholder' => 'Enter your question here', "data-validate" => "required,checkOptCount,checkDuplicate")); ?>
                    </p>
                    <h3>Answer is required</h3>
                    <p>


    <?php echo form_radio(array('name' => 'required', 'value' => 'Y', 'id' => 'radio-44', "data-validate" => "required")); ?>
                        <label for="radio-44">&nbsp; Yes</label>
                        &nbsp; &nbsp;
    <?php echo form_radio(array('name' => 'required', 'value' => 'N', 'id' => 'radio-45', "data-validate" => "required")); ?>
                        <label for="radio-45">&nbsp; No</label>	




                    </p>
                    <h3>Question Type <span class="graytxt medfont">User may choose one option</span></h3>
                    <div class="tabbing">
                        <div id="horizontalTab">
                            <ul>
                                <li><a id="SINGLE_SEL" class="question_type" href="#single">Single</a></li>
                                <li><a id="MULTIPLE_SEL" class="question_type" href="#multiple">Multiple</a></li>
                                <li><a id="SCALE_SEL" class="question_type" href="#scale">Scale</a></li>
                                <li><a id="TEXT_SEL" class="question_type" href="#text">Text</a></li>
                            </ul>
                            <div id="single">
                                <div class="maintab">
                                    <h3>Option</h3>
                                    <p>

    <?php
    echo form_input(array('name' => 'sng[]', 'class' => 'sng_option sng_option_1 ', 'value' => 'Yes', 'order' => '1', 'type' => 'hidden')) . form_radio(array('class' => 'sng_option sng_option_1 ')) . '<label for="radio-1">&nbsp; Yes</label> &nbsp; &nbsp;';
    echo form_input(array('name' => 'sng[]', 'class' => 'sng_option sng_option_2 ', 'value' => 'No', 'order' => '2', 'type' => 'hidden')) . form_radio(array('class' => 'sng_option sng_option_2')) . '<label for="radio-2">&nbsp; No</label> &nbsp; &nbsp;';
    echo form_hidden('sng_opt_count', 2);
    ?>

                                    </p>
                                    <p style="margin-bottom:10px;"><a id='sng_add_option'  style='text-decation:none'><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url'); ?>/assets/images/add.png"> &nbsp; Add Option</a></p>
                                    <p>
                                        <input class="logininp" type="text" placeholder="Add options" id='sng_add_value'  >
                                    </p>
                                    <h3>Allow text answer</h3>
                                    <p>


                                        <input type="radio" name='sng_allow_text' id="radio-48" value='Y' checked >
                                        <label for="radio-48">&nbsp; Yes</label>
                                        &nbsp; &nbsp;
                                        <input type="radio" name='sng_allow_text' id="radio-49" value='N'>
                                        <label for="radio-49">&nbsp; No</label>

                                    </p>
                                    <p><span class="graytxt">Enable the switch to allow users to write their own answer for this question</span></p>

                                </div>
                            </div>



                            <div id="multiple">
                                <div class="maintab">
                                    <h3>Option</h3>
                                    <p>
    <?php
    echo form_input(array('name' => 'mlt[]', 'class' => 'mlt_option mlt_option_1 ', 'value' => 'Yes', 'order' => '1', 'type' => 'hidden')) . form_checkbox(array('class' => 'mlt_option mlt_option_1 ')) . '<label for="radio-1">&nbsp; Yes</label> &nbsp; &nbsp;';
    echo form_input(array('name' => 'mlt[]', 'class' => 'mlt_option mlt_option_2 ', 'value' => 'No', 'order' => '2', 'type' => 'hidden')) . form_checkbox(array('class' => 'mlt_option mlt_option_2')) . '<label for="radio-2">&nbsp; No</label> &nbsp; &nbsp;';
    echo form_hidden('mlt_opt_count', 2);
    ?>

                                    </p>
                                    <p style="margin-bottom:10px;"><a id='mlt_add_option'  style='text-decation:none'><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url'); ?>/assets/images/add.png"> &nbsp; Add Option</a></p>
                                    <p>
                                        <input class="logininp" type="text" placeholder="Add options" id='mlt_add_value'>
                                    </p>
                                    <h3>Allow text answer</h3>
                                    <p>


                                        <input type="radio" name='mlt_allow_text' id="radio-48" value='Y' checked>
                                        <label for="radio-48">&nbsp; Yes</label>
                                        &nbsp; &nbsp;
                                        <input type="radio" name='mlt_allow_text' id="radio-49" value='N'>
                                        <label for="radio-49">&nbsp; No</label>

                                    </p>
                                    <p><span class="graytxt">Enable the switch to allow users to write their own answer for this question</span></p>
                                </div>
                            </div>

                            <div id="scale">
                                <div class="maintab">
                                    <h3>1 <?php echo form_input(array('name' => 'scl[]', 'id' => 'scl_option_1', 'value' => '1', 'type' => 'hidden')); ?></h3>
                                    <p>

    <?php echo form_input(array('name' => 'scl_label[]', 'id' => 'scl_label_1', 'value' => SCALE_LABEL_1, 'class' => 'logininp', 'placeholder' => 'Strongly disagree', 'data-validate' => 'required')); ?>
                                    </p>
                                    <h3>5 <?php echo form_input(array('name' => 'scl[]', 'id' => 'scl_option_2', 'value' => '5', 'type' => 'hidden')); ?></h3>
                                    <p>

    <?php echo form_input(array('name' => 'scl_label[]', 'id' => 'scl_label_2', 'value' => SCALE_LABEL_2, 'class' => 'logininp', 'placeholder' => 'Strongly Agree', 'data-validate' => 'required')); ?>
                                    </p>

                                    <p><span class="graytxt">You can set the meaning of your scale Eg. Dsilike/Like</span></p>
                                    <h3>Sub-Questions</h3>
                                    <p id="subquestions_list">

                                    </p>

                                    <p style="margin-bottom:10px;"><a id="scl_add_ques" style="text-decation:none"><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url') ?>/assets/images/add.png"> &nbsp; Add subquestion</a></p>
                                    <p>
                                        <input class="logininp" id='scl_add_ques_value' type="text" placeholder="Add sub-question">
                                        <?php echo form_hidden('scl_sub_ques_count', 0); ?>


                                    </p>
                                    <!--p><a href="#" class="bluebtn">Preview</a> &nbsp; <a class="bluebtn" href="#">Save</a></p-->
                                </div>
                            </div>


                            <div id="text">
                                <div class="maintab">
                                    <h3>Input type</h3>
                                    <p>
                                        <input type="radio"  name='txttype' id="text_text" value='TEXT'>
                                        <label for="radio-50">&nbsp; Text</label>
                                        &nbsp; &nbsp;
                                        <input type="radio"  name='txttype' id="text_number" VALUE='NUMBER' checked>
                                        <label for="radio-51">&nbsp; Number</label>
                                    </p>

                                    <div class="rowmain" id='text_number_segment'>
                                        <div class="rowfifty">
                                            <h3>Maximum value</h3>
                                            <p>
    <?php echo form_input(array('name' => 'min_value', 'value' => 0, 'class' => 'logininp', 'data-validate' => 'required,number')); ?>
                                            </p>
                                        </div>
                                        <div class="rowfifty">
                                            <h3>Minimum value</h3>
                                            <p>
    <?php echo form_input(array('name' => 'max_value', 'value' => 100, 'class' => 'logininp', 'data-validate' => 'required,number')); ?>
                                            </p>
                                        </div>
                                    </div>			
                                </div>
                                                <?php echo form_hidden('txt_type', 'NUMBER'); ?>
                            </div>

                        </div>
                    </div>
                </div>
                <p><!--a href="#" class="bluebtn">Preview</a> &nbsp; --><?php echo form_submit(array('name' => 'question_submit', 'value' => 'Save', 'class' => 'bluebtn')); ?></p>
                                                <?php
												echo form_hidden(array('question_id' => ''));
                                                echo form_hidden(array('poll_id' => $this->uri->segment(4)));
                                                echo form_hidden(array('type' => 'SINGLE'));
                                                echo form_close();
                                                ?>
            </div>

        </div>			
    </div>		


                <?php
            } elseif ($action == EDIT_QUESTION) {

                $questionType = $questionInfo->type;
                ?>
    <div class="middle">
        <div class="container">

    <?php echo form_open('poll/updateQuestion/' . $this->uri->segment(4) . '/' . $this->uri->segment(5), array('name' => 'update_question', 'id' => 'update_question'));
    ; ?>
            <div class="innerpage pollreg" >
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
                <div class="filterpage custinput">
                    <h3>Questions</h3>
                    <p>
    <?php echo form_input(array('name' => 'question', 'id' => 'question', 'class' => 'logininp', 'placeholder' => 'Enter your question here', 'value' => $questionInfo->question, 'data-validate' => 'required,checkOptCount,checkDuplicate')); ?>
                    </p>
                    <h3>Answer is required</h3>
                    <p>


    <?php
    $checked = ($questionInfo->required == 'Y') ? "checked" : "";
    echo form_radio(array('name' => 'required', 'value' => 'Y', 'id' => 'radio-44', 'checked' => $checked, 'data-validate' => 'required'));
    ?>
                        <label for="radio-44">&nbsp; Yes</label>
                        &nbsp; &nbsp;
                        <?php
                        $checked = ($questionInfo->required == 'N') ? "checked" : "";
                        echo form_radio(array('name' => 'required', 'value' => 'N', 'id' => 'radio-45', 'checked' => $checked, 'data-validate' => 'required'));
                        ?>
                        <label for="radio-45">&nbsp; No</label> 	

                    </p>
                    <h3>Question Type <span class="graytxt medfont">User may choose one option</span></h3>
                    <div class="tabbing">
                        <div id="horizontalTab">
                            <ul>
                                <li><a id="SINGLE_SEL" class="question_type" href="#single">Single</a></li>
                                <li><a id="MULTIPLE_SEL" class="question_type" href="#multiple">Multiple</a></li>
                                <li><a id="SCALE_SEL" class="question_type" href="#scale">Scale</a></li>
                                <li><a id="TEXT_SEL" class="question_type" href="#text">Text</a></li>
                            </ul>
                            <div id="single" style="display: <?php echo $display = ($questionType == 'SINGLE') ? 'block' : 'none'; ?>">
                                <div class="maintab">
                                    <h3>Option</h3>
                                    <p>

    <?php
    if ($questionInfo->type == 'SINGLE' || $questionInfo->type == 'MULTIPLE') {
        foreach ($questionInfo->answers as $key => $value) {
            echo form_input(array('name' => 'sng[]', 'class' => 'sng_option sng_option_' . ($key + 1), 'value' => $value->answer, 'order' => ($key + 1), 'type' => 'hidden')) . form_radio(array('class' => 'sng_option sng_option_' . ($key + 1))) . '<label for="radio-"' . ($key + 1) . '>&nbsp; ' . $value->answer . '</label> &nbsp; &nbsp;';
        }
        echo form_hidden('sng_opt_count', count($questionInfo->answers));
    } else {

        echo form_input(array('name' => 'sng[]', 'class' => 'sng_option sng_option_1 ', 'value' => 'Yes', 'order' => '1', 'type' => 'hidden')) . form_radio(array('class' => 'sng_option sng_option_1 ')) . '<label for="radio-1">&nbsp; Yes</label> &nbsp; &nbsp;';
        echo form_input(array('name' => 'sng[]', 'class' => 'sng_option sng_option_2 ', 'value' => 'No', 'order' => '2', 'type' => 'hidden')) . form_radio(array('class' => 'sng_option sng_option_2')) . '<label for="radio-2">&nbsp; No</label> &nbsp; &nbsp;';
        echo form_hidden('sng_opt_count', 2);
    }
    ?>
                                    </p>	
                                    <p style="margin-bottom:10px;"><a id='sng_add_option'  style='text-decation:none'><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url'); ?>/assets/images/add.png"> &nbsp; Add Option</a></p>
                                    <p>
                                        <input class="logininp" type="text" placeholder="Add options" id='sng_add_value'>
                                    </p>
                                    <h3>Allow text answer</h3>
                                    <p>
                                        <?php $checked = ($questionInfo->allow_text == 'Y') ? 'checked' : ''; ?>
                                        <input type="radio" name='sng_allow_text' id="radio-48" value='Y' <?php echo $checked; ?>>
                                        <label for="radio-48">&nbsp; Yes</label>
                                        &nbsp; &nbsp;
                                        <?php $checked = ($questionInfo->allow_text == 'N' || $questionInfo->allow_text == 'NA') ? 'checked' : ''; ?>
                                        <input type="radio" name='sng_allow_text' id="radio-49" value='N' <?php echo $checked; ?>>
                                        <label for="radio-49">&nbsp; No</label>			  
                                    </p>
                                    <p><span class="graytxt">Enable the switch to allow users to write their own answer for this question</span></p>


                                </div>
                            </div>



                            <div id="multiple" style="display: <?php echo $display = ($questionType == 'MULTIPLE') ? 'block' : 'none'; ?>">
                                <div class="maintab">
                                    <h3>Option</h3>
                                    <p>
    <?php
    if ($questionInfo->type == 'SINGLE' || $questionInfo->type == 'MULTIPLE') {
        foreach ($questionInfo->answers as $key => $value) {
            echo form_input(array('name' => 'mlt[]', 'class' => 'mlt_option mlt_option_' . ($key + 1), 'value' => $value->answer, 'order' => ($key + 1), 'type' => 'hidden')) . form_checkbox(array('class' => 'mlt_option mlt_option_' . ($key + 1))) . '<label for="radio-1">&nbsp; ' . $value->answer . '</label> &nbsp; &nbsp;';
        }
        echo form_hidden('mlt_opt_count', count($questionInfo->answers));
    } else {
        echo form_input(array('name' => 'mlt[]', 'class' => 'mlt_option mlt_option_1 ', 'value' => 'Yes', 'order' => '1', 'type' => 'hidden')) . form_checkbox(array('class' => 'mlt_option mlt_option_1 ')) . '<label for="radio-1">&nbsp; Yes</label> &nbsp; &nbsp;';
        echo form_input(array('name' => 'mlt[]', 'class' => 'mlt_option mlt_option_2 ', 'value' => 'No', 'order' => '2', 'type' => 'hidden')) . form_checkbox(array('class' => 'mlt_option mlt_option_2')) . '<label for="radio-2">&nbsp; No</label> &nbsp; &nbsp;';
        echo form_hidden('mlt_opt_count', 2);
    }
    ?>

                                    </p>
                                    <p style="margin-bottom:10px;"><a id='mlt_add_option'  style='text-decation:none'><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url'); ?>/assets/images/add.png"> &nbsp; Add Option</a></p>
                                    <p>
                                        <input class="logininp" type="text" placeholder="Add options" id='mlt_add_value'>
                                    </p>
                                    <h3>Allow text answer</h3>
                                    <p>

                                        <?php $checked = ($questionInfo->allow_text == 'Y') ? 'checked' : ''; ?>
                                        <input type="radio" name='mlt_allow_text' id="radio-48" value='Y' <?php echo $checked; ?>>
                                        <label for="radio-48">&nbsp; Yes</label>
                                        &nbsp; &nbsp;
    <?php $checked = ($questionInfo->allow_text == 'N') ? 'checked' : ''; ?>
                                        <input type="radio" name='mlt_allow_text' id="radio-49" value='N' <?php echo $checked; ?>>
                                        <label for="radio-49">&nbsp; No</label>

                                    </p>
                                    <p><span class="graytxt">Enable the switch to allow users to write their own answer for this question</span></p>
                                </div>
                            </div>

                            <div id="scale" style="display: <?php echo $display = ($questionType == 'SCALE') ? 'block' : 'none'; ?>">
                                <div class="maintab">

                                        <?php
                                        if ($questionInfo->type == 'SCALE') {

                                            foreach ($questionInfo->answers as $key => $value) {
                                                ?>

                                            <h3><?php echo $value->answer; ?> <?php echo form_input(array('name' => 'scl[]', 'id' => 'scl_option_' . $key, 'value' => $value->answer, 'type' => 'hidden')); ?></h3>
                                            <p>

            <?php echo form_input(array('name' => 'scl_label[]', 'id' => 'scl_label_' . $key, 'value' => $value->label, 'class' => 'logininp', 'data-validate' => 'required')); ?>
                                            </p> <?php }
        ?>
                                        <p><span class="graytxt">You can set the meaning of your scale Eg. Dsilike/Like</span></p>
                                        <h3>Sub-Questions</h3>
                                        <p id="subquestions_list"> <?php foreach ($questionInfo->scaleQuestions as $value) { ?>
                                            <?php
                                            echo '<input type="hidden" name="scl_sub_ques[]" class="scl_sub_ques" value="' . $value->scale_question . '" /><span>' . $value->scale_question
                                            . '<img src="' . $this->config->item('base_url') . '/assets/images/delete15.png"/></span><br/>';
                                        }
                                        ?></p>
                                        <p style="margin-bottom:10px;"><a id="scl_add_ques" style="text-decation:none"><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url') ?>/assets/images/add.png"> &nbsp; Add subquestion</a></p>
                                        <p>
                                            <input class="logininp" id='scl_add_ques_value' type="text" placeholder="Add sub-question">
                                        <?php echo form_hidden('scl_sub_ques_count', count($questionInfo->scaleQuestions)); ?></p>
        <?php
    } else {
        ?>

                                        <h3>1 <?php echo form_input(array('name' => 'scl[]', 'id' => 'scl_option_1', 'value' => '1', 'type' => 'hidden')); ?></h3>
                                        <p>

        <?php echo form_input(array('name' => 'scl_label[]', 'id' => 'scl_label_1', 'value' => SCALE_LABEL_1, 'class' => 'logininp', 'placeholder' => 'Strongly disagree', 'data-validate' => 'required')); ?>
                                        </p>
                                        <h3>5 <?php echo form_input(array('name' => 'scl[]', 'id' => 'scl_option_2', 'value' => '5', 'type' => 'hidden')); ?></h3>
                                        <p>

                                        <?php echo form_input(array('name' => 'scl_label[]', 'id' => 'scl_label_2', 'value' => SCALE_LABEL_2, 'class' => 'logininp', 'placeholder' => 'Strongly Agree', 'data-validate' => 'required')); ?>
                                        </p>		

                                        <p><span class="graytxt">You can set the meaning of your scale Eg. Dsilike/Like</span></p>
                                        <h3>Sub-Questions</h3>
                                        <p id="subquestions_list"></p>

                                        <p style="margin-bottom:10px;"><a id="scl_add_ques" style="text-decation:none"><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url') ?>/assets/images/add.png"> &nbsp; Add subquestion</a></p>
                                        <p>
                                            <input class="logininp" id='scl_add_ques_value' type="text" placeholder="Add sub-question">

                                            <?php echo form_hidden('scl_sub_ques_count', 0); //scl_sub_ques stored question  ?>
                                        </p>
        <?php
    }
    ?>

                                </div>
                            </div>


                            <div id="text" style="display: <?php echo $display = ($questionType == 'TEXT') ? 'block' : 'none'; ?>">



                                    <?php
                                    if ($questionType == 'TEXT') {
                                        $text = false;
                                        $txt_type = NULL;
                                        $number = true;

                                        foreach ($questionInfo->answers as $k => $v) {
                                            if ($v->text == 'Y') {
                                                $text = true;
                                                $number = false;
                                                $txt_type = 'TEXT';
                                            }
                                        }

                                        if ($txt_type != 'TEXT') {
                                            foreach ($questionInfo->answers as $k => $v) {
                                                if ($v->text == 'N')
                                                    $number = $number && true;
                                                else
                                                    $number = $number && false;
                                            }
                                        }
                                        if ($number) {
                                            $txt_type = 'NUMBER';
                                        }
                                    } else {
                                        $txt_type = 'TEXT';
                                        $text = true;
                                        $number = false;
                                    }
                                    ?>



                                <div class="maintab">
                                    <h3>Input type</h3>
                                    <p>
                                        <input type="radio"  name='txttype' id="text_text" value='TEXT' <?php if ($text) echo 'checked'; ?> >
                                        <label for="radio-50">&nbsp; Text</label>
                                        &nbsp; &nbsp;
                                        <input type="radio"  name='txttype' id="text_number" VALUE='NUMBER' <?php if ($number) echo 'checked'; ?>>
                                        <label for="radio-51">&nbsp; Number</label>
                                    </p>




                                    <div class="rowmain" id='text_number_segment' style="display:<?php echo $display = ($number == true ) ? 'block' : 'none'; ?>">
                                        <div class="rowfifty">
    <?php if ($text == true) { ?>						

                                                <h3>Maximum value</h3>
                                                <p>
        <?php echo form_input(array('name' => 'min_value', 'value' => 0, 'class' => 'logininp', 'data-validate' => 'required,number')); ?>
                                                </p>
                                            </div>
                                            <div class="rowfifty">
                                                <h3>Minimum value</h3>
                                                <p>
        <?php echo form_input(array('name' => 'max_value', 'value' => 100, 'class' => 'logininp', 'data-validate' => 'required,number')); ?>
                                                </p>

    <?php
    } elseif ($number == true) {



        $min_value = $questionInfo->answers[0]->answer;
        $max_value = $questionInfo->answers[1]->answer;
        ?>	
                                                <h3>Maximum value</h3>
                                                <p>
        <?php echo form_input(array('name' => 'min_value', 'value' => $min_value, 'class' => 'logininp', 'data-validate' => 'required,number')); ?>
                                                </p>
                                            </div>
                                            <div class="rowfifty">
                                                <h3>Minimum value</h3>
                                                <p>
        <?php echo form_input(array('name' => 'max_value', 'value' => $max_value, 'class' => 'logininp', 'data-validate' => 'required,number')); ?>
                                                </p>

                                            <?php
                                            } elseif ($txt_type === NULL) {

                                                $txt_type = 'NUMBER';
                                                $min_value = 0;
                                                $max_value = 100;
                                                ?>	
                                                <h3>Maximum value</h3>
                                                <p>
        <?php echo form_input(array('name' => 'min_value', 'value' => $min_value, 'class' => 'logininp')); ?>
                                                </p>
                                            </div>
                                            <div class="rowfifty">
                                                <h3>Minimum value</h3>
                                                <p>
        <?php echo form_input(array('name' => 'max_value', 'value' => $max_value, 'class' => 'logininp')); ?>
                                                </p>				

                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>			
                                </div>
                                                <?php echo form_hidden('txt_type', $txt_type); ?>	
                            </div>

                        </div>
                    </div>
                </div>
                <p><!--a href="#" class="bluebtn">Preview</a> &nbsp; --><?php echo form_submit(array('name' => 'question_submit', 'value' => 'Save', 'class' => 'bluebtn')); ?></p>
                                                <?php
												 echo form_hidden(array('question_id' => $this->uri->segment(5)));
                                                echo form_hidden(array('type' => $questionInfo->type));
                                                echo form_hidden(array('poll_id' => $this->uri->segment(4)));
                                                echo form_close();
                                                ?>
            </div>

        </div>
    </div>
    <script type='text/javascript'>
        $(document).ready(function() {
            $('#<?php echo $questionType; ?>_SEL').trigger('click');
        });

    </script>	
    <?php
} else if ($action == SKIP_LOGIC) {
    ?>          
    <div class="middle">
        <div class="container">
            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
    <?php echo form_open("/poll/saveSkipLogic/" . $this->uri->segment(4)); ?>
                <div class="filterpage rowmain custinput">
                    <div class="quescol">
                        <p>
    <?php
    $questionsDrop = array('' => 'Please Select an Option');
    $answers = array();


    foreach ($questions as $key => $value) {

        $answers[$value->answer_id]['answer'] = $value->answer;
        $answers[$value->answer_id]['qid'] = $value->id;


        if (isset($questionsDrop[$value->id]))
            continue;
        else
            $questionsDrop[$value->id] = $value->question;
    }
    echo form_dropdown('dep_questions', $questionsDrop, '', 'id="dep_questions" autocomplete="off" class="loginsel" data-validate="required"') . "<br/>";
    ?>											
                        </p>



                            <?php
                            foreach ($questionsDrop as $key => $value) {

                                if ($key == '')
                                    continue;
                                echo "<ul class='sinlist' id='question_" . $key . "' style='display:none'>";
                                ?> <h3>Is any of the following</h3> <?php
                                foreach ($answers as $k => $v) {
                                    if ($v['qid'] == $key)
                                        echo '<li>' . form_checkbox('answer_' . $v['qid'] . '[]', $k, false, 'data-validate="required"') . '<label>&nbsp;' . $v['answer'] . "</label></li>";
                                }
                                echo "</ul>";
                            }
                            ?>

                    </div>
                    <div class="quescol">
                            <?php
                            foreach ($other_questions as $key => $value) {

                                echo "<ul class=\"sinlist\" id='other_questions_" . $key . "' style='display:none'>";
                                ?><h3>Then Show these Questions</h3><?php
                            foreach ($value as $k => $v) {
                                echo ' <li>' . form_checkbox('other_questions_' . $key . '[]', $v->id, false, 'data-validate="required"') . '<label>&nbsp;' . $v->question . "</label></li>";
                            }
                            echo "</ul>";
                        }
                        ?>
                    </div>
                    <div class="quescol">
                        <p><?php echo form_submit(array('name' => 'skip_submit', 'value' => 'Save', 'class' => 'bluebtn')); ?></p>
                    </div>
                </div>
                        <?php
                        echo form_close();
                        ?>
            </div>
        </div>
    </div>
                        <?php
                    } elseif ($action == EDIT_SKIP_LOGIC) {
                        ?>	


    <div class="middle">
        <div class="container">
            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
                        <?php echo form_open("/poll/updateSkipLogic/" . $this->uri->segment(4) . '/' . $this->uri->segment(5)); ?>
                <div class="filterpage rowmain custinput">
                    <div class="quescol">
                        <p>
    <?php
    $questionsDrop = array('' => 'Please Select an Option');
    $answers = array();


    foreach ($questions as $key => $value) {

        $answers[$value->answer_id]['answer'] = $value->answer;
        $answers[$value->answer_id]['qid'] = $value->id;


        if (isset($questionsDrop[$value->id]))
            continue;
        else
            $questionsDrop[$value->id] = $value->question;
    }
    echo form_dropdown('dep_questions', $questionsDrop, $skipInfo->poll_question_id, 'id="dep_questions" autocomplete="off" class="loginsel" data-validate="required"') . "<br/>";
    ?>											
                        </p>



    <?php
    foreach ($questionsDrop as $key => $value) {

        if ($key == '')
            continue;

        echo "<ul class='sinlist' id='question_" . $key . "' style='display:none'>";
        ?> <h3>Is any of the following</h3> <?php
                                foreach ($answers as $k => $v) {

                                    $checked = false;

                                    foreach ($skipInfo->answers as $a => $av) {
                                        if ($av->poll_answer_id == $k) {
                                            $checked = TRUE;
                                            break;
                                        }
                                    }


                                    if ($v['qid'] == $key)
                                        echo '<li>' . form_checkbox('answer_' . $v['qid'] . '[]', $k, $checked, 'data-validate="required"') . '<label>&nbsp;' . $v['answer'] . "</label></li>";
                                }
                                echo "</ul>";
                            }
                            ?>

                    </div>
                    <div class="quescol">



                        <?php
                        foreach ($other_questions as $key => $value) {
                            echo "<ul class=\"sinlist\"  id='other_questions_" . $key . "' style='display:none'>";
                            ?><h3>Then Show these Questions</h3><?php
                            foreach ($value as $k => $v) {

                                $checked = false;
                                foreach ($skipInfo->questions as $q => $qv) {
                                    if ($qv->poll_question_id == $v->id) {
                                        $checked = true;
                                        break;
                                    }
                                }


                                echo ' <li>' . form_checkbox('other_questions_' . $key . '[]', $v->id, $checked, 'data-validate="required"') . '<label>&nbsp;' . $v->question . "</label></li>";
                            }
                            echo "</ul>";
                        }
                        ?>

                    </div>
                    <div class="quescol">
                        <p><?php echo form_submit(array('name' => 'skip_submit', 'value' => 'Save', 'class' => 'bluebtn')); ?></p>
                    </div>
                </div>
                        <?php
                        echo form_close();
                        ?>
            </div>
        </div>
    </div>
    <?php
} elseif ($action == VISIBILITY) {

    extract($filters);



    // Adding visibility filters

    extract($savedFilters);
    ?>
    <div class="middle">
        <div class="container">

                        <?php
                        echo form_open('poll/addVisibility/' . $this->uri->segment(4), array('name' => 'add_visibility'));
                        ?>

            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility visactive">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
                <div class="treestruc custinput">
                    <h3>Set Poll Visibility Filters</h3>
                    <ul id="red" class="treeview-red">
                        <li><span>By Age</span>
                            <ul>
                                <li ><span>
    <?php echo form_checkbox('all_age', 'ALL'); ?>
                                        <label >&nbsp; Select All</label>
                                    </span>
                                    <ul id='age_cont'>


                <?php
				
				
                foreach ($ageGroup as $key => $value) {
                    $checked = false;

					

                    foreach ($ageGroupFilter as $k => $v) {
                        if ($v->age_group_id == $value->id) {
                            $checked = true;
                            break;
                        }
                    }
                    ?>
                                            <li><span>
        <?php echo form_checkbox(array('name' => 'age[]', 'value' => $value->id, 'checked' => $checked, 'class' => 'checkthis')) ?>
                                                    <label >&nbsp; <?php echo $value->title; ?></label>
                                                </span></li>
    <?php }
    ?>
                                    </ul>
                                </li>
                            </ul>			
                        </li>




                        <li><span>By Gender</span>
                            <ul id='gender_cont'>
    <?php
    foreach ($gender as $key => $value) {
        $checked = false;
        if ($key == $genderFilter)
            $checked = true;
        ?>
                                    <li><span>
        <?php echo form_radio(array('name' => 'gender', 'value' => $key, 'checked' => $checked)) ?>
                                            <label >&nbsp; <?php echo $key; ?></label>
                                        </span></li>
                                        <?php } ?>
                            </ul>			
                        </li>		




                        <li><span>By Location</span>
                            <ul>
                                <li>
                                    <span>
                                        <?php echo form_checkbox('location', 'ALL', '', 'class="all_location"'); ?>
                                        <label>&nbsp; Select All</label>
                                    </span>
                                    <ul>

                                        <?php
                                        foreach ($country as $key => $value) {
                                            echo "<li>";
                                            $checked = false;
                                            foreach ($countryFilter as $k => $v) {
                                                if ($value->id == $v->country_id) {
                                                    $checked = true;
                                                    break;
                                                }
                                            }
                                            ?>
                                            <span>
        <?php echo form_checkbox(array('name' => 'country[]', 'class' => 'sel_country_' . $value->id, 'value' => $value->id, 'checked' => $checked)); ?>
                                                <label>&nbsp; <?php echo $value->country; ?></label>
                                            </span>
                                            <ul>
        <?php
        foreach ($value->province as $k => $v) {
            foreach ($provinceFilter as $eachProvince) {
                if ($eachProvince->province_id == $v->id) {
                    $checked = true;
                    break;
                }
            }
            ?>	


                                                    <li>
                                                        <span>
                                        <?php echo form_checkbox(array('name' => 'province[]', 'class' => 'country_' . $value->id, 'value' => $v->id, 'checked' => $checked));
                                        ?>
                                                            <label>&nbsp;<?php echo $v->province; ?></label>
                                                        </span>

                                                    </li>
        <?php } ?>
                                            </ul>



                                    </li> <?php } ?>
                            </ul>
                        </li>
                    </ul>	
                    </li>


                    <li><span>By Relationship Status</span>
                        <ul>
                            <li ><span>
                                        <?php echo form_checkbox('all_relationship', 'ALL'); ?>
                                    <label >&nbsp; Select All</label>
                                </span>
                                <ul id='relationship_cont'>
                                        <?php
                                        foreach ($relationship as $key => $value) {
                                            $checked = false;
                                            $checked = false;
                                            foreach ($relationshipFilter as $k => $v) {
                                                if ($v->relationship_id == $value->id) {
                                                    $checked = true;
                                                    break;
                                                }
                                            }
                                            ?>
                                        <li><span>
                                                <?php echo form_checkbox(array('name' => 'relationship[]', 'value' => $value->id, 'checked' => $checked, 'class' => 'checkthis')) ?>
                                                <label >&nbsp; <?php echo $value->relationship_label; ?></label>
                                            </span></li>
                                            <?php } ?>
                                </ul>
                            </li>
                        </ul>			
                    </li>

                    <li><span>By Family Status</span>
                        <ul>
                            <li ><span>
    <?php echo form_checkbox('all_family_status', 'ALL'); ?>
                                    <label >&nbsp; Select All</label>
                                </span>
                                <ul id='family_status_cont'>
    <?php
    foreach ($familyStatus as $key => $value) {


        $checked = false;
        foreach ($familyStatusFilter as $k => $v) {
            if ($v->family_status_id == $value->id) {
                $checked = true;
                break;
            }
        }
        ?>
                                        <li><span>
                                        <?php echo form_checkbox(array('name' => 'family_status[]', 'value' => $value->id, 'checked' => $checked, 'class' => 'checkthis')) ?>
                                                <label >&nbsp; <?php echo $value->family_status_label; ?></label>
                                            </span></li>
    <?php } ?>
                                </ul>
                            </li>
                        </ul>			
                    </li>			



                    <li><span>By Education Level</span>
                        <ul>
                            <li ><span>
                                    <?php echo form_checkbox('all_education', 'ALL'); ?>
                                    <label >&nbsp; Select All</label>
                                </span>
                                <ul id='education_cont'>
    <?php
    foreach ($education as $key => $value) {
        $checked = false;
        foreach ($educationFilter as $k => $v) {
            if ($v->education_id == $value->id) {
                $checked = true;
                break;
            }
        }
        ?>
                                        <li><span>
                                        <?php echo form_checkbox(array('name' => 'education[]', 'value' => $value->id, 'checked' => $checked, 'class' => 'checkthis')) ?>
                                                <label >&nbsp; <?php echo $value->edu_level; ?></label>
                                            </span></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>			
                    </li>

                    <li><span>By Income Group</span>
                        <ul>
                            <li ><span>
                                    <?php echo form_checkbox('all_income', 'ALL'); ?>
                                    <label >&nbsp; Select All</label>
                                </span>
                                <ul id='income_cont'>
                                            <?php
                                            foreach ($income as $key => $value) {
                                                $checked = false;
                                                foreach ($incomeGroupFilter as $k => $v) {
                                                    if ($v->income_group_id == $value->id) {
                                                        $checked = true;
                                                        break;
                                                    }
                                                }
                                                ?>
                                        <li><span>
        <?php echo form_checkbox(array('name' => 'income[]', 'value' => $value->id, 'checked' => $checked, 'class' => 'checkthis')) ?>
                                                <label >&nbsp; <?php echo $value->label; ?></label>
                                            </span></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>			
                    </li>


                    <li><span>By Job Function</span>
                        <ul>
                            <li ><span>
                                    <?php echo form_checkbox('all_job_function', 'ALL'); ?>
                                    <label >&nbsp; Select All</label>
                                </span>
                                <ul id='job_function_cont'>
                                    <?php
                                    foreach ($jobFunction as $key => $value) {
                                        $checked = false;
                                        foreach ($jobFunctionFilter as $k => $v) {
                                            if ($v->job_function_id == $value->id) {
                                                $checked = true;
                                                break;
                                            }
                                        }
                                        ?>
                                        <li><span>
        <?php echo form_checkbox(array('name' => 'job_function[]', 'value' => $value->id, 'checked' => $checked, 'class' => 'checkthis')) ?>
                                                <label >&nbsp; <?php echo $value->job_function; ?></label>
                                            </span></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>			
                    </li>

                                    <?php // JOB STATUS ?>		
                    <li><span>By Job Status</span>
                        <ul>
                            <li ><span>
                                    <?php echo form_checkbox('all_job_status', 'ALL'); ?>
                                    <label >&nbsp; Select All</label>
                                </span>
                                <ul id='job_status_cont'>
                                            <?php
                                            foreach ($jobStatus as $key => $value) {
                                                $checked = false;
                                                foreach ($jobStatusFilter as $k => $v) {
                                                    if ($v->job_status_id == $value->id) {
                                                        $checked = true;
                                                        break;
                                                    }
                                                }
                                                ?>
                                        <li><span>
        <?php echo form_checkbox(array('name' => 'job_status[]', 'value' => $value->id, 'checked' => $checked, 'class' => 'checkthis')) ?>
                                                <label >&nbsp; <?php echo $value->job_status; ?></label>
                                            </span></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>			
                    </li>




                    <li><span>By Interest</span>
                        <ul>
                            <li>
                                <span>
                                    <?php echo form_checkbox(array('class' => 'all_interest_category', 'value' => 'ALL')); ?>
                                    <label>&nbsp; Select All</label>
                                </span>
                                <ul>
                                    <?php
                                    foreach ($interestCategory as $key => $value) {
                                        echo "<li>";
                                        $checked = false;
                                        ?>
                                        <span>
                        <?php echo form_checkbox(array('name' => 'interest_category[]', 'value' => $value->id, 'class' => 'sel_interestcat_' . $value->id)); ?>
                                            <label>&nbsp; <?php echo $value->name; ?></label>
                                        </span>
                                        <ul>
                                        <?php
                                        foreach ($value->interest as $k => $v) {

                                            $checked = false;
                                            foreach ($interestFilter as $eachInterest) {
                                                if ($eachInterest->interest_id == $v->id) {
                                                    $checked = true;
                                                    break;
                                                }
                                            }
                                            ?>	


                                                <li>
                                                    <span>
                                                    <?php echo form_checkbox(array('name' => 'interest[]', 'value' => $v->id, 'class' => 'interest_' . $value->id, 'checked' => $checked));
                                                    ?>
                                                        <label>&nbsp;<?php echo $v->interest; ?></label>
                                                    </span>

                                                </li>
        <?php } ?>
                                        </ul>



                                </li> <?php } ?>
                        </ul>
                    </li>
                    </ul>	
                    </li>



                    </ul>
                </div>
            </div>

        
                                    <?php
                                    echo form_submit(array('name' => 'Submit', 'value' => 'Submit', 'class' => 'bluebtn', 'style' => 'margin-bottom:30px'));
                                    echo form_close();
                                    ?>	

			</div>		
		</div>
                                        <?php
                                    } elseif ($action == FILTERQUES) {
                                        ?>
    <div class="middle">
        <div class="container">
            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility visactive">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
                <div class="filterpage custinput">
                    <h3>Filter Question</h3>
                    <p>Choose your target audience by adding filter question. The filter question will be asked before the Poll begins. The user is qualified to answer the Poll based on 
                        the reply to the filter question.</p>



    <!-- <p>
    <input class="logininp" type="text" placeholder="Add filter question">
    </p>

    <p>
    <input class="logininp" type="text" placeholder="Add options">
    </p>-->

                    <div class="draftpage" style="margin-top:0px; margin-bottom:15px">
                        <p><a href="<?php echo $this->config->item('base_url'); ?>/poll/createPoll/ADD_FILTER_QUESTION/<?php echo $this->uri->segment(4); ?>"><img align="absmiddle" src="<?php echo $this->config->item('base_url') ?>/assets/images/add.png" alt=""> &nbsp; Add Filter Question</a></p>

    <?php if (count($filter_questions) > 0) { ?>

                            <div class="draftitle">Filter Question List</div>
                            <ul class="altbg">
        <?php
        $i = 1;
        foreach ($filter_questions as $key => $value) {
            $background = '';
            if ($i % 2 != 0)
                $background = 'background-color: rgb(232, 243, 250);'
                ?>
                                    <li style="<?php echo $background; ?>"><a href="<?php echo $this->config->item('base_url'); ?>/poll/createPoll/EDIT_FILTER_QUESTION/<?php echo $value->id; ?>/<?php echo $this->uri->segment(4); ?>"><?php
                echo $value->question;
                ?></a></li>
            <?php $i++;
        } ?>

                            </ul>
    <?php } ?>






                    </div>

                    <h3>Visibility of Poll results</h3>
                    <p>
    <?php
    echo form_open("poll/savePollFinal/" . $this->uri->segment(4));

    if ($pollInfo->visibility == 'PUBLIC')
        $checked = true;
    else
        $checked = false;
    ?>
    <?php echo form_radio(array('name' => 'visibility', 'value' => 'PUBLIC', 'checked' => $checked, 'data-validate' => 'required')); ?>
                        <label for="public">&nbsp; Public</label>
                        &nbsp; &nbsp;
    <?php echo form_radio(array('name' => 'visibility', 'value' => 'PRIVATE', 'checked' => !$checked, 'data-validate' => 'required')); ?>
                        <label for="private">&nbsp; Private</label>

                    </p>
                    <p><a href="javascript:void(0)" onclick="saveFilter('DRAFT')" id="mode" value="DRAFT" class="bluebtn">Save as Draft</a> &nbsp; <a href="javascript:void(0)" id="mode" value="PAYMENT" class="bluebtn" onclick="saveFilter('PAYMENT')" >Proceed to Payment</a>
                        <input type="hidden" name="save_type" value="" />
                    </p>
    <?php echo form_close(); ?>
                </div>
            </div>		
        </div>

    </div>

                            <?php
                        }
                        elseif ($action == ADD_FILTER_QUESTION) {
                            ?>

    <div class="middle">		
        <div class="container">
            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
    <?php echo form_open('poll/addFilterQuestion/' . $this->uri->segment(4), array('name' => 'add_filter_question', 'id' => 'add_filter_question', 'data-validate' => 'required')); ?>
                <div class="filterpage custinput">
                    <h3>Questions</h3>
                    <p>
    <?php echo form_input(array('name' => 'question', 'id' => 'question', 'class' => 'logininp', 'data-validate' => 'required,checkFilterOptCount')); ?>
                    </p>
                    <h3>Answer is required</h3>
                    <p>
    <?php echo form_radio(array('name' => 'required', 'value' => 'Y', 'data-validate' => 'required')); ?>
                        <label for="radio-44">&nbsp; Yes</label>
                        &nbsp; &nbsp;
    <?php echo form_radio(array('name' => 'required', 'value' => 'N', 'data-validate' => 'required')); ?>
                        <label for="radio-45">&nbsp; No</label>
                    </p>
                    <h3>Question Type <span class="graytxt medfont">User may choose one option</span></h3>
                    <div class="tabbing">
                        <div id="horizontalTab">
                            <ul>
                                <li><a href="#single" id='SINGLE_SEL' class='question_type'>Single</a></li>
                                <li><a href="#multiple" id='MULTIPLE_SEL' class='question_type'>Multiple</a></li>
                            </ul>
                            <div id="single">
                                <div class="maintab">
                                    <div class="optcol">
                                        <h3>Option</h3>
                                        <ul class="snglist">
                                            <li>
    <?php echo form_input(array('name' => 'filter_sng[]', 'class' => 'filter_sng_option filter_sng_option_1 ', 'value' => 'Yes', 'order' => '1', 'type' => 'hidden')) . form_radio(array('class' => 'filter_sng_option filter_sng_option_1 ', 'order' => '1')); ?>
                                                <label >&nbsp; Yes</label>
                                            </li>
                                            <li>
                    <?php echo form_input(array('name' => 'filter_sng[]', 'class' => 'filter_sng_option filter_sng_option_2 ', 'value' => 'No', 'order' => '2', 'type' => 'hidden')) . form_radio(array('class' => 'filter_sng_option filter_sng_option_2 ', 'order' => '2')); ?>
                                                <label >&nbsp; No</label>
                                            </li>			
                                        </ul>
                                    </div>
                                    <div class="sngoptcol">
                                        <h3>Allow to Continue</h3>
                                        <ul class="sngcontlist">
                                            <li>
    <?php
    echo form_radio(array('name' => 'filter_sng_continue_1', 'value' => 'Y', 'class' => 'filter_sng_continue filter_sng_continue_1', 'data-validate' => 'required'));
    ?>
                                                <label >&nbsp; Y</label>
                                                &nbsp; &nbsp; &nbsp;
    <?php
    echo form_radio(array('name' => 'filter_sng_continue_1', 'value' => 'N', 'class' => 'filter_sng_continue filter_sng_continue_1', 'data-validate' => 'required'));
    ?>
                                                <label >&nbsp; N</label>
                                            </li>
                                            <li>
    <?php
    echo form_radio(array('name' => 'filter_sng_continue_2', 'value' => 'Y', 'class' => 'filter_sng_continue filter_sng_continue_2', 'data-validate' => 'required'));
    ?>
                                                <label >&nbsp; Y</label>
                                                &nbsp; &nbsp; &nbsp;
                <?php
                echo form_radio(array('name' => 'filter_sng_continue_2', 'value' => 'N', 'class' => 'filter_sng_continue filter_sng_continue_2', 'data-validate' => 'required'));
                ?>
                                                <label >&nbsp; N</label>
                                            </li>
                                        </ul>
                                    </div>
                        <?php
                        echo form_hidden('filter_sng_opt_count', 2);
                        ?>
                                    <p style="margin-bottom:10px;"><a id='filter_sng_add_answer'><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url'); ?>/assets/images/add.png"> &nbsp; Add Option</a></p>
                                    <p>
                                        <input class="logininp" type="text" placeholder="Add options" id='filter_sng_add_answer_value'>
                                    </p>
                                    <!--p><a href="#" class="bluebtn">Preview</a> &nbsp; <a class="bluebtn" href="#">Save</a></p-->
                                </div>
                            </div>
                            <div id="multiple">
                                <div class="maintab">
                                    <div class="optcol">
                                        <h3>Option</h3>
                                        <ul class="mltlist">
                                            <li>
    <?php echo form_input(array('name' => 'filter_mlt[]', 'class' => 'filter_mlt_option filter_mlt_option_1 ', 'value' => 'Yes', 'order' => '1', 'type' => 'hidden')) . form_checkbox(array('class' => 'filter_mlt_option filter_mlt_option_1 ', 'order' => '1',)); ?>
                                                <label >&nbsp; Yes</label>
                                            </li>
                                            <li>
                                                <?php echo form_input(array('name' => 'filter_mlt[]', 'class' => 'filter_mlt_option filter_mlt_option_2 ', 'value' => 'No', 'order' => '2', 'type' => 'hidden')) . form_checkbox(array('class' => 'filter_mlt_option filter_mlt_option_2 ', 'order' => '2')); ?>
                                                <label >&nbsp; No</label>
                                            </li>			
                                        </ul>
                                    </div>
                                    <div class="mltoptcol">
                                        <h3>Allow to Continue</h3>
                                        <ul class="mltcontlist">
                                            <li>
    <?php
    echo form_radio(array('name' => 'filter_mlt_continue_1', 'value' => 'Y', 'class' => 'filter_mlt_continue filter_mlt_continue_1', 'data-validate' => 'required'));
    ?>
                                                <label >&nbsp; Y</label>
                                                &nbsp; &nbsp; &nbsp;
                                                <?php
                                                echo form_radio(array('name' => 'filter_mlt_continue_1', 'value' => 'N', 'class' => 'filter_mlt_continue filter_mlt_continue_1', 'data-validate' => 'required'));
                                                ?>
                                                <label >&nbsp; N</label>
                                            </li>
                                            <li>
                                                <?php
                                                echo form_radio(array('name' => 'filter_mlt_continue_2', 'value' => 'Y', 'class' => 'filter_mlt_continue filter_mlt_continue_2', 'data-validate' => 'required'));
                                                ?>
                                                <label >&nbsp; Y</label>
                                                &nbsp; &nbsp; &nbsp;
                                                <?php
                                                echo form_radio(array('name' => 'filter_mlt_continue_2', 'value' => 'N', 'class' => 'filter_mlt_continue filter_mlt_continue_2', 'data-validate' => 'required'));
                                                ?>
                                                <label >&nbsp; N</label>
                                            </li>
                                        </ul>
                                    </div>
    <?php
    echo form_hidden('filter_mlt_opt_count', 2);
    ?>
                                    <p style="margin-bottom:10px;"><a id='filter_mlt_add_answer'><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url'); ?>/assets/images/add.png"> &nbsp; Add Option</a></p>
                                    <p>
                                        <input class="logininp" type="text" placeholder="Add options" id='filter_mlt_add_answer_value'>
                                    </p>
                                    <!--p><a href="#" class="bluebtn">Preview</a> &nbsp; <a class="bluebtn" href="#">Save</a></p-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php
    echo form_hidden(array('type' => 'SINGLE'));
    echo form_submit(array('name' => 'filter_question_submit', 'value' => 'submit', 'class' => 'bluebtn'));

    echo form_close();
    ?>	

            </div>
        </div>			
    </div>	
                                                <?php
                                            } elseif ($action == EDIT_FILTER_QUESTION) {
                                                ?>
    <div class="middle">
        <div class="container">
            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility">Visibility</div>
                    <div class="payment">Payment</div>
                </div>
                                                <?php echo form_open('poll/updateFilterQuestion/' . $this->uri->segment(4) . '/' . $this->uri->segment(5), array('name' => 'add_filter_question', 'id' => 'add_filter_question')); ?>
                <div class="filterpage custinput">
                    <h3>Questions</h3>
                    <p>
                                                <?php echo form_input(array('name' => 'question', 'id' => 'question', 'value' => $filter_question_detail[0]->question, 'class' => 'logininp', 'data-validate' => 'required,checkFilterOptCount')); ?>
                    </p>
                    <h3>Answer is required</h3>
    <?php
    $checked = true;
    if ($filter_question_detail[0]->required == 'Y')
        $checked = true;
    else
        $checked = false;
    ?>

                    <p>
                                                <?php echo form_radio(array('name' => 'required', 'value' => 'Y', 'checked' => $checked, 'data-validate' => 'required')); ?>
                        <label for="radio-44">&nbsp; Yes</label>
                        &nbsp; &nbsp;
    <?php echo form_radio(array('name' => 'required', 'value' => 'N', 'checked' => !$checked, 'data-validate' => 'required')); ?>
                        <label for="radio-45">&nbsp; No</label>
                    </p>
                    <h3>Question Type <span class="graytxt medfont">User may choose one option</span></h3>
                    <div class="tabbing">
                        <div id="horizontalTab">
                            <ul>
                                <li><a href="#single" id='SINGLE_SEL' class='question_type'>Single</a></li>
                                <li><a href="#multiple" id='MULTIPLE_SEL' class='question_type'>Multiple</a></li>
                            </ul>

    <?php $type = $filter_question_detail[0]->type; ?>

                            <div id="single" style="<?php echo $display = ($type) == 'SINGLE' ? 'block' : 'none'; ?>">
                                <div class="maintab">
                                    <div class="optcol">
                                        <h3>Option</h3>
                                        <ul class="snglist">


                <?php
                if ($type == 'SINGLE') {

                    foreach ($filter_question_detail as $key => $value) {
                        ?>
                                                    <li>
            <?php echo form_input(array('name' => 'filter_sng[]', 'class' => 'filter_sng_option filter_sng_option_' . $key, 'value' => $value->answer, 'order' => $key, 'type' => 'hidden')) . form_radio(array('class' => 'filter_sng_option filter_sng_option_' . $key, 'order' => $key)); ?>
                                                        <label >&nbsp; <?php echo $value->answer; ?></label>
                                                    </li>		
        <?php
        }

        $sngcounter = count($filter_question_detail);
    } else {
        ?>
                                                <li>
                    <?php echo form_input(array('name' => 'filter_sng[]', 'class' => 'filter_sng_option filter_sng_option_1 ', 'value' => 'Yes', 'order' => '1', 'type' => 'hidden')) . form_radio(array('class' => 'filter_sng_option filter_sng_option_1 ', 'order' => '1')); ?>
                                                    <label >&nbsp; Yes</label>
                                                </li>
                                                <li>
                            <?php echo form_input(array('name' => 'filter_sng[]', 'class' => 'filter_sng_option filter_sng_option_2 ', 'value' => 'No', 'order' => '2', 'type' => 'hidden')) . form_radio(array('class' => 'filter_sng_option filter_sng_option_2 ', 'order' => '2')); ?>
                                                    <label >&nbsp; No</label>
                                                </li> 
                        <?php
                        $sngcounter = 2;
                    }
                    ?>
                                        </ul>
                    <?php
                    echo form_hidden('filter_sng_opt_count', $sngcounter);
                    ?>
                                    </div>
                                    <div class="sngoptcol">
                                        <h3>Allow to Continue</h3>
                                        <ul class="sngcontlist">

    <?php
    if ($type == 'SINGLE') {

        foreach ($filter_question_detail as $key => $value) {

            if ($value->continue_poll == 'Y')
                $checked = true;
            else
                $checked = false;
            ?>
                                                    <li>
            <?php
            echo form_radio(array('name' => 'filter_sng_continue_' . $key, 'value' => 'Y', 'class' => 'filter_sng_continue filter_sng_continue_' . $key, 'checked' => $checked, 'data-validate' => 'required'));
            ?>
                                                        <label >&nbsp; Y</label>
                                                        &nbsp; &nbsp; &nbsp;
            <?php
            echo form_radio(array('name' => 'filter_sng_continue_' . $key, 'value' => 'N', 'class' => 'filter_sng_continue filter_sng_continue_' . $key, 'checked' => !$checked, 'data-validate' => 'required'));
            ?>
                                                        <label >&nbsp; N</label>
                                                    </li>					
                                                    <?php
                                                }
                                            }else {
                                                ?>

                                                <li>
                                                <?php
                                                echo form_radio(array('name' => 'filter_sng_continue_1', 'value' => 'Y', 'class' => 'filter_sng_continue filter_sng_continue_1', 'data-validate' => 'required'));
                                                ?>
                                                    <label >&nbsp; Y</label>
                                                    &nbsp; &nbsp; &nbsp;
                                                <?php
                                                echo form_radio(array('name' => 'filter_sng_continue_1', 'value' => 'N', 'class' => 'filter_sng_continue filter_sng_continue_1', 'data-validate' => 'required'));
                                                ?>
                                                    <label >&nbsp; N</label>
                                                </li>
                                                <li>
                                                    <?php
                                                    echo form_radio(array('name' => 'filter_sng_continue_2', 'value' => 'Y', 'class' => 'filter_sng_continue filter_sng_continue_2', 'data-validate' => 'required'));
                                                    ?>
                                                    <label >&nbsp; Y</label>
                                                    &nbsp; &nbsp; &nbsp;
                                                <?php
                                                echo form_radio(array('name' => 'filter_sng_continue_2', 'value' => 'N', 'class' => 'filter_sng_continue filter_sng_continue_2', 'data-validate' => 'required'));
                                                ?>
                                                    <label >&nbsp; N</label>
                                                </li>

    <?php }
    ?>	  

                                        </ul>
                                    </div>
                                    <p style="margin-bottom:10px;"><a id='filter_sng_add_answer'><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url'); ?>/assets/images/add.png"> &nbsp; Add Option</a></p>
                                    <p>
                                        <input class="logininp" type="text" placeholder="Add options" id='filter_sng_add_answer_value'>
                                    </p>
                                    <!--p><a href="#" class="bluebtn">Preview</a> &nbsp; <a class="bluebtn" href="#">Save</a></p-->
                                </div>
                            </div>
                            <div id="multiple" style="<?php echo $display = ($type) == 'MULTIPLE' ? 'block' : 'none'; ?>">
                                <div class="maintab">
                                    <div class="optcol">
                                        <h3>Option</h3>
                                        <ul class="mltlist">
                                                <?php
                                                if ($type == 'MULTIPLE') {
                                                    foreach ($filter_question_detail as $key => $value) {
                                                        ?>


                                                    <li>
                                                        <?php echo form_input(array('name' => 'filter_mlt[]', 'class' => 'filter_mlt_option filter_mlt_option_' . $key, 'value' => $value->answer, 'order' => $key, 'type' => 'hidden')) . form_checkbox(array('class' => 'filter_mlt_option filter_mlt_option_' . $key, 'order' => $key)); ?>
                                                        <label >&nbsp; <?php echo $value->answer; ?></label>
                                                    </li>

                                                <?php
                                                }
                                                $mltcounter = count($filter_question_detail);
                                            } else {
                                                ?>
                                                <li>
                                                    <?php echo form_input(array('name' => 'filter_mlt[]', 'class' => 'filter_mlt_option filter_mlt_option_1 ', 'value' => 'Yes', 'order' => '1', 'type' => 'hidden')) . form_checkbox(array('class' => 'filter_mlt_option filter_mlt_option_1 ', 'order' => '1')); ?>
                                                    <label >&nbsp; Yes</label>
                                                </li>
                                                <li>
                                                    <?php echo form_input(array('name' => 'filter_mlt[]', 'class' => 'filter_mlt_option filter_mlt_option_2 ', 'value' => 'No', 'order' => '2', 'type' => 'hidden')) . form_checkbox(array('class' => 'filter_mlt_option filter_mlt_option_2 ', 'order' => '2')); ?>
                                                    <label >&nbsp; No</label>
                                                </li>	
                                                    <?php
                                                    $mltcounter = 2;
                                                }
                                                ?>
                                        </ul>
                                                <?php
                                                echo form_hidden('filter_mlt_opt_count', $mltcounter);
                                                ?>

                                    </div>
                                    <div class="mltoptcol">
                                        <h3>Allow to Continue</h3>
                                        <ul class="mltcontlist">
    <?php
    if ($type == 'MULTIPLE') {
        foreach ($filter_question_detail as $key => $value) {

            if ($value->continue_poll == 'Y')
                $checked = true;
            else
                $checked = false;
            ?>
                                                    <li>
            <?php
            echo form_radio(array('name' => 'filter_mlt_continue_' . $key, 'value' => 'Y', 'class' => 'filter_mlt_continue filter_mlt_continue_' . $key, 'checked' => $checked, 'data-validate' => 'required'));
            ?>
                                                        <label >&nbsp; Y</label>
                                                        &nbsp; &nbsp; &nbsp;
            <?php
            echo form_radio(array('name' => 'filter_mlt_continue_' . $key, 'value' => 'N', 'class' => 'filter_mlt_continue filter_mlt_continue_' . $key, 'checked' => !$checked, 'data-validate' => 'required'));
            ?>
                                                        <label >&nbsp; N</label>
                                                    </li>

                                                <?php
                                                }
                                            }
                                            else {
                                                ?>
                                                <li>
                                                    <?php
                                                    echo form_radio(array('name' => 'filter_mlt_continue_1', 'value' => 'Y', 'class' => 'filter_mlt_continue filter_mlt_continue_1 '));
                                                    ?>
                                                    <label >&nbsp; Y</label>
                                                    &nbsp; &nbsp; &nbsp;
                                                <?php
                                                echo form_radio(array('name' => 'filter_mlt_continue_1', 'value' => 'N', 'class' => 'filter_mlt_continue filter_mlt_continue_1 '));
                                                ?>
                                                    <label >&nbsp; N</label>
                                                </li>
                                                <li>
        <?php
        echo form_radio(array('name' => 'filter_mlt_continue_2', 'value' => 'Y', 'class' => 'filter_mlt_continue filter_mlt_continue_2 '));
        ?>
                                                    <label >&nbsp; Y</label>
                                                    &nbsp; &nbsp; &nbsp;
                                                <?php
                                                echo form_radio(array('name' => 'filter_mlt_continue_2', 'value' => 'N', 'class' => 'filter_mlt_continue filter_mlt_continue_2 '));
                                                ?>
                                                    <label >&nbsp; N</label>
                                                </li>

                                        <?php } ?>				




                                        </ul>
                                    </div>
                                    <p style="margin-bottom:10px;"><a id='filter_mlt_add_answer'><img align="absmiddle" alt="" src="<?php echo $this->config->item('base_url'); ?>/assets/images/add.png"> &nbsp; Add Option</a></p>
                                    <p>
                                        <input class="logininp" type="text" placeholder="Add options" id='filter_mlt_add_answer_value'>
                                    </p>
                                    <!--p><a href="#" class="bluebtn">Preview</a> &nbsp; <a class="bluebtn" href="#">Save</a></p-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                                <?php
                                                echo form_hidden(array('type' => $type));
                                                echo form_submit(array('name' => 'filter_question_submit', 'value' => 'submit', 'class' => 'bluebtn'));

                                                echo form_close();
                                                ?>	

            </div>
        </div>		
    </div>
    <script type='text/javascript'>
        $(document).ready(function() {
            $('#<?php echo $type; ?>_SEL').trigger('click');
        });

    </script>	

                                            <?php
                                            } elseif ($action == SAVEPAY) { //Payment and package type will be set here
                                                ?>



    <div class="middle">	
        <div class="container">
            <div class="innerpage pollreg">
                <h1>Create Poll</h1>
                <div class="steppoll">
                    <div class="create_poll">Create Poll</div>
                    <div class="visibility visactive">Visibility</div>
                    <div class="payment payactive">Payment</div>
                </div>
                <div class="packagepage">

                                                <?php echo form_open('/poll/payment/' . $this->uri->segment(4), array("name" => "sel_package")); ?>
                    <h3>Select your package</h3>
                    <div class="packagetitle">
                        <div class="packfirst"> &nbsp; &nbsp; &nbsp;
                            Package</div>
                        <div class="packsec">Baht (THB)</div>
                    </div>
                    <ul class="altbg custinput">

    <?php foreach ($package as $value) { ?>

                            <li>
                                <div class="packfirst">
        <?php echo form_radio(array("name" => "package", "value" => $value->id, 'data-validate' => 'required')); ?>
                                    <label >&nbsp; <?php echo $value->name; ?></label>
                                </div>
                                <div class="packsec"><?php echo ($value->amount - round($value->amount * $value->discount / 100)); ?></div>
                            </li>	

    <?php } ?>

                    </ul>
                    <p><strong>Note:</strong> Price given is without VAT</p>
                    <p><?php echo form_submit(array('name' => 'savepay_submit', 'value' => "Publish", 'class' => 'bluebtn')); ?></p>  
                <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>	






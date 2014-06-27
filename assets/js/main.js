$(document).ready(function(){
		
	window.base_url = 'http://localhost/thaipolltest/';
				   
	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 300) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

	/*** BASED ON QUESTION TYPE OPEN THE REQUIRED QUESTION BOX ***/
	
		$('.question_type').click(function(){							// NOT SURE IF THIS CODE IS USED, BUT WHO WANTS TO RISK ITS REMOVAL	??
			
			id = $(this).attr('id');
			//$('.question_type_box').css('display','none');
			//$('div[id="'+id+'_box'+'"]').css('display','block');
			
			var id = $(this).attr('id');
			new_id = id.split("_");
			
			$("input[name='type']").val(new_id[0].toUpperCase());
			

		});
		


	/** CODE TO TOGGLE BETWEEN NUMBER AND TEXT ***/
		
	$('input[name="txttype"]').on('ifClicked', function (event) {	// IF QUESTION TYPE IS TEXT, TOGGLE BETWEEN NUMBER AND TEXT
        if(this.value == 'NUMBER'){
			$('#text_number_segment').css('display','block');
			$('input[name="txt_type"]').val('NUMBER');		
		
		}
		else if(this.value == 'TEXT'){								// IF QUESTION TYPE IS TEXT, TOGGLE BETWEEN NUMBER AND TEXT
			$('#text_number_segment').css('display','none');			
			$('input[name="txt_type"]').val('TEXT');		
		}
    });
		
		
	/*** THIS PIECE OF CODE ADDS AN OPTION TO EITHER SINGLE OR MULTIPLE CHOICE QUESTIONS ***/
	
	/** ON CLICK **/
	$('[id$="_add_option"]').click(function(){
	
		id = $(this).attr('id');
		var type = id.split('_');
					
		 var optiontext = $("#"+type[0]+'_add_value').val();
		 
		 
		 if(optiontext == '') {
			
			$("#"+type[0]+'_add_value').notify("Please Enter an Option Value","warn");
			return false;
		 
		 }
		 

	if(type[0] == 'sng'){	
		$("[name='"+type[0]+"_opt_count']").before("<input name='"+type[0]+"[]' class='"+type[0]+"_option' value='"+optiontext+"' type='hidden'/><input type='radio' class='"+type[0]+"_option'/><label>&nbsp;&nbsp;"+optiontext+"</label>&nbsp;&nbsp;&nbsp;");
	} else if(type[0] == 'mlt') {
		$("[name='"+type[0]+"_opt_count']").before("<input name='"+type[0]+"[]' class='"+type[0]+"_option' value='"+optiontext+"' type='hidden'/><input type='checkbox' class='"+type[0]+"_option'/><label>&nbsp;&nbsp;"+optiontext+"</label>&nbsp;&nbsp;&nbsp;");	
	}	
		
		
		
		value = parseInt($("[name='"+type[0]+"_opt_count']").val())+1;
		
		$("[name='"+type[0]+"_opt_count']").val(value);

		order=1;
		$("input[type='hidden']."+type[0]+"_option").each(function(){			
			$(this).attr('order',order);
			$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order);
			
			order++;
		});
		
		
		if(type[0] == 'sng'){	
			order=1;
			$("input[type='radio']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 
				
				
				 $(this).iCheck({
							checkboxClass: 'icheckbox_square-blue',
							radioClass: 'iradio_square-blue',
							increaseArea: '20%' // optional
				 });
			order++;
			});	

			order=1;
			$("input[type='hidden']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 					
			order++;
			});	
		}else if(type[0] == 'mlt'){
		
			order=1;
			$("input[type='checkbox']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 
				
				
				 $(this).iCheck({
							checkboxClass: 'icheckbox_square-blue',
							radioClass: 'iradio_square-blue',
							increaseArea: '20%' // optional
				 });
				 order++;
			});	


			order=1;
			$("input[type='hidden']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 					
			order++;
			});	
		}	
		
		$("input[type='hidden']."+type[0]+"_option ~ label img").remove();
		//$("input[type='hidden']."+type[0]+"_option ~ label").not(":eq(0),:eq(1)").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');
		$("input[type='hidden']."+type[0]+"_option ~ label").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');	

		
		
	});
	
	/** ON ENTER **/
	$('[id$="_add_value"]').keyup(function(e){
	
		if(e.which != 13)
			return false;
		
		id = $(this).attr('id');
		var type = id.split('_');
					
		 var optiontext = $("#"+type[0]+'_add_value').val();
		 
		 
		 if(optiontext == '') {
			
			$("#"+type[0]+'_add_value').notify("Please Enter an Option Value","warn");
			return false;
		 
		 }
		 

	if(type[0] == 'sng'){	
		$("[name='"+type[0]+"_opt_count']").before("<input name='"+type[0]+"[]' class='"+type[0]+"_option' value='"+optiontext+"' type='hidden'/><input type='radio' class='"+type[0]+"_option'/><label>&nbsp;&nbsp;"+optiontext+"</label>&nbsp;&nbsp;&nbsp;");
	} else if(type[0] == 'mlt') {
		$("[name='"+type[0]+"_opt_count']").before("<input name='"+type[0]+"[]' class='"+type[0]+"_option' value='"+optiontext+"' type='hidden'/><input type='checkbox' class='"+type[0]+"_option'/><label>&nbsp;&nbsp;"+optiontext+"</label>&nbsp;&nbsp;&nbsp;");	
	}	
		
		
		
		value = parseInt($("[name='"+type[0]+"_opt_count']").val())+1;
		
		$("[name='"+type[0]+"_opt_count']").val(value);

		order=1;
		$("input[type='hidden']."+type[0]+"_option").each(function(){			
			$(this).attr('order',order);
			$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order);
			
			order++;
		});
		
		
		if(type[0] == 'sng'){	
			order=1;
			$("input[type='radio']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 
				
				
				 $(this).iCheck({
							checkboxClass: 'icheckbox_square-blue',
							radioClass: 'iradio_square-blue',
							increaseArea: '20%' // optional
				 });
			order++;
			});	

			order=1;
			$("input[type='hidden']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 					
			order++;
			});	
		}else if(type[0] == 'mlt'){
		
			order=1;
			$("input[type='checkbox']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 
				
				
				 $(this).iCheck({
							checkboxClass: 'icheckbox_square-blue',
							radioClass: 'iradio_square-blue',
							increaseArea: '20%' // optional
				 });
				 order++;
			});	


			order=1;
			$("input[type='hidden']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 					
			order++;
			});	
		}	
		
		$("input[type='hidden']."+type[0]+"_option ~ label img").remove();
		//$("input[type='hidden']."+type[0]+"_option ~ label").not(":eq(0),:eq(1)").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');
		$("input[type='hidden']."+type[0]+"_option ~ label").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');		

	});	
	
	
	
	
	
	
	
	
	
	

	/*** WHEN THE DOM LOADS MARK THE REQUIRED SINGLE OR MUTIPLE CHOICE POINTS WITH A DELETE BUTTON ***/				
	//$("input[type='hidden'].sng_option ~ label").not(":eq(0),:eq(1)").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');
	//$("input[type='hidden'].mlt_option ~ label").not(":eq(0),:eq(1)").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');
	$("input[type='hidden'].sng_option ~ label").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');
	$("input[type='hidden'].mlt_option ~ label").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');	
	
		
		
	/*** CODE TO HANDLE THE DELETION OPTION FOR SINGLE OR MULTIPLE QUESTIONS' OPTIONS ***/

	$(document).on('click','input[type=\'hidden\'].sng_option ~ label img,input[type=\'hidden\'].mlt_option ~ label img',function(){			

		parent_label = $(this).parent();
		
		preceding_div = parent_label.prev();
		
		preceding_input = preceding_div.prev();
			
		input_class = preceding_input.attr('class');
		
		var type = input_class.split('_');
		
		parent_label.remove();
		
		preceding_div.remove();
		
		preceding_input.remove();

		if(type[0] == 'sng'){	
			order=1;
			$("input[type='radio']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 
				
				
				 $(this).iCheck({
							checkboxClass: 'icheckbox_square-blue',
							radioClass: 'iradio_square-blue',
							increaseArea: '20%' // optional
				 });
			order++;
			});	

			order=1;
			$("input[type='hidden']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 					
			order++;
			});				
		}else if(type[0] == 'mlt'){
		
			order=1;
			$("input[type='checkbox']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 
				
				
				 $(this).iCheck({
							checkboxClass: 'icheckbox_square-blue',
							radioClass: 'iradio_square-blue',
							increaseArea: '20%' // optional
				 });
				 order++;
			});	


			order=1;
			$("input[type='hidden']."+type[0]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[0]+"_option "+type[0]+"_option_"+order); 					
			order++;
			});	
		}			

		count = parseInt($('[name="'+type[0]+'_opt_count"]').val()) - 1; 
		$('[name="'+type[0]+'_opt_count"]').val(count) ;

	})
		
	
	/*** CODE TO HANDLE THE ADDTION OF A SUBQUESTION ***/	
		
	$('#scl_add_ques').click(function(){
	
		var scl_ques_val = $('#scl_add_ques_value').val();
		
		if(scl_ques_val == ''){
			
			$('#scl_add_ques_value').notify("Please enter a subquestion","warn");
			return false;
		}
		
		
		
		$("#subquestions_list").append('<input type="hidden" name="scl_sub_ques[]" class="scl_sub_ques" value="'+$('#scl_add_ques_value').val()+'" /><span>'+$('#scl_add_ques_value').val()+'<img src="'+window.base_url+'/assets/images/delete15.png"/></span><br/>');		
		count = parseInt($('[name="scl_sub_ques_count"]').val());
		count++;

		$('[name="scl_sub_ques_count"]').val(count);
	
	})	
	
	/*** CODE TO HANDLE THE DELETION OF A SUBQUESTION ***/	
	
	$(document).on('click','#subquestions_list span img',function(){
	

		span = $(this).parent();
		br = span.next();	
		input = span.prev();
		
		span.remove();
		br.remove();
		input.remove();
	
	
		count = parseInt($('[name="scl_sub_ques_count"]').val());
		count--;
		$('[name="scl_sub_ques_count"]').val(count);
	})
		

		/*** THIS PIECE OF CODE ADDS AN OPTION TO EITHER SINGLE OR MULTIPLE CHOICE FILTER  QUESTIONS ***/
	
		$('[id$="_add_answer"]').click(function(){				
		
			
			id = $(this).attr('id');
			var type = id.split('_');
			
			if(type[1] == 'sng'){
				inputtype = 'radio';
			}
			else if(type[1] == 'mlt')
			{
				inputtype = 'checkbox';
			}
			
			
			var optiontext = $("#filter_"+type[1]+"_add_answer_value").val();
				
			  if(optiontext == '') {
				
				$("#filter_"+type[1]+"_add_answer_value").notify("Please Enter an Option Value","warn");
				return false;
			 
			 }			
			
			
			$("."+type[1]+"list").append('<li><input name="filter_'+type[1]+'[]" class="filter_'+type[1]+'_option" type="hidden" value="'+$("#filter_"+type[1]+"_add_answer_value").val()+'"/><input type="'+inputtype+'" class="filter_'+type[1]+'_option"/><label>&nbsp;'+$("#filter_"+type[1]+"_add_answer_value").val()+'</label></li>')
			
			
			$("."+type[1]+"optcol ."+type[1]+"contlist").append('<li><input type="radio" class="filter_'+type[1]+'_continue" value="Y"  data-validate="required"/><label>&nbsp;&nbsp;&nbsp;Y&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="radio" class="filter_'+type[1]+'_continue" value="N" data-validate="required"/><label>&nbsp;&nbsp;&nbsp;N&nbsp;</label></li>')
						
			value = parseInt($("[name='filter_"+type[1]+"_opt_count']").val())+1;
			
			$("[name='filter_"+type[1]+"_opt_count']").val(value);		
			
			var children = $('.'+type[1]+'list '+'input[type="hidden"].filter_'+type[1]+'_option');	
			order = 1;
			$.each(children,function(index,value){
			
				$(value).attr('class','filter_'+type[1]+"_option "+"filter_"+type[1]+"_option_"+order);
				$(value).attr('order',order);
				order++;
			
			})
			
			if(type[1] == 'sng'){
				inputtype = 'radio';
			}
			else if(type[1] == 'mlt')
			{
				inputtype = 'checkbox';
			}
				
			var children = $('.'+type[1]+'list '+'input[type="'+inputtype+'"].filter_'+type[1]+'_option');	
			order = 1;
			$.each(children,function(index,value){
			
				$(value).attr('class','filter_'+type[1]+"_option "+"filter_"+type[1]+"_option_"+order);
				$(value).attr('order',order);
				
				
				$(value).iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%'
				});
				
				order++;	
			})
			var children = $('.'+type[1]+'contlist '+'li');	
			order = 1;
			$.each(children,function(index,value){
			
			inputs = $(value).children('input[type="radio"]')
			
			$.each(inputs,function(i,v){
			
			$(v).attr('class','filter_'+type[1]+'_continue '+'filter_'+type[1]+'_continue_'+order)
			$(v).attr('name','filter_'+type[1]+'_continue_'+order)
			
			$(v).iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%'
				});
			
			})
			order++;	
		})

			//$("input[type='hidden'].filter_"+type[1]+"_option ~ label img").remove();
			//$("input[type='hidden'].filter_"+type[1]+"_option ~ label").not(":eq(0),:eq(1)").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');
			
			$("input[type='hidden'].filter_"+type[1]+"_option ~ label img").remove();
			$("input[type='hidden'].filter_"+type[1]+"_option ~ label").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');			
			
		});
		
		
	/** WHEN THE DOM LOADS MARK ALL REMOVABLE OPTIONS FOR FILTER QUESTIONS WITH A DELETE IMAGE **/
		//$("input[type='hidden'].filter_sng_option ~ label").not(":eq(0),:eq(1)").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');
		//$("input[type='hidden'].filter_mlt_option ~ label").not(":eq(0),:eq(1)").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');
		$("input[type='hidden'].filter_sng_option ~ label").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');
		$("input[type='hidden'].filter_mlt_option ~ label").append('<img src="'+window.base_url+'/assets/images/delete15.png"/>');	
		

	

	/*** CODE TO HANDLE THE REMOVE BUTTON FOR OPTIONS IN FILTER QUESTIONS ****/

	$(document).on('click','input[type=\'hidden\'].filter_sng_option ~ label img,input[type=\'hidden\'].filter_mlt_option ~ label img',function(){
		parent_label = $(this).parent();
		
		preceding_div = parent_label.prev();
		
		preceding_input = preceding_div.prev();	
		
		input_class = preceding_input.attr('class');
		
		li = preceding_input.parent();
		
		index = $(li).index();
		
		li.remove();
		
		var type = input_class.split('_');

		parent_label.remove();
		
		preceding_div.remove();
		
		preceding_input.remove();
		
		
		$('.'+type[1]+'contlist li:eq('+index+')').remove();
		
		
			
		if(type[1] == 'sng'){	
			order=1;
			$("input[type='radio']."+type[1]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[1]+"_option "+type[1]+"_option_"+order); 
				
				
				 $(this).iCheck({
							checkboxClass: 'icheckbox_square-blue',
							radioClass: 'iradio_square-blue',
							increaseArea: '20%' // optional
				 });
			order++;
			});	

			order=1;
			$("input[type='hidden']."+type[1]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[1]+"_option "+type[1]+"_option_"+order); 					
			order++;
			});	
		}else if(type[1] == 'mlt'){
		
			order=1;
			$("input[type='checkbox']."+type[1]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[1]+"_option "+type[1]+"_option_"+order); 
				
				
				 $(this).iCheck({
							checkboxClass: 'icheckbox_square-blue',
							radioClass: 'iradio_square-blue',
							increaseArea: '20%' // optional
				 });
				 order++;
			});	


			order=1;
			$("input[type='hidden']."+type[1]+"_option").each(function(){			
				$(this).attr('order',order);
				$(this).attr('class',type[1]+"_option "+type[1]+"_option_"+order); 					
			order++;
			});	
		}			

		count = parseInt($('[name="filter_'+type[1]+'_opt_count"]').val()) - 1; 
		$('[name="filter_'+type[1]+'_opt_count"]').val(count) ;
	})



	/**** 	SKIP LOGIC JAVASCRIPT HANDLING ****/

	val = $('#dep_questions').val();	
	$("[id^='question_']").css('display','none');
	$('#question_'+val).css('display','block');
	$("[id^='other_questions_']").css('display','none');
	$('#other_questions_'+val).css('display','block');

	$('#dep_questions').change(function(){
		val = $(this).val();
		$("[id^='question_']").css('display','none');
		$('#question_'+val).css('display','block');			
		$("[id^='other_questions_']").css('display','none');
		$('#other_questions_'+val).css('display','block');	
	})



/*** JQUERY CODE FOR HANDING VISIBILITY FORM CHECKBOX	***/

	$("ul[id$='_cont'] li input:checkbox").on('ifClicked',function(){		// Invoked when a subitem of relationshipstatus, familystatus, jobstatus is clicked
	
	
	
	name = $(this).attr('name');
	newname = name.split("[]");
	
	this_checked = !($(this).prop('checked'));
	
	var siblings = $(this).siblings();



	var children = $("ul#"+newname[0]+"_cont li input[type='checkbox']").not(this);

	checked = true;
	
	$.each(children,function(i,val){	
		checked = checked && $(val).prop('checked');
	})

	checked = checked && this_checked;

	
	checkstring = '';
	
	if(checked == true)
		checkstring = 'check';
	else
		checkstring = 'uncheck';
		
	$('[name="all_'+newname[0]+'"]').iCheck(checkstring);	
	
	});
	

	$("[name^='all_']").on('ifClicked',function(){						// Invoked when select all of a Main category is clicked

		name = $(this).attr('name');	
		newname = name.split("all_");

		var children = $("ul#"+newname[1]+"_cont li input[type='checkbox']");

		var checked = !($(this).prop('checked'));

		checkstring = '';
		
		if(checked == true)
			checkstring = 'check';
		else
			checkstring = 'uncheck';

	
		$.each(children,function(i,val){		
			$(val).iCheck(checkstring);
		})
	
	
	})
	
	/*** CODE TO MONITOR ENTIRE COUNTRY CLICKING START **/
	
	$('input[class="all_location"]').on('ifClicked',function(){
		
		main_check = (!$(this).prop('checked'));
		
		var country_children = $('input[class^="sel_country_"]');
		
		checkstring = '';
		
		if(main_check == true)
			checkstring = 'check';
		else
			checkstring = 'uncheck';

		$.each(country_children,function(index,value){
		
		$(value).iCheck(checkstring);
		
		country_class = $(value).attr('class');
		
		country_id = country_class.split('_');
		
		province_children = $('.country_'+country_id[2]);
		
		$.each(province_children,function(i,v){
		
			$(v).iCheck(checkstring);

		})
	})

})




 $('input[class^="sel_country_"]').on('ifClicked',function(){
 
	country_click = (!$(this).prop('checked'));
 
	country_class = $(this).attr('class');
	
	country_id = country_class.split("_");
	
		checkstring = '';
		
		if(country_click == true)
			checkstring = 'check';
		else
			checkstring = 'uncheck';	
			
	
	province_children = $('.country_'+country_id[2]);
	
	$.each(province_children,function(i,v){	
		$(v).iCheck(checkstring);	
	});
	
	
	var checked = true;
	
	checked = checked && country_click;
	
	country_list = $('[class^="sel_country_"]').not(this);
	
	$.each(country_list,function(index,value){		
		checked = checked && $(value).prop('checked'); 
	})
	
	if(checked == true)
		checkstring = 'check';
	else
		checkstring = 'uncheck';

	$('[class="all_location"]').iCheck(checkstring);

 
 })
 
 
 $('[class^="country_"]').on('ifClicked',function(){
 
 
	province_check = (!$(this).prop('checked'));
	
	
	checkstring = '';
	
	if(province_check == true)
		checkstring = 'check';
	else
		checkstring = 'uncheck';	
		
		
	country_class = $(this).attr('class');

	country_id = country_class.split("_");
	
	var siblings = $('.country_'+country_id[1]).not(this);
	
	var checked = true;
	
	checked = checked &&  province_check;
	
	$.each(siblings,function(index,value){		
		
		checked = checked && $(value).prop('checked');
	})
	

	if(checked == true)
		checkstring = 'check';
	else
		checkstring = 'uncheck';
	
	$('.sel_country_'+country_id[1]).iCheck(checkstring);

	
	var checked = true;
	
	country_list = $('[class^="sel_country_"]').not();
	
	$.each(country_list,function(index,value){		
		checked = checked && $(value).prop('checked'); 
	})
	
	if(checked == true)
		checkstring = 'check';
	else
		checkstring = 'uncheck';

	$('[class="all_location"]').iCheck(checkstring);	
	
 
 })
 
 
	var all_countries = $('[class^="sel_country_"]');
		
	country_check = true;
	$.each(all_countries,function(index,value){	
		country_check = country_check && $(value).prop('checked');
	})
	
	if(country_check == true)
		checkstring = 'check';
	else
		checkstring = 'uncheck';	

	$('[class="all_location"]').iCheck(checkstring);


 /*** CODE TO MONITOR ENTIRE COUNTRY CLICKING END **/
	

	
	
	
/*** CODE TO MONITOR ENTIRE INTEREST CLICKING START **/

$('input[class="all_interest_category"]').on('ifClicked',function(){
	
	main_check = (!$(this).prop('checked'));
	
	var interestcat_children = $('input[class^="sel_interestcat_"]');
	
	checkstring = '';
	
	if(main_check == true)
		checkstring = 'check';
	else
		checkstring = 'uncheck';

	$.each(interestcat_children,function(index,value){
	
	$(value).iCheck(checkstring);
	
	interestcat_children_class = $(value).attr('class');
	
	interestcat_children_id = interestcat_children_class.split('_');
	
	interest_children = $('.interest_'+interestcat_children_id[2]);
	
	$.each(interest_children,function(i,v){
	
		$(v).iCheck(checkstring);

	})
})

})




$('input[class^="sel_interestcat_"]').on('ifClicked',function(){

interestcat_click = (!$(this).prop('checked'));

interestcat_class = $(this).attr('class');

interestcat_id = interestcat_class.split("_");

	checkstring = '';
	
	if(interestcat_click == true)
		checkstring = 'check';
	else
		checkstring = 'uncheck';	
		

interest_children = $('.interest_'+interestcat_id[2]);

$.each(interest_children,function(i,v){	
	$(v).iCheck(checkstring);	
});


var checked = true;

checked = checked && interestcat_click;

interestcat_list = $('[class^="sel_interestcat_"]').not(this);

$.each(interestcat_list,function(index,value){		
	checked = checked && $(value).prop('checked'); 
})

if(checked == true)
	checkstring = 'check';
else
	checkstring = 'uncheck';

$('[class="all_interest_category"]').iCheck(checkstring);


})


$('[class^="interest_"]').on('ifClicked',function(){


interest_check = (!$(this).prop('checked'));


checkstring = '';

if(interest_check == true)
	checkstring = 'check';
else
	checkstring = 'uncheck';	
	
	
interest_class = $(this).attr('class');

interestcat_id = interest_class.split("_");

var siblings = $('.interest_'+interestcat_id[1]).not(this);

var checked = true;

checked = checked &&  interest_check;

$.each(siblings,function(index,value){		
	
	checked = checked && $(value).prop('checked');
})


if(checked == true)
	checkstring = 'check';
else
	checkstring = 'uncheck';

$('.sel_interestcat_'+interestcat_id[1]).iCheck(checkstring);


var checked = true;

interestcat_list = $('[class^="sel_interestcat_"]').not();

$.each(interestcat_list,function(index,value){		
	checked = checked && $(value).prop('checked'); 
})

if(checked == true)
	checkstring = 'check';
else
	checkstring = 'uncheck';

$('[class="all_interest_category"]').iCheck(checkstring);	


})


var interestcat_array = new Array();
var interestcat_storage = $('[class^="sel_interestcat_"]');



i=0;
$.each(interestcat_storage,function(index,value){

	interestcat_class = $(value).attr('class');
	
	var interestcat = interestcat_class.split("_");
	
	interestcat_array[i] = interestcat[2];
	
	i++;

})

	$.each(interestcat_array,function(index,value){
	
		var checked = true;
		
		interest_children = $(".interest_"+value);
		
		$.each(interest_children,function(i,v){		
			checked = checked && $(v).prop('checked');
			
		})
		
		
		if(checked == true)
			checkstring = 'check';
		else
			checkstring = 'uncheck';			

		$(".sel_interestcat_"+value).iCheck(checkstring);
	
	})

var checked = true;
$.each(interestcat_array,function(index,value){			
	checked = checked && $(".sel_interestcat_"+value).prop('checked');		
})		
	

	
if(checked == true)
	checkstring = 'check';
else
	checkstring = 'uncheck';			

$(".all_interest_category").iCheck(checkstring);
	
 /*** CODE TO MONITOR ENTIRE INTEREST CLICKING END **/
	


/** CODE TO CHECK IF AT LEAST ONE OPTION HAS BEEN ADDEDD **/



$.verify.addRules({
  checkOptCount: function(r) {

  
  	var type = $("[name='type']").val();
	
	if(type == 'SINGLE'){	
	
		var count = $("[name='sng_opt_count']").val();
	
	}
	else if(type == 'MULTIPLE') {
		var count = $("[name='mlt_opt_count']").val();
	
	}
	
	if(type=='SINGLE' || type=='MULTIPLE'){
	
		if(count == 0){
			$.notify("Please enter at least one option",
				{position:"left"}
			)
			return false;
		}
		else {
			return true;
		}
		
	} else {
		return true;
	}
	
  }
});

	
	
	$.verify.addRules({
	  checkFilterOptCount: function(r) {
	  
		var type = $("[name='type']").val();
		
		if(type == 'SINGLE'){		
			var count = $("[name='filter_sng_opt_count']").val();	
		}
		else if(type == 'MULTIPLE') {
			var count = $("[name='filter_mlt_opt_count']").val();	
		}
		
		if(type=='SINGLE' || type=='MULTIPLE'){
		
			if(count == 0){
				$.notify("Please enter at least one option",
					{position:"left"}
				)
				return false;
			}
			else {
				return true;
			}
			
		} else {
			return true;
		}		
	  }
	});

	
	
$.verify.addRules({
	  checkFileSize: function(r) {

	if (window.File && window.FileReader && window.FileList && window.Blob)
    {
        //get the file size and file type from file input field
        var fsize = $('#image')[0].files[0].size;
       
        if(fsize>1048576) //do something if file size more than 1 mb (1048576)
        {
           $("#image").parent().notify("FileSize Should not exceed 1 MB","warn");
		    return false;
        }else{
            return true;
        }
    }else{
        alert("Please upgrade your browser, because your current browser lacks some new features we need!");
    }	
 }
 
 
});



$.verify.addRules({
	  checkDuplicate: function(r) {
		
		if(	window.questionCheck == false){
			$("#question").parent().notify("A question with the same name already exists","warn");
			return false;
		}
		else
			return true;
			
			
			
 } 
	});

	window.questionCheck = true;
	
	var typingTimer;                //timer identifier
	var doneTypingInterval = 500;  //time in ms, 0.5 second for example
	//on keyup, start the countdown
	$('#question').keyup(function(){
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});

	//on keydown, clear the countdown 
	$('#question').keydown(function(){
		clearTimeout(typingTimer);
	});

	//user is "finished typing," do something
	function doneTyping () {
		$.ajax({	  
		url: window.base_url+"poll/checkQuestion" ,
		data:{pollId: $("[name='poll_id']").val(), question: $("#question").val(), question_id: $("[name='question_id']").val()},
		async:false,
		type: "POST",
		success:function(data){		
			response = jQuery.parseJSON(data);			
			if(response.response == 1){			
				window.questionCheck = false;
			}
			else {
				window.questionCheck = true;		
			}	
		} 
		}) 
	}






		var prevTitle = $('[name="title"]').val();
		
		if(prevTitle != undefined)
			oldLength = prevTitle.length;
		else
			oldLength = 0;
		
		$('[name="title"]').on('input', function() {

			var newTitle = $(this).val();
			
			length = 100;
			
			if(newTitle.length > 100){
				$('[name="title"]').val(window.prevTitle);
				
				$(".character:eq(0)").css('color','red');
				
			}else{
				window.prevTitle = newTitle;
						
				charLeft = 100 - newTitle.length;
				
				window.oldLength = newTitle.length;
				
				$("#100chars").html(charLeft);
				$(".character:eq(0)").css('color','#A1A1A1');

			}
			// do something
		});
	
		var prevDescp = $('[name="descp"]').val();
		
		if(prevDescp != undefined)
			oldDescpLength = prevDescp.length;
		else
			oldDescpLength = 0;
		
		$('[name="descp"]').on('input', function() {

			var newDescp = $(this).val();
			
			length = 100;
			
			if(newDescp.length > 140){
				$('[name="descp"]').val(window.prevDescp);
				
				$(".character:eq(1)").css('color','red');
				
			}else{
				window.prevDescp = newDescp;
						
				charLeft = 140 - newDescp.length;
				
				window.oldDescpLength = newDescp.length;
				
				$("#140chars").html(charLeft);
				$(".character:eq(1)").css('color','#A1A1A1');

			}
			// do something
		});
			
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });




 $('#image').live('change', function(){  
 
	  $body = $("body");
	  var fsize = $('#image')[0].files[0].size; //get file size
      var ftype = $('#image')[0].files[0].type; // get file type
       

        //allow only valid image file types
        switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                 $("#image").parent().notify("Please upload a jpg/png/gif image","warn");
                return false
        }
		
		  if(fsize>1048576)
        {
            $("#image").parent().notify("FileSize Should not exceed 1 MB","warn");
            return false
        }
 
		$body.addClass("loading");
		$('[name="poll_details"]').ajaxSubmit({
		
			data: { ajax_upload: '1' },
			success: function(response){
				newResponse = jQuery.parseJSON(response);
				if(newResponse.error == 0 ){
					$('[name="upl_image"]').val(newResponse.imageName);
					$(".rowfifty img").attr('src',window.base_url+"uploads/"+newResponse.imageName);
				} else {
					$("#image").parent().notify(newResponse.errorMessage,"warn");
				}			
					$("#image").val('');
					$body.removeClass("loading");
			}
			
		});  //Ajax Submit form           
		// return false to prevent standard browser submit and page navigation
		return false;
       
	
	
 
 });
  
	
	
});	// END OF DOM READY



function saveFilter(type){
	$("[name='save_type']").val(type);
	document.forms[3].submit();
}


function saveDraft(pollId){

	var num_questions = $("#num_questions").val();
	num_questions = parseInt(num_questions);

	if(num_questions == 0){

			$.notify("Please Enter at least one question",
			{ position:"left" }
		);

	}else{
		window.location.href= window.base_url+"poll/saveDraft/"+pollId;

	}
}

function preview(pollId){
	var num_questions = $("#num_questions").val();
	num_questions = parseInt(num_questions);

	if(num_questions == 0){

		$.notify("Please Enter at least one question",
			{ position:"left" }
		);

	}else{
	window.location.href= window.base_url+"poll/createPoll/PREVIEW/"+pollId;
	}
}

function pollSubmit(pollId){

	var num_questions = $("#num_questions").val();
	num_questions = parseInt(num_questions);

	if(num_questions == 0){

		$.notify("Please Enter at least one question",
			{ position:"left" }
		);

	}else{
		window.location.href= window.base_url+"poll/createPoll/VISIBILITY/"+pollId;
	}

}

function addSkipLogic(pollId){

	var num_questions = $("#num_questions").val();
	var skip_questions = $("#skip_questions").val();
	num_questions = parseInt(num_questions);
	
		if(num_questions < 2){

		$.notify("Please Enter at least two questions to proceed",
			{ position:"left" }
		);

	}else if(skip_questions < 2){
		$.notify("Skip logic cannot be added to the questions in the List",
			{ position:"left" }
		);
	}
	else{
		window.location.href= window.base_url+"poll/createPoll/SKIP_LOGIC/"+pollId;
	}
	

}







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>WEB SERVICE TEST</title>
</head>
<body>
	<form action="" method="post">
	<table border=0>
		<tr>
			<td> Target </td> <td>:</td>
			<td><input type="text" name="url" value="<?php echo isset($_POST['url'])?$_POST['url']:''?>" size="150">
			</td>
			</tr>
		<tr>
		<td> Params</td>
		<td>:</td>
		<td>
		<input type="text" name="params" value="<?php echo isset($_POST['params'])?$_POST['params']:''?>" size="150">
		</td>
		</tr>
		<tr>
		<td> <input type="submit" name="submit" value="submit">
		</td><td> &nbsp;</td>
		<td><input type="reset" name="reset" value="reset" onclick="window.location=''"></td>
		</tr>
	</table>
	</form>
	<hr/>
</body>
</html>
<?php
if(isset($_POST['submit'])){		
	$paramArr = array();
	if(strlen($_POST['params'])>0){
	$tempParamArr = explode(',',$_POST['params']);
		
		foreach ($tempParamArr as $param){
			$temp = explode(':',$param);	
//			$newTempParam = $temp[0].':'.$temp[1];
//			$paramArr[] =  $newTempParam;
                       
			$paramArr[$temp[0]] =   $temp[1];
		}
		print 'parameters : <pre>';
		print_r($paramArr);
		print '</pre><hr/>';
	}
	else print 'No parameters passed.<hr/>';

//       $paramArr = array('userId'=>6 , 
//			'firstPollResult' => array(1,2)
//			);

 
 	/*$paramArr = array('userId'=>6 , 
			'firstPollResult' => array('qsid'=> 1,'selectedAnsId'=> array(2),'selectedSubQuestionAnsId'=>array()),
			array('qsid'=> 2,'selectedAnsId'=> array(2),'selectedSubQuestionAnsId'=>array()),
			array('qsid'=> 3,'selectedAnsId'=> array(1),'selectedSubQuestionAnsId'=>array()),
			array('qsid'=> 4,'selectedAnsId'=> array("1990-12-2"),'selectedSubQuestionAnsId'=>array()),
			array('qsid'=> 5,'selectedAnsId'=> array(2),'selectedSubQuestionAnsId'=>array()),
			array('qsid'=> 6,'selectedAnsId'=> array(2),'selectedSubQuestionAnsId'=>array()),
			array('qsid'=> 7,'selectedAnsId'=> array(2),'selectedSubQuestionAnsId'=>array(3)),
			array('qsid'=> 8,'selectedAnsId'=> array(2),'selectedSubQuestionAnsId'=>array()),
			array('qsid'=> 9,'selectedAnsId'=> array(2),'selectedSubQuestionAnsId'=>array()),
			array('qsid'=> 10,'selectedAnsId'=> array(2),'selectedSubQuestionAnsId'=>array())
			);*/

/*echo "<pre>";
print_r($paramArr);
echo "</pre>";*/
 $ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL,$_POST['url']);
//curl_setopt($ch, CURLOPT_HTTPHEADER,$paramArr);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $paramArr);

    
$data = curl_exec($ch);
echo "<div  style='word-wrap: break-word; width: 100%;'><pre>{$data}</pre></div>";
$info = curl_getinfo($ch);
echo"<hr/>";
//echo "<div  style='word-wrap: break-word; width: 100%;'>".base64_decode($data)."</div>";
//echo "<div  style='word-wrap: break-word; width: 100%;'>".$data."</div>";
//echo"<hr/>";
echo "Script took total ".$info['total_time']." Seconds";

}
        
?>

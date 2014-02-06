<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
/*$string = "google.test";
$wrd = $owrd = "";
    if (preg_match_all('/(\w+).(?<!\w)/', $string, $matches))
    {
        $users = $matches[1];

	    // $users should now contain array: ['SantaClaus', 'Jesus']
		$wrd = "";
        foreach ($users as $user)
        {
            // check $user in database
			$wrd .= "d/".$user;
        }
    }
	echo $wrd.owrd;
*/?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Name Lookup</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script>
function validateSearchString(){
	 document.getElementById("error_msg").innerHTML="";
		inputs = document.getElementById('element_1').value;		
	filter = /^([a-zA-Z0-9_.\-/])+$/;
	if (filter.test(inputs)) {
	  // Yay! valid

	  return true;
	}
	else
	  {
	  document.getElementById("error_msg").innerHTML="Special characters are not allowed.";

	  return false;
	  }
}


</script>
</head>
<body id="main_body" >
	<img id="top" src="top.png" alt="">
	<div id="form_container">

		<h1><a><img src="namecoinlogo.png" style="float:left"></a></h1>
		<form onsubmit="return validateSearchString();" id="form_773223" class="appnitro"  method="post" action="index.php" >
					<div class="form_description">
		
			<p><h2>What's in there?</h2>

The name lookup utility allows you to search any name and associated data stored in the block chain.<br>

Only the current information is shown, unless the name is expired, the last valid result is returned. <br>

Any associated data is shown.</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Search for name in blockchain:</label>
		<div>
			<input id="element_1" name="element_1" class="element text medium" type="text" maxlength="255" value="" /> 
			
		</div>
		
		<p class="guidelines" id="guide_1">
		<div style="color:red;" id="error_msg"></div>
		<small>Enter a domain or string to search for in the block chain. The proper format is d/domain for a domain, although any string can be searched.</small></p> 
		</li>
			
					<li class="buttons">
			     <input type="hidden" name="form_id" value="773223" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Search" />
		</li>
			</ul>
		</form>	
  
		<div style="margin-left:25px;">
  
                        <?php

                        if (isset($_POST["element_1"]))
                        {
                        $search_param =  str_replace('.bit','.',$_POST["element_1"]);
                        $search_param =  preg_replace('/[^A-Za-z0-9\-\/\.\']/', '', $search_param);
                        $search_param = htmlspecialchars($search_param);
                        $new_var = explode('.', $search_param);
                        if (!empty($new_var)) {
                                $search_param = "";
                                for($i=0;$i<count($new_var);$i++) {
                                        if (count($new_var) > 1) {
                                                if ($i==0) {
                                                        $search_param .= str_replace("d/d/","d/","d/".$new_var[$i]);	
                                                } else {
														if ($new_var[$i] != "") {
															$search_param .= ".".$new_var[$i];
														}
                                                        
                                                }
                                        } else {
                                                        $search_param .= $new_var[$i];
                                        }
                                }
                        }
				
                        echo("<h2>Search results for: " .$search_param);
			echo "</h2>";
                        $param=$search_param;
                        $output = shell_exec( "python /home/namecoin/www/namelookup.py $param" );
                        echo "$output";
                        }
                        ?>
</div>
		
		<div id="footer">
			
		</div>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>

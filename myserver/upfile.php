<?php
if($_FILES['book']['name'])
{
	if(!$_FILES['book']['error'])
	{
    $filename = strtolower($_FILES['book']['name']);

    $tmp = explode(".", $filename);
    $finalfext = end($tmp);
    // echo $finalfext;
    $fextensions = array("pdf", "epub");

    if(in_array($finalfext, $fextensions) === false){
      $errors[] = "Current file extension is not allowed, please choose PDF or EPUB file.";
    }
    else{
        if($_FILES['book']['size'] > (204800000)) //can't be larger than 200 MB
		{
			$valid_file = false;
			$message = 'Oops!  Your file\'s size is to large.';
		}
        else{
            $valid_file = true;
        }
    }

		if(isset($valid_file) && $valid_file)
		{
			move_uploaded_file($_FILES['book']['tmp_name'], $filename);
			$message = 'Congratulations!  Your file was accepted.';
		}
	}
	else
	{
		$message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['book']['error'];
	}
	if(isset($errors)){
	    echo json_encode($errors);
	}
	else{
	    echo json_encode($message);
	}
}
?>

<?php

require_once('secret.php');

function dbConnect()
{
	$connect = mysqli_connect(DBSERVER, DBUSER, DBPASS, DBSCHEMA);

	if (!$connect)
		print "Not connecting to the database!";

	else 
		return $connect;
}

function dbRow($sql)
{
	$connect = dbConnect();
	$query = mysqli_query($connect, $sql);

	if($query)
	{
		$row = mysqli_fetch_assoc($query);		
		return $row;

		mysqli_free_result($query);
		mysqli_close($connect);
	}

	else 
	{
		print 'Not connecting to the database!';
		exit;
	}

}

function dbArray($sql)
{
	$connect = dbConnect();
	$query = mysqli_query($connect, $sql);

	$array = [];

	if($query)
	{
		while($row = mysqli_fetch_assoc($query))
		{
			if(!empty($row))
			{
				$array[] = $row;
			}
		}
		return $array;

		mysqli_free_result($query);
		mysqli_close($connect);
	}

	else 
	{
		print 'Not connecting to the database!';
		exit;
	}

}

function dbAdd($sql)
{
	$connect = dbConnect();
	mysqli_query($connect, $sql);
	mysqli_close($connect);
}


function checkIMG($img, $pic_name, $dir)
{
	$name = $pic_name;
	$size = $img['size'];
	$temp = $img['tmp_name'];
	$error = $img['error'];
	

	if(@getimagesize($temp))
		{
			if($size < 5000000)
			{
				move_uploaded_file($temp, $dir . '/' . $name);
				correctImageOrientation($dir . '/' . $name);
				return true;
			}

			else
			{
				return false;
			}
		}
	else
	{
		return false;
	}
}


function correctImageOrientation($filename) 
{
  if (function_exists('exif_read_data')) 
  {
    $exif = exif_read_data($filename);

    if($exif && isset($exif['Orientation'])) 
    {
      $orientation = $exif['Orientation'];

      if($orientation != 1)
      {
        $img = imagecreatefromjpeg($filename);
        $deg = 0;

        switch ($orientation) 
        {
          case 3:
            $deg = 180;
            break;
          case 6:
            $deg = 270;
            break;
          case 8:
            $deg = 90;
            break;
        }

        if ($deg) 
        {
          $img = imagerotate($img, $deg, 0);        
        }

        imagejpeg($img, $filename, 95);
      } 
    } 
  }     
}



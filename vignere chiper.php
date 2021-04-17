<?php
/**
    Vignere Cipher
*/

// function to encrypt the text given
function encrypt($password, $text)
{
	// change key to lowercase for simplicity
	$password = strtolower($password);
	
	// intialize variables
	$code = "";
	$ki = 0;
	$kl = strlen($password);
	$length = strlen($text);
	
	// iterate over each line in text
	for ($i = 0; $i < $length; $i++)
	{
		// if the letter is alpha, encrypt it
		if (ctype_alpha($text[$i]))
		{
			// uppercase
			if (ctype_upper($text[$i]))
			{
				$text[$i] = chr(((ord($password[$ki]) - ord("a") + ord($text[$i]) - ord("A")) % 26) + ord("A"));
			}
			
			// lowercase
			else
			{
				$text[$i] = chr(((ord($password[$ki]) - ord("a") + ord($text[$i]) - ord("a")) % 26) + ord("a"));
			}
			
			// update the index of key
			$ki++;
			if ($ki >= $kl)
			{
				$ki = 0;
			}
		}
	}
	
	// return the encrypted code
	return $text;
}

// function to decrypt the text given
function decrypt($password, $text)
{
	// change key to lowercase for simplicity
	$password = strtolower($password);
	
	// intialize variables
	$code = "";
	$ki = 0;
	$kl = strlen($password);
	$length = strlen($text);
	
	// iterate over each line in text
	for ($i = 0; $i < $length; $i++)
	{
		// if the letter is alpha, decrypt it
		if (ctype_alpha($text[$i]))
		{
			// uppercase
			if (ctype_upper($text[$i]))
			{
				$x = (ord($text[$i]) - ord("A")) - (ord($password[$ki]) - ord("a"));
				
				if ($x < 0)
				{
					$x += 26;
				}
				
				$x = $x + ord("A");
				
				$text[$i] = chr($x);
			}
			
			// lowercase
			else
			{
				$x = (ord($text[$i]) - ord("a")) - (ord($password[$ki]) - ord("a"));
				
				if ($x < 0)
				{
					$x += 26;
				}
				
				$x = $x + ord("a");
				
				$text[$i] = chr($x);
			}
			
			// update the index of key
			$ki++;
			if ($ki >= $kl)
			{
				$ki = 0;
			}
		}
	}
	
	// return the decrypted text
	return $text;
}

?>


<?php

// initialize variables
$password = "";
$code = "";
$error = "";
$valid = true;
$color = "#FF0000";

// if form was submit
if ($_SERVER['REQUEST_METHOD'] == "POST")
{	
	// set the variables
	$password = $_POST['password'];
	$code = $_POST['code'];
	
	// check if password is provided
	if (empty($_POST['password']))
	{
		$error = "Isi Kata Kunci";
		$valid = false;
		$color = "#DC143C";
	}
	
	// check if text is provided
	else if (empty($_POST['code']))
	{
		$error = "Isi text atau kode untuk encrypt atau decrypt!";
		$valid = false;
		$color = "#DC143C";
	}
	
	// check if password is alphanumeric
	else if (isset($_POST['password']))
	{
		if (!ctype_alpha($_POST['password']))
		{
			$error = "Password harus karakter alphabet!";
			$valid = false;
			$color = "#DC143C";
		}
	}
	
	// inputs valid
	if ($valid)
	{
		// if encrypt button was clicked
		if (isset($_POST['encrypt']))
		{
			$code = encrypt($password, $code);
			$error = "Text berhasil dienkripsi !";
			$color = "#0000FF";
		}
			
		// if decrypt button was clicked
		if (isset($_POST['decrypt']))
		{
			$code = decrypt($password, $code);
			$error = "Kode berhasil diterjemahkan !";
			$color = "#0000FF";
		}
	}
}

?>

<html>
	<head>
		<title>VigenereCipher A11.2018.10871</title>
		
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
	</head>
	<body>
        <div class="container d-flex justify-content-center">
            <form action="Coba_EnkripsiDekripsi.php" method="post" class="mt-5 col-8">
                <div class="mb-3">
                    <label for="pass" class="form-label">Kata Kunci</label>
                    <input type="text" class="form-control" id="pass" name="password" value="<?php echo htmlspecialchars($password); ?>">
                </div>
                <div class="mb-3">
                    <label for="code" class="form-label">Teks</label>
                    <input type="text" name="code" class="form-control" id="code" value="<?php echo htmlspecialchars($code); ?>">
                </div>
                <button type="submit" name="encrypt" class="btn btn-Dark">Encode</button>
                <button type="submit" name="decrypt" class="btn btn-primary">Decode</button>
            </form>
        </div>
        
        <center><div style="color: <?php echo htmlspecialchars($color) ?>"><?php echo htmlspecialchars($error) ?></div></center>
		
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
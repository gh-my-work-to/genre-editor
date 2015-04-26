<?php
$mPath = $_GET['path'];

$mOutHtml = getLinesInput($mPath);

function getLinesInput($path)
{
	$ret = "";
	
	$fp = fopen($path, "r");
	$group = "";
	while(($line = fgets($fp)) != null)
	{
		$line = rtrim($line);
		
		if(preg_match("/<\/dt>/", $line))
		{
			$mat = array();
			if(preg_match("/>([^<>]+)</", $line, $mat))
			{
				$group = $mat[1];
			}
		}
		
		$ret .= '<div class="lineDiv"><input group="' . $group . '" class="chk" type="checkbox"><input class="line" type="text" style="width:90%;" value=\'' . $line . '\' readonly ></div>' . "\n";
	}
	fclose($fp);
	
	return $ret;
}

function get_safe($line)
{
	return preg_replace("/</", "&lt;", 
				preg_replace("/>/", "&gt;", 
					preg_replace("/\&/", "&amp;", $line)));
}
//========================
echo <<< EOF
<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>reader</title>
	<script src="../jquery-2.1.3.min.js"></script>
	<style>
	input:focus, textarea:focus, button:focus{ background-color:#ffffaa; }
	</style>
</head>
<body>
	
	<div style="float:left; width:24%;">
		inputArea<br />
		<textarea id="inputArea" style="width:90%; height:20em;"></textarea><br />
		<button id="apply">apply</button> <button id="get">get</button>
	</div>
	
	<div style="float:left; width:60%;">
		$mOutHtml
	</div>
	<br style="clear:both;" />
	<hr />
	result<br />
	<textarea id="result" style="width:100%; height:20em;" ></textarea>
	<script src="reader.js"></script>
</body>
</html>
EOF;
?>

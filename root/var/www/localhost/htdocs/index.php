<?php
	if(isset($_REQUEST['download']))
	{
		if(file_exists("/tmp/recordings/".$_REQUEST['download'])){
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" . $_REQUEST['download'] . "\""); 
			readfile("/tmp/recordings/".$_REQUEST['download']); 
		} else {
			echo "File Not Found.";
		}
		exit;
	}
?>
<HTML>
	<HEAD>
		<TITLE>
			Audio Recorder Pi
		</TITLE>
	</HEAD>
	<BODY>

<?php
	# Start / Stop Control
	
	if(isset($_REQUEST['action'])){
		if ($_REQUEST['action'] == "stop"){
			file_put_contents("/tmp/recordStop", date("U"));
		} else if ($_REQUEST['action'] == "record"){
			file_put_contents("/tmp/recordStart", date("U"));
		}		
	}
	?>
	<form>
	<?php
	if (str_contains(shell_exec("service audiorec status"), "started")){
		?>
		<button type="submit" name="action" value="stop">Stop</button>
		<?php
	} else {
		?>
		<button type="submit" name="action" value="record">Record</button>
		<?php
	}
	?></form><?php
	

?>

<hr />
<h2>Recorded Files</h2>
<ul>
<?php
	$files = scandir("/tmp/recordings");
	foreach($files as $file){
		?>
			<li><a href="?download=<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a></li>
		<?php
	}
?>
</ul>


<div style="float:left;">
	<div id="topmenu">
	<ul>

	<?
	foreach ($arrTopmenu AS $Key=>$Value) {
		if ($Key==$_SESSION['device_type']) {
			echo '<li id="current"><a href="#" title="'.$Value['title'].'">'.$Value['title'].'</a></li>';
		}else{
			echo '<li><a href="index.php?page='.$Value['file'].'&device_type='.$Key.'" title="'.$Value['title'].'">'.$Value['title'].'</a></li>';
		}
	}
	?>
	</ul>
	</div>
</div>



<div id="topmenuline">&nbsp;</div>


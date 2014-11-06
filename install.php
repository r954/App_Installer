<!--
***************************
|	Application installer  |
***************************
-->
<style>
#header .install
{
padding-bottom: 11px; 
	background: white;
	
}
</style>

<?php
include("header.php");
include("function.php");
?>
<!--<div style="border:1px solid blue; width:auto; margin-top:10px;">


</div>
 -->
<div id="home">
<div style="width: 497px;">

<div style="text-align:center;margin-bottom:20px;">Application Installer</div>
<form method="post">
<table><tr><td>Name:</td> <td><input name="name" type="text" placeholder="Enter computer name..."></td>
</tr>
<tr><td>Application:</td> <td><input name="path" id="path" type="text" style="width:300px;" placeholder="Enter application..."></td>
<td><input type="button" id="browse" value="Browse"></td>

</table>
<p>
<div align="right"><input type="submit" value="Install" name="install">
<input type="submit" value="Uninstall" name="uninstall"></div>
</form>
</div>

<div id="browse-up" class="draggable" style="height: 289px;  margin-left:-41px; width:721px; border: 1px solid #9A9A9A; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 10px; background: white; display: none">
<div style="margin-top:20px;">

<div align="center"><input type="file" id="upload" > <input type="checkbox">Append to list
</div>
<?php

//location of applications
$dir= "\\\\bc-wsus\WSUSTemp\apps\\";
//scan directory and retrieve all files 
$appdir = scandir($dir);

//for each array loop to manipulate stings
foreach 
($appdir as $appfor)

//if string is more than 2 characters echo table list
{if (strlen($appfor) > '2') {
//echo $appfor;

//var_dump($appdir);



?>
<ul>
<li>
<a  id="printers" href="<?php echo $appfor; ?>"><?php if (strlen($appfor) >= '27') {echo substr($appfor, 0, -15);} else echo  substr($appfor, 0, -4); ?></a>
</li>
</ul>

<?php
}}
?>
</div>
</div>
<script>
$('#browse-up').on('click', "#printers", function() {
        $("#path").val($(this).attr('href')); return false
    });	
    <!--Append value in upload to application field -->
    $('#browse-up').on('change', "#upload", function() {
        $("#path").val($(this).val()); return false
    });	
	
	$('#browse').click( function() {
        $('#browse-up').slideToggle(); return false
    });
	</script>

<?php
//call application install script
install_app();
?>
</div>

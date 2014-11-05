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
<script>
$('#browse-up').on('click', "#printers", function() {
        $("#path").val($(this).attr('href')); return false
    });	
	
	$('#browse').click( function() {
        $('#browse-up').slideToggle(); return false
    });
	</script>

<?php

if (isset($_POST["install"]))

{
$ip = $_POST["name"];
$path= $_POST["path"];
//echo $ip;
$app = '\\\\bc-wsus\WSUSTemp\apps\\'.$path.'';
$localapp = '\\\\'.$ip.'\c$\\'.$path.'';

if (file_exists($app))

{

if (substr($path, -3) == "msi")
{
//echo "quiet";
exec('psexec -accepteula -d -s -i \\\\'.$ip.' msiexec /i "'.$app.'" /quiet',$a2,$a3);

//silent exec('psexec -accepteula -d -s -i \\\\'.$ip.' msiexec /i "c:\\'.$path.'" /quiet',$a2,$a3);
//passive exec('psexec -accepteula -d -s -i \\\\'.$ip.' msiexec /i "c:\\'.$path.'" /passive',$a2,$a3);
}
else 
{
//echo "silent";
//echo "file found";
exec('psexec -accepteula -d -s \\\\'.$ip.'  "'.$app.'" /silent',$a2,$a3);
}
}

else

{
if (substr($path, -3) == "msi")
{
//echo "quiet";
//exec('psexec -accepteula -d -s -i \\\\'.$ip.' msiexec /i "c:\\'.$path.'" /quiet',$a2,$a3);

//copy file to server
copy($localapp,$app);

echo $path. "Copied to server";

//silent exec('psexec -accepteula -d -s -i \\\\'.$ip.' msiexec /i "c:\\'.$path.'" /quiet',$a2,$a3);
//passive exec('psexec -accepteula -d -s -i \\\\'.$ip.' msiexec /i "c:\\'.$path.'" /passive',$a2,$a3);
}
else if  (file_exists($localapp))
{
echo "found locally";
//exec('psexec -accepteula -d -s -i \\\\'.$ip.'  "c:\\'.$path.'" /silent',$a2,$a3);

//copy file to server
copy($localapp,$app);

echo $path."Copied to server";
}

else 

{
echo $localapp;
echo "not found";
}
}

}


if (isset($_POST["uninstall"]))

{
$ip = $_POST["name"];
$path= $_POST["path"];
echo $ip;

if (substr($path, -3) == "msi")
{
//echo "quiet";
exec('psexec -accepteula -d -s -i \\\\'.$ip.' msiexec /u "c:\\'.$path.'"',$a2,$a3);
}
else 
{
echo "Can't uninstall extension exe";
//exec('psexec -accepteula -d -s -i \\\\'.$ip.'  "c:\\'.$path.'"',$a2,$a3);
}
}

?>
</div>

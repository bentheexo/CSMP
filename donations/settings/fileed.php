<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "99";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "fileed.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?
require "config.php";
require "../config.php";
require($_SERVER['DOCUMENT_ROOT'] . '/csmp/config.php');
if($admineditor)
{
//By default this script will allow you to edit all the files in $filedir that
//have extensions in the valid_ext array and are writable.  It also allows you
//to edit all the files that are writable and have valid extensions in the sub
//folders of $filedir.  In other words, it recursively searches for files you
//can edit in $filedir.  If you wish to change this behavior, so that it only
//stays in $filedir and doesn't drill down to any of its subdirs,--search for
//$filelist = directoryToArray($filedir, true); and change true to false.

//Valid Extension array.  
//The array below lists the extensions files must have in order to 
//show up in the selection drop down box of fileed.php.  NOTE: In order for you
//to be able to edit a file it must have an extension in the array below and
//must be writable (chmoded 666). It must also be in the $filedir folder or 
//in a subfolder in the $filedir folder.  All folders that the script must
//transverse in order to reach your file must be chmoded at least 555. To
//add a new extenstion to this array do the following:
//1. Copy the bottom valid_ext line. Insert a new line below it
//   (hit enter).  Paste the line you copied.
//2. Increase [x] by one.
//3. Change the text inside the quotes to the extension you want to allow.
//   Case must match exactly.
//4. Save your changes.
$valid_ext[0] = "TXT";
$valid_ext[1] = "txt";
$valid_ext[2] = "htm";
$valid_ext[3] = "HTM";
$valid_ext[4] = "html";
$valid_ext[5] = "HTML";
$valid_ext[6] = "shtm";
$valid_ext[7] = "SHTM";
$valid_ext[8] = "shtml";
$valid_ext[9] = "SHTML";
$valid_ext[10] = "pl";
$valid_ext[11] = "PL";
$valid_ext[12] = "cgi";
$valid_ext[13] = "CGI";
$valid_ext[14] = "CSS";
$valid_ext[15] = "css";
$valid_ext[16] = "conf";
$valid_ext[17] = "CONF";
$valid_ext[18] = "ASP";
$valid_ext[19] = "asp";
$valid_ext[20] = "JSP";
$valid_ext[21] = "jsp";
$valid_ext[22] = "js";
$valid_ext[23] = "JS";
$valid_ext[24] = "php";
$valid_ext[25] = "PHP";
$valid_ext[26] = "php3";
$valid_ext[27] = "PHP3";
$valid_ext[28] = "PHTML";
$valid_ext[29] = "phtml";
$valid_ext[30] = "ini";
$valid_ext[31] = "INI";
$valid_ext[32] = "cfm";
$valid_ext[33] = "CFM";
$valid_ext[34] = "inc";
$valid_ext[35] = "INC";
//That should cover what most people use!  I hope anyhow :)

//You should not have to change anything below this line. 

//IF browser does not send a POST request (ie: if open/save has not been
//pressed) then display the form and the list of files.
if ($_SERVER['REQUEST_METHOD'] != 'POST'){
//If filedir is readable do...
if (is_readable($filedir)) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<style type="text/css">
h2 {text-align: center}
</style>
<title>Settings Editor</title>
</head>
<body>
<h2>Settings Editor</h2>
<form action="<?=$PHP_SELF?>" method="post">
<table>
<tbody>
<tr>
<td>
<?

//Change into filedir
chdir($filedir);
//Print the directory we are in. Should match filedir.
echo "<p> We are in:  ";
echo "<br />";
echo getcwd();
echo "</p>";

//Continue page below.
//INFO for below: Select "name" is variable name.  Option value is variable
//"value".  
?>
<p> Please choose a file to open:</p>
<select name="the_file">
<?
//The below function will read directory contents into an array.
//Taken from http://www.bigbold.com/snippets/posts/show/155.
//Modified some. This will allow us to read all the contents of
//this directory and all sub-directories into an array.
//Once we have the array we will sort it alphabetically
//and print the filenames in the select box.
//The comments below the code snippets in the function
//are how I follow the code.  Since I did
//not write the original code they may not be entirely
//accurate. 

function directoryToArray($directory, $recursive) {
//Start function.  Parse var1 as directory.  Parse var2
//as true or false indicating whether to use recursive
//routine or not.

//Create a variable that referees to this file itself.  That way it can be
//excluded from the editable file list, just in case its in the directory 
//of files you want to edit.
$me = basename($_SERVER['PHP_SELF']);

$array_items = array();
//Define array for later use.
        if ($handle = opendir($directory)) {
                while (false !== ($file = readdir($handle))) {
//Don't add: this file itself ($me), unix hidden files (.files),
//the up directory link (..) and the current directory link (.) 
//to the array.  This will stop the accidental editing of
//important files, and confusing listings.
             

if ($file != "." && $file != ".." && $file != $me && substr($file,0,1) != '.') {
//Open the directory specified in the function.
//For every file that meets the above terms do...
                                if (is_dir($directory. "/" . $file)) {
//If the 'file' in the directory opened is a directory do...
                                        if($recursive) {
//If recursive is set, rerun the function on that directory.
                                                $array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
                                        }
//Add the contents of recursed directory to the array.

//Comment the below two lines out to prevent directories from showing up 
//in the file editing list. 
                                //        $file = $directory . "/" . $file;
                                  //      $array_items[] = preg_replace("/\/\//si", "/", $file);
					 
					} else {
                                        $file = $directory . "/" . $file;
                                        $array_items[] = preg_replace("/\/\//si", "/", $file);
//Else if the "file" in the opened directory is a file (not a dir),
//replace // with / and add it to the array.
                                }
                        }
                }
                closedir($handle);
//Close the directory.
        asort($array_items);
//Sort the array alphabetically.
   }
        return $array_items;
//Return the array.
}

//End borrowed code.

//Create the array filelist by running the function
//on the filedir with recursing enabled.
//The true in this function enables recursion.  
//If you don't want the script to recursively 
//search for files you can edit change the true to false.
$filelist = directoryToArray($filedir, true);

//Loop through the array. The value in each row should be called $file and
//the following code should be executed against it.
foreach ($filelist as $file)
{
//Get the extensions of the files.  
//Look at each filename at and use
//strrchr to find the last occurrence
//of "." in the filename.  This returns .jpg
//for example.  Then use substr to return
//+1 of .jpg.  Meaning everything after ".". 
$ext = substr(strrchr($file, '.'), 1);
//If a file has an extension that
//is in the valid_ext array and that 
//file is writable list it in
// the drop down box. 
if (in_array($ext,$valid_ext) && is_writable($file)) {
//Add files to a select box.
echo "<option value=\"$file\">$file</option>";
}
}
//Continue page below.
?>
</select>
<br />
<input type="submit" name="open" value="Open" />
</td>
</tr>
<tr>
<td>
<textarea rows="30" cols="80" style="border: 1px solid #666666;" name="updatedfile"></textarea>
<br />
<!-- <div style="text-align: center;"><input type="submit" name="save" value="Save Changes" /></div> -->
</td>
</tr>
</tbody>
</table>
</form>
</body>
</html>
<?
}
else
{
//If directory can't be opened complain 
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>
<style type=\"text/css\">
h2 {text-align: center}
</style>
<title>Settings Editor: ERROR!</title>
</head>
<body>
<h2>Settings Editor: ERROR!</h2>
<p>Could not open directory!! <br /> Permissions Problem??</p>
</body>
</html>";
}
}
///////////////////////////////////////////////////////////////////
//If the open button has been pressed
////////////////////////////////////////////////////////////////////
else if (isset($_POST['open'])){

//If the file can be opened and is writable do....
//This should not be needed because files that aren't writable should
//have never been shown in the selection box.
if (is_writable($_POST["the_file"])) {

//Start page 
//INFO for below: Since variable data is not saved across multiple
//form posts-- we must create a hidden input box with the same value as the
//select box on the previous form. That way the 3rd and final form (ie: the
//saving process) can use the same variable as the first form  (read: write to
//the file you choose in the select box.)      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<style type="text/css">
h2 {text-align: center}
</style>
<title>Settings Editor: File Opened</title>
</head>
<body>
<h2>Settings Editor: File Opened</h2>
<form action="<?=$PHP_SELF?>" method="post">
<table>
<tbody>
<tr>
<td>
<input type="hidden" name="the_file2" value="<? echo $_POST["the_file"]; ?>" />
<?
echo "<p>We are working on:  ";
echo "<br />";
//Get previously posted select box data
echo $_POST["the_file"];
echo "</p>";
//Continue page below.
?>
</td>
</tr>
<tr>
<td>
<textarea rows="30" cols="80" style="border: 1px solid #666666;" name="updatedfile">
<?

//Open the file chosen in the select box in the previous form into the text
//area
$file2open = fopen($_POST["the_file"], "r");


//Read all the data that is currently in the selected file into the variable
//current_data.
$current_data = @fread($file2open, filesize($_POST["the_file"]));

/*Dirty hack to allow you to edit files that contain "</textarea>" in them.  If
this was not was not here and you tried to edit a file with </textarea> in it
all of your code up to </textarea> would be in this editing forms textarea and
everything after </textarea> would be executed/displayed.  This is very
confusing, but if you look at the code in this file and then think about it a
bit, you will understand what it does.*/

//Do a case insensitive search for </textarea> in the $current_data string.
//replace it with <END-TA-DO-NOT-EDIT>.
//This means when you are editing files that contain </textarea> the editing
//box will show <END-TA-DO-NOT-EDIT> instead of the </textarea> tag.  Do not be
//alarmed by this.  Do NOT change or remove this tag, it will be converted back
//to </textarea> in the saving process.  If for some reason this does not work
//for you, or if you know a better way to go about doing this please contact
//me. 
$current_data = eregi_replace("</textarea>", "<END-TA-DO-NOT-EDIT>", $current_data);
//Echo the data from the file 
echo $current_data;
//Close the file 
fclose($file2open);
//Continue page below.
?>
</textarea>
<br />
<div style="text-align: center;"><input type="submit" name="save" value="Save Changes" /></div>
</td></tr>
</tbody>
</table>
</form>
</body>
</html>
<?
}
else
{
//If file can't be opened complain 
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>
<style type=\"text/css\">
h2 {text-align: center}
</style>
<title>Settings Editor: ERROR!</title>
</head>
<body>
<h2>Settings Editor: ERROR!</h2>
<p>Could not open file!! <br /> Permissions Problem??</p>
</body>
</html>";
}
}
///////////////////////////////////////////////////////
//If save button has been pushed....
//////////////////////////////////////////////////////
else if (isset($_POST['save'])){

//If the file can be opened and is writable do....
//This should not be needed because files that aren't writable should
//have never been shown in the selection box. And should not have been opened
//on the previous page.  
if (is_writable($_POST["the_file2"])) {

//Get variable data for the file we are working with from the hidden input box
//in the previous form.  Then open it.
$file2ed = fopen($_POST["the_file2"], "w+");
//Dirty </textarea> hack part 2.  Copy all of the data in the previous forms
//editing textarea to the variable $data_to_save.  
$data_to_save = $_POST["updatedfile"];
//Do the opposite of above.  This time convert the <END-TA-DO-NOT-EDIT> tag you
//see in the editing form back to its proper </textarea> tag so when your files
//are saved the forms on them will still look/work right.  
$data_to_save = eregi_replace("<END-TA-DO-NOT-EDIT>", "</textarea>", $data_to_save);
//Remove any slashes that may be added do to " ' " s.  Thats a single tick, btw.
$data_to_save = stripslashes($data_to_save);
//Get the data to write from the previously posted text area, plus all the
//processing we did on it above. Write the changes to the file.
if (fwrite($file2ed,$data_to_save)) {
//If write is successful show success page.  
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>
<style type=\"text/css\">
h2 {text-align: center}
</style>
<title>Settings Editor: File Saved</title>
</head>
<body>
<h2>Settings Editor: File Saved</h2>
<p>File saved. <br /> Click <a href='../admin/main.php'>here</a> to go back to the editor.</p>
</body>
</html>";
//Close file
fclose($file2ed);
}
else {
//If write fails show failure page
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>
<style type=\"text/css\">
h2 {text-align: center}
</style>
<title>Settings Editor: ERROR!</title>
</head>
<body>
<h2>Settings Editor: ERROR!</h2>
<p>File NOT saved!! <br /> Permissions Problem?? <br />  Click <a href=\"\">here</a> to go back to the editor.</p>
</body>
</html>";
//Close file
fclose($file2ed);
}
}
else 
{
//If file can't be opened complain
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>
<style type=\"text/css\">
h2 {text-align: center}
</style>
<title>Settings Editor: ERROR!</title>
</head>
<body>
<h2>Settings Editor: ERROR!</h2>
<p>File NOT saved!! <br /> Permissions Problem??</p>
</body>
</html>";
}
}
} else {
	
echo 'Config Editing not turned on.';
echo '<p class="right1">';
echo '<h4>Config.php Settings</h4>';
echo '<u>Server Name</u>: <B>';
echo $name;
echo '</B><br /> <u>Slogan</u>: <B>';
echo $slogan;
echo '</B><br />';
echo '<u>Paragraph1</u>: <B>';
echo $paragraph1;
echo '</B><br />';
echo '<u>Credits Exchange Rate</u>: <B>';
echo $CreditsExchangeRate;
echo ' * Amount = Credits Players get when Donating</B><br />';
echo '<u>Subscriptions Exchange Rate</u>: <B>';
echo $SubscriptionsExchangeRate;
echo ' * Amount = Credits Players get when Subscripting and then monthly</B> <br />';
echo '<u>Listings</u>: <B>';
if($dlist)
{	echo 'true';
} else {
	echo 'false';
}
echo '</B><br /><u>Listing Name</u>: <B>';
echo $dlistname;
echo '</B><br /><u>Listing Slogan</u>: <B>';
echo $blistslogan;
echo '</B><br /><u>Ads</u>: <B>';
if($ads1)
{	echo 'true';
} else {
	echo 'false';
}
echo '</B><br /><u>Config Edit</u>: <B>';
if($admineditor)
{	echo 'true';
} else {
	echo 'false';
}
echo '</B><br /><u>Paypal Email</u>: <B>';
echo $CONFIG_mypaypalemail;
echo '</B> <br /><u>Demo Mode</u>: <B>';
if($demoMode)
{	echo 'true';
} else {
	echo 'false';
}
echo '</B><br /></p>';
}
?>


<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php");
}

require_once "../modules/system/db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$userID = $_GET['userID'];
$photo = $_GET['photo'];
if($photo!="") {
$docType = $LANG['profile_image'];
} else {
$docType = $LANG['documents'];	
}


$query = "SELECT fullName from ".$users." WHERE userID=".$userID;

try {
    $result = $pdo->query($query);
    $Row = $result->fetch();
    $userFullName = $Row['fullName'];
} catch (PDOException $e) {
    print "Data not fetched, because: ".$e->getMessage();
}


?>
<!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin HTML Example 5.0.5
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://creativecommons.org/licenses/MIT/
 */
-->
<html lang="en" class="no-js">
<head>
<meta charset="utf-8">
<title>Documents</title>

<link rel="stylesheet" href="../lib/jquery.fileupload-ui.css">
<link rel="stylesheet" href="../lib/upload/style.css">
<link rel="stylesheet" href="../lib/jquery/development-bundle/themes/<?php print $_SESSION['style'] ?>/jquery.ui.all.css">
</head>
<body>
<h1 class="ui-widget-header ui-corner-all" style="font-size:13px;padding:2px 1px 1px 15px;margin-top:4px"><?php print $userFullName." - ".$docType; ?></h1>
<div id="fileupload">
    <form action="upload.php?photo=<?php print $photo; ?>&userID=<?php print $userID; ?>" method="POST" enctype="multipart/form-data">
          <div class="fileupload-buttonbar">
            <label class="fileinput-button">
                <span><?php print $LANG['add_files'];?></span>
                <input type="file" name="files[]" multiple>
            </label>
            <button type="submit" class="start"><?php print $LANG['start_upload'];?></button>
            <button type="reset" class="cancel"><?php print $LANG['cancel_upload'];?></button>
          </div>
    </form>
    <div class="fileupload-content">
        <table class="files"></table>
        <div class="fileupload-progressbar"></div>
    </div>
</div>
<script id="template-upload" type="text/x-jquery-tmpl">
    <tr class="template-upload{{if error}} ui-state-error{{/if}}">
        <td class="preview"></td>
        <td class="name">${name}</td>
        <td class="size">${sizef}</td>
        {{if error}}
            <td class="error" colspan="2">Error:
                {{if error === 'maxFileSize'}}File is too big
                {{else error === 'minFileSize'}}File is too small
                {{else error === 'acceptFileTypes'}}Filetype not allowed
                {{else error === 'maxNumberOfFiles'}}Max number of files exceeded
                {{else}}${error}
                {{/if}}
            </td>
        {{else}}
            <td class="progress"><div></div></td>
            <td class="start"><button>Start</button></td>
        {{/if}}
        <td class="cancel"><button>Cancel</button></td>
    </tr>
</script>
<script id="template-download" type="text/x-jquery-tmpl">
    <tr class="template-download{{if error}} ui-state-error{{/if}}">
        {{if error}}
            <td></td>
            <td class="name">${name}</td>
            <td class="size">${sizef}</td>
            <td class="error" colspan="2">Error:
                {{if error === 1}}File exceeds upload_max_filesize (php.ini directive)
                {{else error === 2}}File exceeds MAX_FILE_SIZE (HTML form directive)
                {{else error === 3}}File was only partially uploaded
                {{else error === 4}}No File was uploaded
                {{else error === 5}}Missing a temporary folder
                {{else error === 6}}Failed to write file to disk
                {{else error === 7}}File upload stopped by extension
                {{else error === 'maxFileSize'}}File is too big
                {{else error === 'minFileSize'}}File is too small
                {{else error === 'acceptFileTypes'}}Filetype not allowed
                {{else error === 'maxNumberOfFiles'}}Max number of files exceeded
                {{else error === 'uploadedBytes'}}Uploaded bytes exceed file size
                {{else error === 'emptyResult'}}Empty file upload result
                {{else}}${error}
                {{/if}}
            </td>
        {{else}}
            <td class="preview">
                {{if thumbnail_url}}
                    <a href="${url}" target="_blank"><img src="${thumbnail_url}"></a>
                {{/if}}
            </td>
            <td class="name">
                <a href="${url}"{{if thumbnail_url}} target="_blank"{{/if}}>${name}</a>
            </td>
            <td class="size">${sizef}</td>
            <td colspan="2"></td>
        {{/if}}
        <td class="delete">
            <button data-type="${delete_type}" data-url="${delete_url}">Delete</button>
        </td>
    </tr>
</script>
<script src="../lib/jquery/jquery.min.js"></script>
<script src="../lib/jquery/js/jquery-ui-1.8.5.custom.min.js"></script>
<script src="../lib/jquery/jquery.tmpl.min.js"></script>
<script src="../lib/jquery.iframe-transport.js"></script>
<script src="../lib/jquery.fileupload.js"></script>
<script src="../lib/jquery.fileupload-ui.js"></script>
<script src="application.js"></script>
</body> 
</html>
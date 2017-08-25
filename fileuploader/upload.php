<?php
include('class.uploader.php');
include('../include.php');

// fetches file name, and converting string to unique_id format
$image = $_FILES['files']['name'][0];
$user_id = get_current_user_id();

$unique_id = md5($user_id.$image.time());
$ext = end((explode(".", $image)));
$filename_full = $unique_id.'.'.$ext;

// save unique_id and image name in database "wp_files"

$type = 2;
if(wp_get_current_user()->roles[0] == 'administrator')
{
    if($_POST['ads'] == 1)
    {
        $type = 1;
    }
}	

$wpdb->insert( 'wp_files', 
	array( 'user_id' => $user_id , 'unique_id' => $filename_full, 'image' => $image, 'type' => $type), 
	array( '%d', '%s', '%s', '%d' ));

// upload files to "../uploads" directory
$uploader = new Uploader();
$data = $uploader->upload($_FILES['files'], array(
    'limit' => 1, //Maximum Limit of files. {null, Number}
    'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
    'extensions' => ['pdf', 'jpg', 'png', 'jpeg', 'doc', 'docx'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
    'required' => false, //Minimum one file is required for upload {Boolean}
    'uploadDir' => '../uploads/', //Upload directory {String}
    'title' => $unique_id, //New file name {null, String, Array} *please read documentation in README.md
    'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
    'perms' => null, //Uploaded file permisions {null, Number}
    'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
    'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
    'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
    'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
    'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
    'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
));

if($data['isComplete']){
    $files = $data['data'];
    print_r($files);
}

if($data['hasErrors']){
    $errors = $data['errors'];
    print_r($errors);
}

function onFilesRemoveCallback($removed_files){
    foreach($removed_files as $key=>$value){
        $file = '../uploads/' . $value;
        if(file_exists($file)){
            unlink($file);
        }
    }

    return $removed_files;
}


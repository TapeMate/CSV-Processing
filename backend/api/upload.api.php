<?php

// Handle CORS
// origin "*" only for dev and demo not for production
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// included classes
include_once "../classes/dbh.class.php";
include_once "../classes/upload.class.php";
include_once "../classes/upload-contr.class.php";

// Handle preflight request for OPTIONS method from browser
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // check if file is set in superglobal
    if (isset($_FILES["file"])) {
        $file = $_FILES["file"];

        // check for upload errors
        switch ($file["error"]) {
            case UPLOAD_ERR_OK:
                $upload = new UploadContr($file);
                $result = $upload->csvUpload();
                header('Content-Type: application/json');
                echo json_encode($result);
                break;

            case UPLOAD_ERR_INI_SIZE:
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "The uploaded file exceeds the upload_max_filesize directive in php.ini."]);
                break;

            case UPLOAD_ERR_FORM_SIZE:
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form."]);
                break;

            case UPLOAD_ERR_PARTIAL:
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "File was only partially uploaded."]);
                break;

            case UPLOAD_ERR_NO_FILE:
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "No file was uploaded."]);
                break;

            case UPLOAD_ERR_NO_TMP_DIR:
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "Missing a temporary folder."]);
                break;

            case UPLOAD_ERR_CANT_WRITE:
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "Failed to write file to disk."]);
                break;

            case UPLOAD_ERR_EXTENSION:
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "A PHP extension stopped the file upload."]);
                break;

            default:
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "Unknown file upload error."]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "No file received in the request."]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

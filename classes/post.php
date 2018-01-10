<?php

Class Post {

    public function connect($db) {
        $connection = mysql_connect("localhost", "r.rimando", "P@ssw0rd");
        mysql_select_db($db, $connection) or die(mysql_error());

        return true;
    }

    public function postRemarks($remarks_text, $surveyId, $projectId, $macAddress, $survey_name) {
        $conn = $this->connect("geotag_db2");
        $today = date("m-d-Y");
        $sql = mysql_query("INSERT into tbl_feedback set projectId = $projectId, surveyId = $surveyId, surveyName ='$survey_name', macAddress='$macAddress', fb_message = '$remarks_text', fb_remarks = '$remarks_text', fb_dateApproved = '$today'") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }

    public function getCode() {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        for ($i = 0; $i < 10; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, strlen($codeAlphabet))];
        }
        return $token;
    }

    public function getUser($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_users where userId = $id") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['userId']] = $row;
        endwhile;
        return $arr;
    }

    public function getSurvey($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys where surveyId = $id") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['surveyId']] = $row;
        endwhile;
        return $arr;
    }

    public function verify($id) {
        $conn = $this->connect("geotag_db2");
        $sql = mysql_query("SELECT * from tbl_users") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)):
            $userId = $row['userId'];

            if (md5($userId . 'geotagWeb') == $id) {
                $sql2 = mysql_query("UPDATE tbl_users set isVerified = 1 where userId = $userId") or die(mysql_error());
            }
        endwhile;
        if ($sql)
            return 1;
        else
            return 0;
    }

    public function countNotif($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys S,tbl_project P where P.userId = $id and P.projectId = S.projectId and S.isRead = 0") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        return $ctr;
    }

    public function readNotif2($surveyId) {
        $conn = $this->connect("geotag_db2");
        $sql = mysql_query("UPDATE tbl_surveys set isRead = 1 where surveyId = $surveyId") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }

    public function readNotif($id) {
        $conn = $this->connect("geotag_db2");
        $sql = mysql_query("UPDATE tbl_surveys S,tbl_users U,tbl_project P set S.isRead = 1 where U.userId = $id and U.userId = P.userId and P.projectId = S.projectId") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }

    public function updatePass($id, $pass) {
        $conn = $this->connect("geotag_db2");
        $sql = mysql_query("UPDATE tbl_users set password = '$pass' where userId = $id") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }

    public function approveUser($id) {
        $conn = $this->connect("geotag_db2");
        $sql = mysql_query("UPDATE tbl_users set isActive = 1 where userId = $id") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }

    public function approveData($id, $action) {
        $conn = $this->connect("geotag_db2");
        $sql = mysql_query("UPDATE tbl_surveys set isApproved = $action where surveyId = $id") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }

    public function updateField($fieldId, $field_name, $isRequired, $isActive) {
        $conn = $this->connect("geotag_db2");
        $pass = md5($password);
        $sql = mysql_query("UPDATE tbl_fields set field_name = '$field_name', isRequired = $isRequired, isActive=$isActive where fieldId = $fieldId") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }

    public function updateUser($username, $fname, $lname, $email, $stationId, $divisionId, $date, $purpose, $level, $userId, $isActive) {
        $conn = $this->connect("geotag_db2");
        $sql = mysql_query("UPDATE tbl_users set isActive = $isActive,isVerified = $isActive, purpose='$purpose', username = '$username', email = '$email', fname = '$fname', lname = '$lname', divisionId = $divisionId, stationId = $stationId, level = $level where userId = $userId") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }
    public function register2($username, $password, $fname, $lname, $email, $stationId, $divisionId, $date, $purpose, $level) {
        $conn = $this->connect("geotag_db2");
        $pass = md5($password);
        $sql = mysql_query("INSERT into tbl_users set isActive = 1,isVerified = 1, purpose='$purpose', username = '$username', password = '$pass', email = '$email', fname = '$fname', lname = '$lname', divisionId = $divisionId, stationId = $stationId, level = $level, registered_date = '$date'") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }
    public function register($username, $password, $fname, $lname, $email, $stationId, $divisionId, $date, $purpose) {
        $conn = $this->connect("geotag_db2");
        $pass = md5($password);
        $sql = mysql_query("INSERT into tbl_users set purpose='$purpose', username = '$username', password = '$pass', email = '$email', fname = '$fname', lname = '$lname', divisionId = $divisionId, stationId = $stationId, level = 1, registered_date = '$date'") or die(mysql_error());

        if ($sql)
            return 1;
        else
            return 0;
    }

    public function checkName2($name, $userId, $id) {
        $conn = $this->connect("geotag_db2");
        $pass = md5($password);
        $sql = mysql_query("SELECT * from tbl_project where project_name LIKE '$name' and userId = $userId and projectId != $id") or die(mysql_error());
        $ctr = mysql_num_rows($sql);

        return $ctr;
    }

    public function checkCode2($code, $userId, $id) {
        $conn = $this->connect("geotag_db2");
        $pass = md5($password);
        $sql = mysql_query("SELECT * from tbl_project where project_code LIKE '$code' and projectId != $id") or die(mysql_error());
        $ctr = mysql_num_rows($sql);

        return $ctr;
    }

    public function checkName($name, $userId) {
        $conn = $this->connect("geotag_db2");
        $pass = md5($password);
        $sql = mysql_query("SELECT * from tbl_project where project_name LIKE '$name' and userId = $userId") or die(mysql_error());
        $ctr = mysql_num_rows($sql);

        return $ctr;
    }

    public function checkCode($code, $userId) {
        $conn = $this->connect("geotag_db2");
        $pass = md5($password);
        $sql = mysql_query("SELECT * from tbl_project where project_code LIKE '$code'") or die(mysql_error());
        $ctr = mysql_num_rows($sql);

        return $ctr;
    }

    public function postInsertSubFieldChoices($fieldId, $fieldType, $choiceId) {
        $connect = $this->connect("geotag_db2");
        mysql_query("INSERT INTO `tbl_field_type_choice` SET `fieldId` = '$fieldId', `fieldTypeId` = '$fieldType', `choiceId` = '$choiceId';") or die(mysql_error());
        $lastId = mysql_insert_id();
    }

    public function postCheckChoices($choiceValue) {
        $connect = $this->connect("geotag_db2");

        $choiceId = 0;

        $sql = mysql_query("SELECT * FROM `tbl_choices` WHERE `choiceName` = '$choiceValue';") or die(mysql_error());
        $row = mysql_fetch_array($sql);

        $choiceId = $row['choiceId'];

        if ($choiceId == 0) {
            mysql_query("INSERT INTO `tbl_choices` SET `choiceName` = '$choiceValue';") or die(mysql_error());
            $choiceId = mysql_insert_id();
        }

        return $choiceId;
    }

    public function postInsertFieldChoices($field_name, $fieldType, $projectId) {
        $connect = $this->connect("geotag_db2");
        mysql_query("INSERT INTO `tbl_fields` SET `projectId` = '$projectId', `field_name` = '$field_name', `isRequired` = '1', `isActive` = '1';") or die(mysql_error());

        $fieldId = mysql_insert_id();

        return $fieldId;
    }

    public function postInsertSubFieldType($fieldId, $fieldType, $subFieldType) {
        $connect = $this->connect("geotag_db2");
        mysql_query("INSERT INTO `tbl_field_type_subtype` SET `fieldId` = '$fieldId', `fieldTypeId` = '$fieldType', `subFieldTypeId` = '$subFieldType';") or die(mysql_error());
    }

    public function postInsertFieldAlpha($field_name, $fieldType, $subFieldType, $projectId, $isRequired) {
        $connect = $this->connect("geotag_db2");
        mysql_query("INSERT INTO `tbl_fields` SET `projectId` = '$projectId', `field_name` = '$field_name', `isRequired` = $isRequired, `isActive` = '1';") or die(mysql_error());

        $fieldId = mysql_insert_id();

        $this->postInsertSubFieldType($fieldId, $fieldType, $subFieldType);
    }

    public function postProjectKey($projectId) {
        $connect = $this->connect("geotag_db2");

        if ($projectId > 0 && $projectId < 10) {
            $prependDigits = '00';
        } else if ($projectId >= 10 && $projectId < 100) {
            $prependDigits = '0';
        } else if ($projectId >= 100) {
            $prependDigits = '';
        }

        $projectKey = 'proj-' . date("y") . '-' . $prependDigits . $projectId;

        mysql_query("INSERT INTO `tbl_key` SET `project_key` = '$projectKey', `projectId` = '$projectId';") or die(mysql_error());

        $this->postProjectKeyBarcode($projectKey);
    }

    public function postTempalate($id, $oldId) {
        $connect = $this->connect("geotag_db2");
        $sql = mysql_query("SELECT * from tbl_fields where projectId = $oldId") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)):
            $fieldId = $row['fieldId'];
            $field_name = $row['field_name'];
            $isReq = $row['isRequired'];
            $isActive = $row['isActive'];
            $sort = $row['sort'];

            $insert = mysql_query("INSERT into tbl_fields set projectId = $id, field_name = '$field_name', isRequired = $isReq, isActive = $isActive") or die(mysql_error());
            $new_fieldId = mysql_insert_id();

            $sql2 = mysql_query("SELECT * from tbl_field_type_choice where fieldId = $fieldId") or die(mysql_error());
            while ($row2 = mysql_fetch_array($sql2)):
                $fieldTypeId = $row2['fieldTypeId'];
                $choiceId = $row2['choiceId'];
                $insert2 = mysql_query("INSERT into tbl_field_type_choice set fieldId = $new_fieldId, fieldTypeId = $fieldTypeId, choiceId = $choiceId") or die(mysql_error());
            endwhile;

            $sql3 = mysql_query("SELECT * from tbl_field_type_subtype where fieldId = $fieldId") or die(mysql_error());
            while ($row3 = mysql_fetch_array($sql3)):
                $fieldTypeId = $row3['fieldTypeId'];
                $subFieldTypeId = $row3['subFieldTypeId'];
                $insert3 = mysql_query("INSERT into tbl_field_type_subtype set fieldId = $new_fieldId, fieldTypeId = $fieldTypeId, subFieldTypeId = $subFieldTypeId") or die(mysql_error());
            endwhile;


        endwhile;
    }

    public function updateProj($proj_name, $proj_abb, $proj_code, $proj_pref, $projectId, $isActive) {
        $connect = $this->connect("geotag_db2");
        mysql_query("UPDATE `tbl_project` SET isActive = $isActive, `project_name` = '$proj_name', `abbr` = '$proj_abb', `survey_prefix` = '$proj_pref', project_code = '$proj_code' where projectId = $projectId") or die(mysql_error());
    }

    public function postProjectTemplate($proj_name, $proj_abb, $proj_code, $proj_pref, $userId, $activeSearch) {
        $connect = $this->connect("geotag_db2");
        mysql_query("INSERT INTO `tbl_project` SET isActive = 1,userId = $userId, `project_name` = '$proj_name', `abbr` = '$proj_abb', `survey_prefix` = '$proj_pref', project_code = '$proj_code'") or die(mysql_error());

        $projectId = mysql_insert_id();

        $this->postTempalate($projectId, $activeSearch);
        $this->postProjectKey($projectId);
    }

    public function postInsertProjectInfo($projectNameComplete, $projectNameShort, $projectCode, $projectPref, $userId) {
        $connect = $this->connect("geotag_db2");
        mysql_query("INSERT INTO `tbl_project` SET isActive = 1, userId = $userId, `project_name` = '$projectNameComplete', `abbr` = '$projectNameShort', `survey_prefix` = '$projectPref', project_code = '$projectCode'") or die(mysql_error());

        $projectId = mysql_insert_id();

        $this->postProjectKey($projectId);
    }

    public function postProjectKeyBarcode($code) {
        $length = strlen($code); // barcode, of course ;)

        $image_x = $length * 38;
        $image_y = 65;

        $fontSize = 10;   // GD1 in px ; GD2 in point
        $marge = 10;   // between barcode and hri in pixel
        $x = $image_x / 2;  // barcode center
        $y = $image_y / 2;  // barcode center
        $height = 60;   // barcode height in 1D ; module size in 2D
        $width = 2;    // barcode height in 1D ; not use in 2D
        $angle = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation  
        $type = 'code128';

        $im = imagecreatetruecolor($image_x, $image_y);
        $black = ImageColorAllocate($im, 0x00, 0x00, 0x00);
        $white = ImageColorAllocate($im, 0xff, 0xff, 0xff);
        $red = ImageColorAllocate($im, 0xff, 0x00, 0x00);
        $blue = ImageColorAllocate($im, 0x00, 0x00, 0xff);
        imagefilledrectangle($im, 0, 0, $image_x, $image_y, $white);

        $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code' => $code), $width, $height);

        if (isset($font)) {
            $box = imagettfbbox($fontSize, 0, $font, $data['hri']);
            $len = $box[2] - $box[0];
            Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
            imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $blue, $font, $data['hri']);
        }

        //header('Content-type: image/png');
        imagepng($im);

        $save = strtolower($code) . ".png";

        if (!file_exists('../barcodes/')) {
            mkdir('../barcodes/', '0777');
        }

        if (!file_exists('../barcodes/projectkey/')) {
            mkdir('../barcodes/projectkey/', '0777');
        }

        imagepng($im, '../barcodes/projectkey/' . $save);

        imagedestroy($im);
    }

}

function crypto_rand_secure($min, $max) {
    $range = $max - $min;
    if ($range < 0)
        return $min; // not so random...
    $log = log($range, 2);
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

?>
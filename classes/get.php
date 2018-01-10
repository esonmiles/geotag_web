<?php

date_default_timezone_set('Asia/Manila');

Class Get {

    public function connect($db) {
        $connection = mysql_connect("localhost", "r.rimando", "P@ssw0rd");
        mysql_select_db($db, $connection) or die(mysql_error());

        return true;
    }

    public function getUsers() {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_users order by userId desc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['userId']] = $row;
        endwhile;
        return $arr;
    }

    public function getValues($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys S,tbl_fields F,tbl_values V where F.projectId = $id and F.fieldId = V.fieldId and F.isActive = 1 and V.surveyId = S.surveyId and S.isApproved = 1 order by F.fieldId") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $ret = $row['valueId'];
        endwhile;
        return $ret;
    }
    public function getStation($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_station where stationId = $id") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $ret = $row['stationName'];
        endwhile;
        return $ret;
    }

    public function countData($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys S,tbl_fields F,tbl_values V where F.projectId = $id and F.fieldId = V.fieldId and F.isActive = 1 and V.surveyId = S.surveyId and S.isApproved = 1") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $ret = $row['valueId'];
        endwhile;
        return $ctr;
    }

    public function getDivision($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_division where divisionId = $id") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $ret = $row['divisionName'];
        endwhile;
        return $ret;
    }

    public function getChoices($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_field_type_choice T, tbl_choices C where T.fieldId = $id and T.choiceId = C.choiceId") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['choiceId']] = $row;
        endwhile;
        return $arr;
    }

    public function getRemarks($sid) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_feedback where surveyId = $sid") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['surveyId']] = $row;
        endwhile;
        return $arr;
    }

    public function getLatestApp() {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_app order by appId desc limit 1") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $ret = $row['app_name'] . '-' . $row['version'];
        endwhile;
        return $ret;
    }

    public function getValue($sid, $fid) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_values where surveyId = $sid and fieldId = $fid") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $ret = $row['value'];
        endwhile;
        return $ret;
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

    public function getFields($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_fields where projectId = $id order by fieldId asc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['fieldId']] = $row;
        endwhile;
        return $arr;
    }

    public function getFieldCount($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_fields where projectId = $id order by fieldId asc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
 
        return $ctr;
    }

    public function getOptions($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_fields F,tbl_fieldtypes D,tbl_field_type_choice S, tbl_choices T where F.isActive = 1 and F.projectId = $id and F.fieldId = S.fieldId and S.fieldTypeId = D.fieldTypeId and S.choiceId = T.choiceId group by S.fieldId order by F.field_name asc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['fieldId']] = $row;
        endwhile;
        return $arr;
    }

    public function getNotif($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys S,tbl_project P where P.userId = $id and P.projectId = S.projectId and S.isRead = 0 order by surveyId desc limit 5") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['surveyId']] = $row;
        endwhile;
        return $arr;
    }

    public function countNotif($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys S,tbl_project P where P.userId = $id and P.projectId = S.projectId and S.isRead = 0") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        return $ctr;
    }

    public function getTotal($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys where projectId = $id") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        return $ctr;
    }

    public function getFilteredData($id, $flag) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys where projectId = $id and isApproved = $flag") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        return $ctr;
    }

    public function getTextField($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_fields F,tbl_fieldtypes D,tbl_field_type_subtype S, tbl_subfieldtypes T where F.isActive = 1 and F.projectId = $id and F.fieldId = S.fieldId and S.fieldTypeId = D.fieldTypeId and S.subFieldTypeId = T.subFieldTypeId group by F.fieldId order by F.field_name asc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['fieldId']] = $row;
        endwhile;
        return $arr;
    }

    public function getFiltered($flag, $projectId) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys where isApproved = $flag and projectId = $projectId") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['surveyId']] = $row;
        endwhile;
        return $arr;
    }

    public function getField($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_fields where fieldId = $id") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['fieldId']] = $row;
        endwhile;
        return $arr;
    }

    public function getProject($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_project P,tbl_key K where P.projectId = $id and P.projectId = K.projectId order by P.projectId desc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['projectId']] = $row;
        endwhile;
        return $arr;
    }

    public function getProjects($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_project where userId = $id order by projectId desc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['projectId']] = $row;
        endwhile;
        return $arr;
    }

    public function searchProj($proj) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_project where project_name LIKE '$proj%' or project_code LIKE '$proj%' order by project_name asc limit 5") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['projectId']] = $row;
        endwhile;
        return $arr;
    }

    public function getSurveysApproved($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys where projectId = $id and isApproved = 1 order by surveyId desc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['surveyId']] = $row;
        endwhile;
        return $arr;
    }

    public function getSurveysOne($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys where surveyId = $id order by surveyId desc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['surveyId']] = $row;
        endwhile;
        return $arr;
    }
    public function getSurveys($id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_surveys where projectId = $id order by surveyId desc") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['surveyId']] = $row;
        endwhile;
        return $arr;
    }

    public function getDataSurvey($table, $order, $id, $projectId) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from $table where projectId = $projectId order by $order") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)):
            $arr[$row[$id]] = $row;
        endwhile;
        return $arr;
    }

    public function getDataTag($table, $order, $id, $projectId) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from $table where projectId = $projectId order by $order") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)):
            $arr[$row[$id]] = $row;
        endwhile;
        return $arr;
    }

    public function getData($table, $order, $id) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from $table order by $order") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)):
            $arr[$row[$id]] = $row;
        endwhile;
        return $arr;
    }

    public function getUser($userId) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_users where userId = '$userId'") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['userId']] = $row;
        endwhile;
        return $arr;
    }

    public function checkValue($table, $col, $id, $val) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from $table where $col LIKE '$val'") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row[$id]] = $row;
        endwhile;

        return $ctr;
    }

    public function checkValue2($table, $col, $id, $val, $userId) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from $table where $col LIKE '$val' and $id != $userId") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row[$id]] = $row;
        endwhile;

        return $ctr;
    }

    public function checkUsername($username, $flag) {
        $con = $this->connect("geotag_db2");
        $arr = array();
        $sql = mysql_query("SELECT * from tbl_users where username LIKE '$username'") or die(mysql_error());
        $ctr = mysql_num_rows($sql);
        while ($row = mysql_fetch_array($sql)):
            $arr[$row['userId']] = $row;
        endwhile;
        if ($flag == 1)
            return $ctr;
        else
            return $arr;
    }

    public function getFieldTypeSubType($projectId) {
        $connect = $this->connect("geotag_db2");

        $results_array = array();

        $sql = mysql_query("SELECT *,F.fieldId as autoId FROM tbl_fields F,tbl_field_type_subtype S, tbl_fieldtypes T, tbl_subfieldtypes B where F.projectId = '$projectId' and F.fieldId = S.fieldId and S.fieldTypeId = T.fieldTypeId and S.subFieldTypeId = B.subFieldTypeId order by autoId desc") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)) {
            $results_array[$row['autoId']] = $row;
        }

        return $results_array;
    }

    public function getFieldTypeChoices($projectId) {
        $connect = $this->connect("geotag_db2");

        $results_array = array();
        $sql = mysql_query("SELECT *,F.fieldId as autoId FROM tbl_fields F,tbl_field_type_choice S, tbl_fieldtypes T where F.projectId = '$projectId' and F.fieldId = S.fieldId and S.fieldTypeId = T.fieldTypeId group by F.fieldId order by autoId desc") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)) {
            $results_array[$row['fieldId']] = $row;
        }

        return $results_array;
    }

    public function getSelectedField($projectId, $fieldId) {
        $connect = $this->connect("geotag_db2");
        $sql = mysql_query("SELECT `field_name` FROM `tbl_fields` WHERE `projectId` = '$projectId' AND `fieldId` = '$fieldId';") or die(mysql_error());

        $row = mysql_fetch_array($sql);

        return $row['field_name'];
    }

    public function getSelectedFieldChoices($projectId, $fieldId) {
        $connect = $this->connect("geotag_db2");

        $results_array = array();
        $sql = mysql_query("SELECT 
        `tbl_project`.`projectId` AS `projectId`,
        `tbl_project`.`project_name` AS `project_name`,
        `tbl_project`.`image` AS `image`,
        `tbl_project`.`abbr` AS `abbr`,
        `tbl_project`.`survey_prefix` AS `survey_prefix`,        
        `tbl_fields`.`fieldId` AS `fieldId`,
        `tbl_fields`.`field_name` AS `field_name`,
        `tbl_fields`.`sort` AS `sort`,
        `tbl_fields`.`isRequired` AS `isRequired`,
        `tbl_fields`.`isActive` AS `isActive`,
        `tbl_fields`.`dateCreated` AS `dateCreated`,
        `tbl_fieldtypes`.`fieldTypeId` AS `fieldTypeId`,
        `tbl_fieldtypes`.`fieldType` AS `fieldType`,
        `tbl_fieldtypes`.`fieldTypeDisplay` AS `fieldTypeDisplay`,
        `tbl_choices`.`choiceId` AS `choiceId`,
        `tbl_choices`.`choiceName` AS `choiceName`
        FROM
        ((((`tbl_project`
        JOIN `tbl_fields` ON ((`tbl_project`.`projectId` = `tbl_fields`.`projectId`)))
        JOIN `tbl_field_type_choice` ON ((`tbl_fields`.`fieldId` = `tbl_field_type_choice`.`fieldId`)))
        JOIN `tbl_fieldtypes` ON ((`tbl_field_type_choice`.`fieldTypeId` = `tbl_fieldtypes`.`fieldTypeId`)))
        JOIN `tbl_choices` ON ((`tbl_field_type_choice`.`choiceId` = `tbl_choices`.`choiceId`)))
        WHERE 
        `tbl_project`.`projectId` = '$projectId' AND `tbl_fields`.`fieldId` = '$fieldId';") or die(mysql_error());

        while ($row = mysql_fetch_array($sql)) {
            $results_array[$row['choiceId']] = $row;
        }

        return $results_array;
    }

    public function getCountProjectFields($projectId) {
        $connect = $this->connect("geotag_db2");
        $sql = mysql_query("SELECT * FROM `tbl_fields` WHERE `projectId` = '$projectId' and isActive = 1") or die(mysql_error());
        $count = mysql_num_rows($sql);

        return $count;
    }

    public function getProjectInfo($userId) {
        $connect = $this->connect("geotag_db2");
        $results_array = array();
        $sql = mysql_query("SELECT * from tbl_project P, tbl_key K where P.projectId = K.projectId and userId = $userId order by P.dateCreated desc ") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)) {
            $results_array[$row['projectId']] = $row;
        }

        return $results_array;
    }

    public function getSelectedProjectInfo($projectId) {
        $connect = $this->connect("geotag_db2");
        $sql = mysql_query("SELECT `abbr` FROM `tbl_project` WHERE `projectId` = '$projectId';") or die(mysql_error());
        $row = mysql_fetch_array($sql);

        return $row['abbr'];
    }

    public function getProjectCount($fieldCriteria, $criteria) {
        $connect = $this->connect("geotag_db2");
        $sql = mysql_query("SELECT * FROM `tbl_project` WHERE `$fieldCriteria` = '$criteria';") or die(mysql_error());
        $count = mysql_num_rows($sql);

        return $count;
    }

    public function getFieldTypes() {
        $connect = $this->connect("geotag_db2");
        $results_array = array();

        $sql = mysql_query("SELECT * FROM `tbl_fieldtypes`;") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)) {
            $results_array[$row['fieldTypeId']] = $row;
        }

        return $results_array;
    }

    public function getSubFieldTypes() {
        $connect = $this->connect("geotag_db2");
        $results_array = array();

        $sql = mysql_query("SELECT * FROM `tbl_subfieldtypes`;") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)) {
            $results_array[$row['subFieldTypeId']] = $row;
        }

        return $results_array;
    }

    public function getAllFarmerSurveys($stationId, $farmerId) {
        $connect = $this->connect("geotag_db2");

        $results_array = array();
        $sql = mysql_query("SELECT *
        FROM 
        `tbl_project`
        JOIN
        `tbl_key` ON  `tbl_project`.`projectId` = `tbl_key`.`projectId`;") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)) {
            $results_array[$row['surveyId']] = $row;
        }

        return $results_array;
    }

    public function getCountNavSubItems($sectionId) {
        $connect = $this->connect("geotag_db2");
        $sql = mysql_query("SELECT * FROM `tbl_subsections` WHERE `sectionId` = '$sectionId' AND `isActive` = '1';") or die(mysql_error());
        $count = mysql_num_rows($sql);

        return $count;
    }

    public function getSideNavSub($sectionId) {
        $connect = $this->connect("geotag_db2");
        $results_array = array();
        $sql = mysql_query("SELECT * FROM `tbl_subsections` WHERE `sectionId` = '$sectionId' AND `isActive` = '1';") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)):
            $results_array[$row ['subSectionId']] = $row;
        endwhile;

        return $results_array;
    }

    public function getSideNav($userId) {
        $connect = $this->connect("geotag_db2");
        $results_array = array();
        $sql = mysql_query("SELECT * FROM `tbl_permissions` 
                JOIN `tbl_sections` ON `tbl_permissions`.`sectionId` = `tbl_sections`.`sectionId` WHERE `userId` = '$userId' AND `isActive` = '1';") or die(mysql_error());
        while ($row = mysql_fetch_array($sql)):
            $results_array[$row ['permissionId']] = $row;
        endwhile;

        return $results_array;
    }

    public function userAccountInfo($userId) {
        $connect = $this->connect("geotag_db2");
        $results_array = array();
        $sql = mysql_query("SELECT * FROM `tbl_users` 
                JOIN `tbl_employees` ON `tbl_users`.`employeeId` = `tbl_employees`.`employeeId` 
                JOIN `tbl_stations` ON `tbl_employees`.`stationId` = `tbl_stations`.`stationId` 
                JOIN `tbl_usertypes` ON `tbl_users`.`userTypeId` = `tbl_usertypes`.`userTypeId` WHERE `userId` = '$userId';");
        while ($row = mysql_fetch_array($sql)) {
            $results_array[$row['userId']] = $row;
        }

        return $results_array;
    }

}

?>
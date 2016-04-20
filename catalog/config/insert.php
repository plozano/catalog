<?php

 
include('config.php');  // The mysql database connection script



/**  INSERT DATA **/

    $data = json_decode(file_get_contents('php://input'),true);
    $courseName = $data['courseName'];
    $courseNumber = $data['courseNumber'];
    $length = $data['length'];
    $daysFromHire = $data['daysFromHire'];
    $trainingFreq = $data['trainingFreq'];
    $recAudience = $data['recAudience'];
    $courseDesc = $data['courseDesc'];
    $courseStatus = $data['courseStatus'];
    $categories = $data['categories'];
    $languageCode = $data['languageCode'];
    $topicDesc = $data['topicDesc'];
    var_dump($categories);


function insertArrTable($arrFiled, $tableName, $fieldName, $courseNumber, $fieldSecondName,$fieldThirdName, $jsoName, $jsoSecondName,  $conn) {
 if(is_array($arrFiled)){
        $valuesArr = array();
        $languageQry = "INSERT INTO $tableName ($fieldSecondName, $fieldName, $fieldThirdName) VALUES";

        foreach($arrFiled as $row){
                var_dump($row);
          $valuesArr[] = "('$courseNumber', '$row[$jsoName]', '$row[$jsoSecondName]')";

          //$valuesArr[] = "('$row[langIndex]', '$courseNumber', '$row[langCode]')"
        }
        
        $languageQry .= implode(',', $valuesArr);
        var_dump($languageQry);
        $resultSql = mysqli_real_escape_string($conn, $languageQry);
        $resultSql .= mysqli_query($conn, $languageQry);
          
    }

}
  

  $languages = insertArrTable($languageCode, 'tbllanguages', 'languageIndex', $courseNumber, 'courseNumber','languageCode','langIndex','langCode', $conn);

  $topics = insertArrTable($topicDesc, 'tbltopicscovered', 'topicIndex', $courseNumber, 'courseNumber','topicDesc','topicIndex','topicDesc', $conn);

  $categories = insertArrTable($categories, 'tblcategories', 'categoryIndex', $courseNumber, 'courseNumber','categoryCode','categoryIndex','categoryCode', $conn);

     
    $querry = "INSERT INTO tblcoursecatalog (courseName, courseNumber, length, daysFromHire, trainingFreq, recAudience, courseStatus, courseDesc) VALUES('$courseName', '$courseNumber', '$length', '$daysFromHire', '$trainingFreq', '$recAudience',  '$courseStatus', '$courseDesc')";
    $resultQuerry = mysqli_real_escape_string($conn, $querry);
    $resultQuerry .= mysqli_query($conn, $querry);


$conn->close();
?>

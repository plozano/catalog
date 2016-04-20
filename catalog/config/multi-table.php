<?php

include('config.php'); 

//Grabbed the individual topics, language and categories and grouped them with GROUP_CONCAT
$query = sprintf('SELECT tblcoursecatalog.courseName,tblcoursecatalog.courseNumber,tblcoursecatalog.length,tblcoursecatalog.daysFromHire,tblcoursecatalog.trainingFreq,tblcoursecatalog.recAudience, tblcoursecatalog.courseStatus, GROUP_CONCAT(DISTINCT CONCAT(tbllanguagecodes.languageCode,",",tbllanguagecodes.languageText,",",tbllanguages.languageIndex) ORDER BY tbllanguages.languageIndex), GROUP_CONCAT(DISTINCT CONCAT(tblcategoriescodes.categoryCode,",",tblcategoriescodes.categoryName,",",tblcategories.categoryIndex) ORDER BY tblcategories.categoryIndex),GROUP_CONCAT(DISTINCT CONCAT(tbltopicscovered.topicIndex,",",tbltopicscovered.topicDesc) ORDER BY tbltopicscovered.topicIndex),tblcoursecatalog.courseDesc,tbllanguagecodes.languageText FROM tblcoursecatalog left join tbltopicscovered on tblcoursecatalog.courseNumber = tbltopicscovered.courseNumber left JOIN tbllanguages on tblcoursecatalog.courseNumber = tbllanguages.courseNumber left join tblcategories on tblcoursecatalog.courseNumber = tblcategories.courseNumber left join tblcategoriescodes on tblcategoriescodes.categoryCode = tblcategories.categoryCode left join tbllanguagecodes on tbllanguagecodes.languageCode = tbllanguages.languageCode GROUP BY tblcoursecatalog.courseNumber');


// Escape Query
$result = mysqli_real_escape_string($conn, $query);

// Perform Query
$result = mysqli_query($conn, $query);

// Check result
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "";
    $message .= 'Whole query: ' . $query;
    die($message);
}

//Getting the query and pushing it to individual rows that the $course variable will hold
function getCatalog($result) {
  $courses = array();
  while ($catalog = mysqli_fetch_assoc($result)) {
    array_push($courses, $catalog);
  }
  return $courses; 
}

function getGroupTableIndvFieldInfo($course) {
  foreach ($course as $key => $value) {
    $singleCourseFields  = array (
                "courseName"        => addslashes($course['courseName']),
                "courseNumber"      => addslashes($course['courseNumber']),
                "length"            => addslashes($course['length']),
                "daysFromHire"      => addslashes($course['daysFromHire']),
                "trainingFreq"      => addslashes($course['trainingFreq']),
                "recAudience"       => addslashes($course['recAudience']),
                "courseStatus"      => addslashes($course['courseStatus']),
                "length"            => addslashes($course['length']),
                "courseDesc"        => addslashes($course['courseDesc'])
               );
  }
  $singleCourseFields = json_encode($singleCourseFields);
  $singleCourseFields = str_replace("{"," ","$singleCourseFields");
  print_r($singleCourseFields);
};

function getGroupTableInfo($course, $tableName, $name, $nameDesc) {
    $index = 'GROUP_CONCAT(DISTINCT ' . $tableName . ' ORDER BY ' . $tableName . ')';
    $topics = $course[$index];
    var_dump($topics);
    $topicBreakTopics = explode(",", $topics);

    echo  '"' . $nameDesc . '":' . '[' ;
    foreach ($topicBreakTopics as $topicSentence) {
      $topicSentence = addslashes($topicSentence);
      $invidualTopics = '{"' . $name . '":' .  '"'. $topicSentence . '"}';
        if($topicSentence !== end($topicBreakTopics)) { $invidualTopics .= ",";}         
      echo $invidualTopics;    
    }//end of topicBreakTopics foreach
     echo  '],'; 
};

function getGroupTableInfoTwoColumns($course, $tableName = 'tbltopicscovered.topicIndex', $secondTableName = 'tbltopicscovered.topicDesc', $name =  'topicIndex', $secondName =  'topic', $nameDesc = 'topicDesc' ) {
    $comma = '","';
    $index = 'GROUP_CONCAT(DISTINCT CONCAT'.'(' . $tableName . ',' . $comma  . ',' . $secondTableName . ')' . ' ORDER BY ' . $tableName . ')';
    
    $groupData = $course[$index];
    $groupBreakData = explode(",", $groupData);
    $groupTwoFields = array_chunk($groupBreakData, 2); 
    $finalTwoFields = array();
    $comma = ",";
    $countGroupField = count($groupTwoFields);

    echo '"'.$nameDesc.'":'; 

    for ($row = 0; $row <  $countGroupField; $row++) {
        $finalFields[] = array(
                  "$name"     => $groupTwoFields[$row][0],
                  "$secondName"     => $groupTwoFields[$row][1]
                  ); 
    }

    print_r(json_encode($finalFields));
    echo $comma; 
    return json_encode($finalFields); 
}

function getGroupTableInfoThreeColumns($course, $tableName, $secondTableName,$thirdTableName, $name, $secondName, $thirdName, $nameDesc) {
  $courseData = $course;
  $comma = '","';
  $index = 'GROUP_CONCAT(DISTINCT CONCAT'.'(' . $tableName . ',' . $comma  . ',' . $secondTableName . ',' . $comma . ',' . $thirdTableName . ')' . ' ORDER BY ' . $thirdTableName . ')';
  $indMergedFields = $course[$index];
  $indBreakFields = explode(",", $indMergedFields);
  $groupFields = array_chunk($indBreakFields, 3); 
  $finalFields = [];
  $comma = ",";
  $countgroupField = count($groupFields);

  echo '"'.$nameDesc.'":'; 

  for ($row = 0; $row <  $countgroupField; $row++) {

      $finalFields[] = array(
                "$name"     => $groupFields[$row][0],
                "$secondName"     => $groupFields[$row][1],
                "$thirdName"    => $groupFields[$row][2]
                ); 
  }
   //var_dump($finalFields);
    print_r(json_encode($finalFields));
    echo $comma; 
    return json_encode($finalFields); 
}

function getIndividualCourse($courses){    
  $beginArray = '[';
  $endArray = ']';
  $openBracket = '{';
  $endBracket = '}';
  $i = 0;
  $numItems = count($courses);
  $comma = ',';

  echo $beginArray;

  foreach ($courses as $course) {
      echo $openBracket;
        $topics = getGroupTableInfoTwoColumns($course, 'tbltopicscovered.topicIndex', 'tbltopicscovered.topicDesc','topicIndex', 'topic', 'topicDesc');
        $languages = getGroupTableInfoThreeColumns($course, 'tbllanguagecodes.languageCode', 'tbllanguagecodes.languageText','tbllanguages.languageIndex','langCode', 'langText', 'langIndex', 'languages');
        $categories = getGroupTableInfoThreeColumns($course, 'tblcategoriescodes.categoryCode', 'tblcategoriescodes.categoryName','tblcategories.categoryIndex', 'categoryCode','categoryText', 'categoryIndex', 'categories');
        
        $restOfCourse = getGroupTableIndvFieldInfo($course);
        if(++$i != $numItems) { $restOfCourse .= ",";} 
        echo $restOfCourse;    
     }//end s foreach

   echo $endArray;

} //end of function

$catalogueResultsFromQuery = getCatalog($result);
$individualCourses = getIndividualCourse($catalogueResultsFromQuery);

//close connection
 mysqli_close($conn);

?>
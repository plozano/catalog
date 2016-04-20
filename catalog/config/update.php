<?php

include('config.php');  // The mysql database connection script

   
   //print_r($topicDesc);
// function getUpdatedInfo($arrayField, $tableName, $firstField, $subField, $seconField, $courseNumber, $thirdField, $secondSubField){
    
//     if(is_array($arrayField)){
//         foreach($arrayField as $row){
//               var_dump($row);
//               $sql = "UPDATE $tableName SET $firstField='$row[$subField]' WHERE $seconField='$courseNumber' AND $thirdField = '$row[$secondSubField]'";
              
//             }
//      }
// }


// $test = getUpdatedInfo($languages, 'tbllanguages', 'languageCode', 'lancode', 'courseNumber', $courseNumber, 'languageIndex', 'langIndex');
//var_dump($test);

//UPDATE languages Array
    // if(is_array($languages)){

    //     foreach($languages as $row){
    //       var_dump($row['langCode']);
    //       $sql = "UPDATE tbllanguages SET languageCode='$row[langCode]' WHERE courseNumber='$courseNumber' AND languageIndex = '$row[langIndex]'";
          
    //     }

    //     $updateSqllang = mysqli_real_escape_string($conn, $sql);
    //     $updateSqllang .= mysqli_query($conn, $sql);

    //       if ($sql) {
    //         $arr = array('msg' => "Language Added Successfully!!!", 'error' => '');
    //         $jsn = json_encode($arr);
    //          print_r($jsn);
    //       } 
    //       else {
    //         $arr = array('msg' => "", 'error' => 'Error In inserting Language record');
    //         $jsn = json_encode($arr);
    //         print_r($jsn);
    //       }
    // }

switch($_GET['action'])  {
    case 'update_topic' :
            update_topic($conn);
            break;

    case 'update_course' :
            update_course($conn);
            break;

}


function update_topic($conn) {
        $data = json_decode(file_get_contents('php://input'),true);    
        $courseNumber = $data['courseNumber']; 
        $topicDesc = $data['topicDesc'];
       
    if (is_array($topicDesc)) {
            foreach($topicDesc as $row){
                $topic = "SELECT topicIndex, topicDesc, courseNumber FROM tbltopicscovered WHERE topicIndex ='$row[topicIndex]' and topicDesc='$row[topic]' and courseNumber='$courseNumber'";

                //var_dump($topic);
                $query = mysqli_query($conn, $topic);

                    if(mysqli_num_rows($query) > 0){

                        echo "topic already exists";
                    } else {
                        $valuesTopicArr = array();
                        $valuesTopicArr[] = "('$row[topicIndex]', '$row[topic]', '$courseNumber')";
                        //var_dump($valuesTopicArr);
                       
                        $topic = "INSERT INTO tbltopicscovered (topicIndex, topicDesc, courseNumber) VALUES";
                        $topic .= implode(',', $valuesTopicArr);
                        //var_dump($topic);
                        $resultTopic = mysqli_real_escape_string($conn, $topic);
                        $resultTopic .= mysqli_query($conn, $topic);
                    }//end of else
            }
    }           
 }

function update_course($conn) {
/**  Switch Case to Get Action from controller  **/
    $courseNumber = $_GET ['action'];
    $data = json_decode(file_get_contents('php://input'),true);
    $courseName = $data['courseName'];
    $courseNumber = $data['courseNumber'];
    $length = $data['length'];
    $daysFromHire = $data['daysFromHire'];
    $trainingFreq = $data['trainingFreq'];
    $recAudience = $data['recAudience'];
    $courseDesc = $data['courseDesc'];
    $languages = $data['languages'];
    $topicDesc = $data['topicDesc'];
    $courseStatus = $data['courseStatus'];

 //UPDATE topics 
    if(is_array($topicDesc)){
        foreach($topicDesc as $row){
            //var_dump($row['topic']);
            $topic = "UPDATE tbltopicscovered SET topicDesc='$row[topic]' WHERE  topicIndex='$row[topicIndex]' AND courseNumber='$courseNumber'";
            
        }

            //var_dump($topic);
            $updateSqltopic = mysqli_real_escape_string($conn, $topic);
            $updateSqltopic .= mysqli_query($conn, $topic);
            

            if (!$updateSqltopic) {
                $message  = 'Invalid query: ' . mysql_error() . "<br>";
                $message .= 'Whole query: ' . $query;
                die($message);
            }   
    }

    //UPDATE course catalog main table 
    $querry = "UPDATE tblcoursecatalog Set courseName='$courseName',  length= '$length', daysFromHire= '$daysFromHire', trainingFreq='$trainingFreq', recAudience='$recAudience', courseStatus='$courseStatus', courseDesc='$courseDesc' where courseNumber='$courseNumber'";

       //var_dump($querry);
    $updateSqlcourse = mysqli_real_escape_string($conn, $querry);
    $updateSqlcourse .= mysqli_query($conn, $querry);
     
         if (!$updateSqlcourse) {
                $message  = 'Invalid query: ' . mysql_error() . "<br>";
                $message .= 'Whole query: ' . $query;
                die($message);
            } 
  
}

$conn->close();
?>
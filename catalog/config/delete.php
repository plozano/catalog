<?php


include('config.php'); 

/**  Delete Course  **/

 if (isset($_GET ['courseNumber'])) {
      $courseNumber = $_GET ['courseNumber'];
      echo $courseNumber;
      
      $del = "DELETE FROM tblcoursecatalog WHERE courseNumber = ''; DELETE FROM tblcoursecatalog WHERE courseNumber = $courseNumber; DELETE FROM tbltopicscovered WHERE courseNumber = $courseNumber; DELETE FROM tblcategories WHERE courseNumber = $courseNumber; DELETE FROM tbllanguages WHERE courseNumber = $courseNumber";
      //var_dump($del);
      $del .= mysqli_multi_query($conn, $del) or die ("FAILED" .mysql_error());
 }

 if (isset($_GET ['action'])) {
	    $data = json_decode(file_get_contents('php://input'),true);    
	    $courseNumber = $data['courseNumber']; 
	    $topicDesc = $data['topicDesc'];
		  $topicDesc = end($topicDesc);
		  $lastTopic = $topicDesc['topicIndex'];

      $delTopic = "DELETE FROM tbltopicscovered WHERE topicIndex='$lastTopic' AND courseNumber='$courseNumber'";
      $delTopic .= mysqli_multi_query($conn, $delTopic) or die ("FAILED" .mysql_error());
 }

 $conn->close();
?>

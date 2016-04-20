
<?php

$servername = "localhost";
$username = "plozano";
$password = "abc123";
$dbname = "course-catalog";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check for errors
if(mysqli_connect_errno()){
 echo mysqli_connect_error();
}

//sql to create table
 $sql = "CREATE TABLE tblcoursecatalog (
  courseCat VARCHAR(30) NOT NULL,
  courseName VARCHAR(30) NOT NULL,
  courseNumber VARCHAR(30) NOT NULL,
  length VARCHAR(30) NOT NULL,
  daysFromHire VARCHAR(30) NOT NULL,
  trainingFreq VARCHAR(30) NOT NULL,
  recAudience VARCHAR(128) NOT NULL,
  courseDesc VARCHAR(128) NOT NULL,
  avaliableLang VARCHAR(30) NOT NULL,
  topicsCovered VARCHAR(350) NOT NULL,
  PRIMARY KEY (courseNumber)
  )";
  
  //sql to create table
 $sql2 = "CREATE TABLE tbltopicscovered (
  topicIndex int NOT NULL AUTO_INCREMENT,
  courseNumber VARCHAR(30) NOT NULL,
  topicDesc VARCHAR(450) NOT NULL,
  PRIMARY KEY (topicIndex, courseNumber)
  )";

 if ($conn->query($sql) === TRUE) {
     echo "Table Course Catalog has been created successfully";
 } else {
     echo "Error creating table: " . $conn->error;
 }
 
  if ($conn->query($sql2) === TRUE) {
     echo "Topics Table has been created successfully";
 } else {
     echo "Error creating table: " . $conn->error;
 }

//close connection
 mysqli_close($conn);

?>



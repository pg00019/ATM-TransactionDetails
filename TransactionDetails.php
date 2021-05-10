<html>
  <head>
    <style>
     /* css styling */
    body
    {
      background-image: url(bg.jpg);
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover ;
    }

    h2
    {
      position: relative;
      margin-top: 30px;
      text-align: center;
      border: 2px dotted grey;
    }

    div
    {
      margin: 100px 80px 120px 500px;
      display:inline-block;
      padding:10px 10px;
      border: 2px solid  ;
      font-family:Georgia, 'Times New Roman', Times, serif;
    }
    span
    {
      color : blue;
    }
    p
    {
      margin-top:40px;
      text-align: center;
      color:red;
      font-family:Verdana, Geneva, Tahoma, sans-serif;
      font-size:large;
    }
    </style>
  </head>
  <body>

<?php

//pass the value given by the user.
$ReferNo = $_POST["referNo"];


// database connectivity establishment
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atm";

// Create connection
$conn = new mysqli($servername, $username, $password);

//check connectivity
$connection = true;
if ($conn->connect_error)
 {
  	$connection = false;
 }
 
//creating database
$dbSql = "CREATE DATABASE IF NOT EXISTS atm";
  
$dbExists = false;
if ($conn->query($dbSql) === TRUE) 
{
	$dbExists = true;
}

// connecting to database
mysqli_select_db($conn, $dbname);

// checking if table exists
$tableExists = $conn->query('select 1 from records LIMIT 1');

// // creating table if doesn't exists
if ($tableExists == false && $dbExists == true) 
{
	$tableSql = "CREATE TABLE records (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		Transaction_Status	   varchar(10)  NOT NULL,
		Transaction_ID	       varchar(15)  NOT NULL,
		Transaction_Date	     date         NOT NULL,
		Transaction_Time	     time(6)      NOT NULL,
		Transaction_ReferNo	   int(10)      NOT NULL,
	  AccountNo	             varchar(20)  NOT NULL,
	  Transaction_Amount	   int(10)      NOT NULL,
		Payment_Mode	         varchar(20)  NOT NULL,
		reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)";

	if ($conn->query($tableSql) === TRUE) 
  {
		$tableExists = true;
	} 
  else 
  {
		$tableExists = false;
	}
}

//values retrieved from the database
$sql = " SELECT Transaction_Status  , Transaction_ID   , 
                Transaction_Date    , Transaction_Time , 
                Transaction_ReferNo , AccountNo        , 
                Transaction_Amount  , Payment_Mode  
                FROM transactiondetails WHERE Transaction_ReferNo='$ReferNo'";

$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
  // output data of each row
  while($row = $result->fetch_assoc()) 
  {
    
    echo "<h2>Transaction Details</h2>";
    echo "<div>";
    echo "         <b> Transaction Status  </b> &nbsp        : " . "<span><b>" .$row["Transaction_Status"] ."</b></span>" .
         "<br><br> <b> Transaction ID      </b>              : " .              $row["Transaction_ID"]     .
         "<br><br> <b> DATE                </b> &nbsp &nbsp  : " .              $row["Transaction_Date"]   . 
         "<br><br> <b> TIME                </b> &nbsp &nbsp  : " .              $row["Transaction_Time"]   . 
         "<br><br> <b> Account Number      </b>              : " .              $row["AccountNo"]          . 
         "<br><br> <b> AMOUNT &nbsp        </b>              : " . "Rs.&nbsp" . $row["Transaction_Amount"] . 
         "<br><br> <b> Payment_Mode        </b>              : " .              $row["Payment_Mode"]       ;
}
}  
else 
{
  echo "<p>"." Sorry! No results found "."</p>";
}
 echo "</div>"; 
//close the connection 
$conn->close();

// end of PHP
?>
<!-- end of body -->
</body>
<!-- end of HTML -->
</html>
<?php require_once('../../Connections/stusystem.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "111,222,333";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
global $stusystem;
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($stusystem, $theValue) : mysqli_escape_string($stusystem, $theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
      case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "password":
    $theValue = ($theValue != "") ? "'" . md5($theValue) . "'" : "NULL";
    break; 
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


$colname_teacheraward = "-1";
if (isset($_GET['TeacherID'])) {
  $colname_teacheraward = $_GET['TeacherID'];
}
//42320819($database_stusystem, $stusystem);
$query_teacheraward = sprintf("SELECT a.*,b.*,c.* FROM tbl_teacheraward as a left join  tbl_awardtype as b on a.AwardTypeID=b.AwardTypeID left join  tbl_academicyears as c on a.AwardYear=c.AcademicYearsID WHERE a.TeacherID = %s and  (a.AwardTypeID=b.AwardTypeID or b.AwardTypeID is null ) and  (a.AwardYear=c.AcademicYearsID or c.AcademicYearsID is null )", GetSQLValueString($colname_teacheraward, "text"));
$teacheraward = mysqli_query($stusystem, $query_teacheraward) or die(mysqli_error($stusystem));
$row_teacheraward = mysqli_fetch_assoc($teacheraward);
$totalRows_teacheraward = mysqli_num_rows($teacheraward);

$colname_teacher = "-1";
if (isset($_GET['TeacherID'])) {
  $colname_teacher = $_GET['TeacherID'];
}
//42320819($database_stusystem, $stusystem);
$query_teacher = sprintf("SELECT a.*,b.* FROM tbl_teacher as a, tbl_prefix as b WHERE TeacherID = %s and a.PrefixCode=b.PrefixCode", GetSQLValueString($colname_teacher, "text"));
$teacher = mysqli_query($stusystem, $query_teacher) or die(mysqli_error($stusystem));
$row_teacher = mysqli_fetch_assoc($teacher);
$totalRows_teacher = mysqli_num_rows($teacher);

$colname_teacher = "-1";
if (isset($_GET['TeacherID'])) {
  $colname_teacher = $_GET['TeacherID'];
}
//42320819($database_stusystem, $stusystem);
$query_Teacher = sprintf("SELECT a.*,b.* FROM tbl_teacher as a, tbl_prefix as b WHERE TeacherID = %s and a.PrefixCode=b.PrefixCode", GetSQLValueString($colname_Teacher, "text"));
$Teacher = mysqli_query($stusystem, $query_Teacher) or die(mysqli_error($stusystem));
$row_Teacher = mysqli_fetch_assoc($Teacher);

$currentPage = $_SERVER["PHP_SELF"];

$queryString_studentaward1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_studentaward1") == false && 
        stristr($param, "totalRows_studentaward1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_studentaward1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_studentaward1 = sprintf("&totalRows_studentaward1=%d%s", $totalRows_studentaward1, $queryString_studentaward1);

$queryString_studentaward2 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_studentaward2") == false && 
        stristr($param, "totalRows_studentaward2") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_studentaward2 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_studentaward2 = sprintf("&totalRows_studentaward2=%d%s", $totalRows_studentaward2, $queryString_studentaward2);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ระบบจัดการข้อมูลผลงานอาจารย์</title>
<link rel="stylesheet" href="../../css/bootstrap.css">
<script type="text/javascript" src="../../css/jquery.datetimepicker.css"></script>
<script type="text/javascript" src="../../js/bootstrap.js"></script>
<script type="text/javascript" src="../../js/jquery-1.11.2.min.js"></script>

</head>

<body>
<?php
$page_active= 10;
?>

  <?php include ("../../head.php");?>
  <!---เมนูหน้าข้อมูลอาจารย์--->
<?php include ("../teacher-menu.php");?>
  <!--จบเมนูหน้าข้อมูลอาจารย์-->
  
  <div class="col-sm-7">
    <h1 style="text-align:center;">ระบบจัดการข้อมูลผลงาน/รางวัล อาจารย์</h1>
    <h3 style="text-align:center;"><?php echo $row_teacher['PrefixName']; ?><?php echo $row_teacher['name']; ?> <?php echo $row_teacher['surname']; ?> </h3> <div style="text-align:right">
    
   <a href="insert.php?TeacherID=<?php echo $row_teacher['TeacherID']; ?>" class="btn btn-success">เพิ่มผลงาน/รางวัล</a>
    
    </div>
    <?php if ($totalRows_teacheraward > 0) { // Show if recordset not empty ?>
  <h3 style="text-align:left;">
    ผลงาน/รางวัล
  </h3>
    <br>
      
      <table class="table table-hover">
        <thead>
          <tr>
            <th>ประเภทผลงาน/รางวัล</th>
            <th>ชื่อผลงาน</th>
            <th>ปีการศึกษา</th>
            <th>จัดการข้อมูล</th>
            <th>ลบ</th>
          </tr>
        </thead>
        
        <tbody>
          <?php do { ?>
          
  <tr>
    <td><?php echo $row_teacheraward['AwardTypeName']; ?></td>
    <td><?php echo $row_teacheraward['AwardName']; ?></td>
    <td><?php echo $row_teacheraward['AcademicYears']; ?></td>
    <td><a href="view.php?TeacherID=<?php echo $row_teacher['TeacherID']; ?>&AwardID=<?php echo $row_teacheraward['AwardID']; ?>" class="btn btn-primary">จัดการข้อมูล</a></td>
    <td><a href="delete.php?AwardID=<?php echo $row_teacheraward['AwardID']; ?>&TeacherID=<?php echo $row_teacher['TeacherID']; ?>" class="btn btn-danger"onclick="return confirm('คุณแน่ใจที่จะลบข้อมูลนี้')">ลบ</a></td>
    
    </tr>
          <?php } while ($row_teacheraward = mysqli_fetch_assoc($teacheraward)); ?>
        </tbody>
    </table>
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_teacheraward == 0) { // Show if recordset empty ?>
      <br>
        <table class="table table-hover">
    <tbody>
      <tr>
        <td style="text-align:center;">ไม่มีข้อมูล</td>
       
        </tr>
      
      </tbody>
  </table>
  <?php } // Show if recordset empty ?>
  </div>
  
  <div class="col-sm-2">
  
   <?php include ("../teacher-menu2.php");?> 
   
  </div>
  
  
  
</body>
</html>
<?php
mysqli_free_result($teacher);

mysqli_free_result($teacheraward);
?>

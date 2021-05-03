<?php include("DBconnect.php");
// Creates roleID variable in advance to prevent error during query initialisation
$roleID = 0;
$readMembers = $db->query("SELECT * FROM members");
$readRoleNames = $db->query("SELECT * FROM `event pattern`");
// $getRoleName = $db->query("SELECT RoleName FROM `event pattern` WHERE `RoleID` = 2");
?>

<br>
<br>

<!-- Form to input new member info to add to DB -->
<form method="post">
  <input type="text" placeholder="First and last name" name="names"></input>
  <select name="roleID">
    <?php while(
      // Fetches each line one by one
      $currentRead = $readRoleNames->fetch()
    ) { ?>
      <!-- Creates an option for each line in DB -->
      <option value="<?php
        echo $currentRead['RoleID'];
      ?>">
        <?php echo $currentRead['RoleName']; ?>
      </option>
    <?php } ?>
  </select>
  <input type="submit" value="Add to DB" name="submit"></input>
</form>

<!-- Modular member display table -->
<table>
  <?php while(
    // Fetches each line one by one
    $currentRead = $readMembers->fetch()
  ) { ?>
    <tr>
      <!-- Creates all collumns for each line -->
      <td> <?php echo $currentRead['ID']; ?> </td>
      <td> <?php echo $currentRead['FirstName']; ?> </td>
      <td> <?php echo $currentRead['LastName']; ?> </td>
      <td> <?php echo $currentRead['RoleID']; ?> </td>
    </tr>
  <?php } ?>
</table>

<?php if(
  // Proceeds if submit button is pressed, and form data exists and is not null.  
  isset($_POST["submit"]) &&
  isset($_POST["names"]) && 
  !empty($_POST["names"]) &&
  isset($_POST["roleID"])
) {
  // Splits the names into their own variables
  $names = $_POST["names"];
  $splitNames = explode(" ", $names);
  $firstName = $splitNames[0];
  $lastName = $splitNames[1];
  $roleID = $_POST["roleID"];
  // $SQL_Query = '$db->query("SELECT * FROM `event pattern` WHERE `RoleID` = \'$roleID\'");"';
  $roleIDName = "temp"; // $getRoleName->fetch(); // $SQL_Query;
  $echoOutput = "\"$names\" as a \"$roleIDName\"";

  // Sends the form data to the database
  $insertion = $db->prepare(
    "INSERT INTO `members` (FirstName, LastName, RoleID)
    VALUES ('$firstName', '$lastName', '$roleID')"
  ); $insertion->execute();

  } else {
    $echoOutput = "nothing";
  } ?>

<br>

<?php echo "> You added ", $echoOutput, " to the database"; ?>
<?php include("DBconnect.php");
$readMembers = $db->query(
  "SELECT * FROM members"
);
?>

<br>
<br>

<!-- Form to input new member info to add to DB -->
<form method="post">
  <input type="text" placeholder="First and last name" name="names"></input>
  <!-- <input type="dropdown" name="roleID"></input> -->
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
  !empty($_POST["names"]) // &&
  // isset($_POST["roleID"])
) {
  // Splits the names into their own variables
  $names = $_POST["names"];
  $splitNames = explode(" ", $names);
  $firstName = $splitNames[0];
  $lastName = $splitNames[1];

  // placeholder variable for the RoleID
  $roleID = 1;
  $roleIDName = "placeholder role name";
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
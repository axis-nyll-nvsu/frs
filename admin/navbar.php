<?php
/*
 * Navigation Bar
 * Description: Common Navigation Bar Template
 * Author: Vernyll Jan P. Asis
 */
?>

<header class="main-header" style="position: fixed; top: 0; width: 100%;">
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"><span class="sr-only">Toggle Navigation</span></a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">

<?php
$sql = "SELECT * FROM frs_users WHERE id = '".$_SESSION['user_id']."'";
$stmt = $this->db->query($sql);
$row = $stmt->fetch();
?>

            <img src="../images/<?php echo $row['image']; ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $row['first_name'] . " " . $row['last_name']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="../images/<?php echo $row['image']; ?>" class="img-circle" alt="User Image">
              <p><?php echo $row['first_name'] . " " . $row['last_name']; ?></p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="#profile" data-toggle="modal" class="btn btn-default btn-flat" id="admin_profile" 
                data-user_id="<?php echo $_SESSION['user_id']; ?>" 
                data-firstname="<?php echo $row['first_name']; ?>" 
                data-middlename="<?php echo $row['middle_name']; ?>" 
                data-lastname="<?php echo $row['last_name']; ?>" 
                data-email="<?php echo $row['email']; ?>" 
                data-address="<?php echo $row['address']; ?>"
                data-contact="<?php echo $row['contact']; ?>">Update</a>
              </div>
              <div class="pull-right"><a href="logout.php" class="btn btn-default btn-flat">Log Out</a></div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
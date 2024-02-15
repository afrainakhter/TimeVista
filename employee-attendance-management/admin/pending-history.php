<?php
session_start();

if (empty($_SESSION['name'])) {
    header('location:index.php');
}

include('header.php');
include('includes/connection.php');

if (isset($_GET['ids'])) {
    $id = $_GET['ids'];
    $delete_query = mysqli_query($connection, "DELETE FROM tblleaves WHERE Lid='$id'");
}

if (isset($_POST['approve'])) {
    if (isset($_POST['approve_lid'])) {
        $id = $_POST['approve_lid'];
        $updateQuery = "UPDATE tblleaves SET Status = 1 WHERE Lid = $id";
        mysqli_query($connection, $updateQuery);

        // ... (remaining code for leave approval)
    }
}

if (isset($_POST['decline'])) {
    if (isset($_POST['decline_lid'])) {
        $id = $_POST['decline_lid'];
        $updateQuery = "UPDATE tblleaves SET Status = 2 WHERE Lid = $id";
        mysqli_query($connection, $updateQuery);
        $msg = "Leave Request Is deleted Successfully";
    }
}

$fetch_query = mysqli_query($connection, "SELECT tblleaves.Lid, 
                   tbl_employee.id, 
                   tbl_employee.first_name, 
                   tbl_employee.last_name, 
                   tblleaves.LeaveType, 
                   tblleaves.PostingDate, 
                   tblleaves.ToDate, 
                   tblleaves.FromDate, 
                   tblleaves.duration,
                   tblleaves.Description, 
                   tblleaves.Status 
            FROM tblleaves 
            JOIN tbl_employee ON tblleaves.employee_id = tbl_employee.id 
            WHERE tblleaves.Status = 0
            ORDER BY Lid DESC");
?>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Pending Leaves</h4>
            </div>
        </div>
        <div class="table-responsive">
            <table class="datatable table table-stripped">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Leave Type</th>
                        <th>To Date</th>
                        <th>From Date</th>
                        <th>Duration(Days)</th>
                        <th>Description</th>
                        <th>Posting Date</th>
                        <th>Employee ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($fetch_query)) {
                    ?>
                        <form method="post" action="">
                            <tr>
                                <td><?php echo $row['first_name'] ?></td>
                                <td><?php echo $row['last_name'] ?></td>
                                <td><?php echo $row['LeaveType'] ?></td>
                                <td><?php echo $row['ToDate']; ?></td>
                                <td><?php echo $row['FromDate']; ?></td>
                                <td><?php echo $row['duration']; ?></td>
                                <td><?php echo $row['Description']; ?></td>
                                <td><?php echo $row['PostingDate']; ?></td>
                                <td><?php echo $row['id']; ?></td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <input type="hidden" name="approve_lid" value="<?php echo $row['Lid']; ?>">
                                        <button style="background-color: green; color: white;" type="submit" name="approve">Approve</button>
                                        <br>
                                        <input type="hidden" name="decline_lid" value="<?php echo $row['Lid']; ?>">
                                        <button style="background-color: red; color: white;" type="submit" name="decline">Decline</button>
                                    </div>
                                </td>
                            </tr>
                        </form>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script type="text/javascript">
    <?php
    if (isset($msg)) {
        echo 'swal("' . $msg . '");';
    } else {
        echo 'swal("' . $error . '");';
    }
    ?>
</script>

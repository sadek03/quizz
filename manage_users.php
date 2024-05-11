<?php
    include('layout/header.php');
?>
<div class="container my-4">
    <div class="bg-white p-3 rounded">
        <h5>Users List</h5>
        <hr>
        <table class="table hover-table" id="ppTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Attempted Tests</th>
                    <th>Joined At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q = mysqli_query($conn, "SELECT * FROM users");
                    $serial = 1;
                    while($res = mysqli_fetch_array($q)){
                        $count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM test_records WHERE user_id = '$res[id]'"));
                        ?>
                            <tr>
                                <td><?= $serial++?></td>
                                <td><?= $res['name']?></td>
                                <td><?= $res['email']?></td>
                                <td><?= $res['phone']?></td>
                                <td><?= $count?></td>
                                <td><?= $res['created_at']?></td>
                                <td>
                                    <a href="test_list.php?user_id=<?= $res['id']?>" class="btn btn-primary">View Tests</a>
                                </td>
                            </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
    include('layout/footer.php');
?>
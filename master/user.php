<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}


$url = "$BaseURL/api/fetching.php/";

$content = json_encode(array('fetch' => 'users'), JSON_FORCE_OBJECT);

// function call curlcall($url,$content){  }
$response = curlcall($url, $content);
if (@$response['message'] == 'no data found') {
    header("location:temp.php?error=No data available.");
    die();
}

?>
<div>
    <section class="section">
        <div class="section-header">
            <h1>Users</h1>
        </div>

        <div class="section-body">
            <div id="productinfo" class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                        <div class="form-group fa-pull-left">
                                <input class="form-control py-2 bor" type="search" onkeyup="search('usersearch','tblusers','0')" placeholder="search" id="usersearch">
                            </div>
                            <table class="table" id="tblusers">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Orders
                                        </th>
                                        <th>
                                            Address
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_posts_body">
                                    <?php foreach ($response as $row) { ?>
                                        <tr>
                                            <td><b><?= @$row['user_name']; ?></b></td>
                                            <td><?= @$row['name']; ?></td>
                                            <td><?= @$row['email']; ?></td>
                                            <td>
                                                <a href="javascript:void(0)" class="allorders" id="allorders_<?= $row['id']; ?>" name="userid_<?= $row['id']; ?>">All Orders</a>
                                            </td>

                                            <td>
                                                <a href="javascript:void(0)" class="alladdress" id="alladdress_<?= $row['id']; ?>" name="userid_<?= $row['id']; ?>">All Address</a>
                                            </td>

                                        </tr>
                                    <?php   } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade bd-example-modal-lg" id="useraddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="divuseraddress" style="margin-left: 35px;">
                        <div class="col-sm-6" id="divuseraddresseven">

                        </div>
                        <div class="col-sm-6" id="divuseraddressodd">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".allorders").click(function() {
            var id = this.id.split('_')[1];

            $.cookie("orderuserid", id);

            showDiv();
            pageload("master/allorders.php");

        });

        $(".alladdress").click(function() {
            var id = this.id.split('_')[1];
            showalladdress(id)
        });

    });
</script>
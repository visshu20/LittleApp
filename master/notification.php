<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
$url = "$BaseURL/api/fetching.php/";
$content = json_encode(array('fetch' => 'notifications'), JSON_FORCE_OBJECT);
$response = curlcall($url, $content);

?>
<div>
    <section class="section">
        <div class="section-header">
            <h1>Notifications</h1>
        </div>

        <div class="section-body">
            <div id="productinfo" class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group fa-pull-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#notificationModel">
                                    Add
                                </button>
                            </div>


                            <table class="table table-bordered" id="tbl_posts">
                                <thead>
                                    <tr style="background-color: #956f00">
                                        <th>Id</th>
                                        <th>Notification</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_posts_body">
                                    <?php if ($response == '') { ?>
                                        <tr>
                                            <td colspan="3">NO DATA FOUND</td>
                                        </tr>
                                    <?php   } else { ?>

                                        <?php foreach ($response as $row) { ?>
                                            <tr id="rec-1">
                                                <td><?= @$row['id']; ?></td>
                                                <td><?= @$row['notification']; ?></td>
                                                <td>
                                                    <a onclick="deletetext('<?= @$row['id']; ?>','delete_notification')" class="ml-3" id="editproduct" name="Product_<?= @$row['id']; ?>">
                                                        <i class="fa fa-trash" style="color:red;cursor:pointer"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                    <?php   }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form id="notificationform">

        <div class="modal fade bd-example-modal-lg" id="notificationModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationModelTitle">Notifications</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="NotificationModelclose1">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Nofication</label>
                                    <input type="text" class="form-control" id="notificationtext" name="notification" maxlength="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="NotificationModelclose2">Close</button>
                        <button type="button" class="btn btn-primary" id="savenotification">Save</button>
                    </div>
                </div>
            </div>
        </div>
</div>
</form>


<script>
    $(document).ready(function() {
        var validator = $("#notificationform").validate({
            rules: {
                notification: "required",
            },
            messages: {
                notification: "Please enter Notification",
            }
        });

        $("#savenotification").click(function() {
            if ($("#notificationform").valid()) {
                savenotification();
            }

        });

        $("#NotificationModelclose1,#NotificationModelclose2").click(function() {
            validator.resetForm();
        });
    })
</script>
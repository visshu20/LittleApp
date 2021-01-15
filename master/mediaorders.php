<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
$url = "$BaseURL/api/fetching.php";
$content = json_encode(array('fetch' => 'media_orders'), JSON_FORCE_OBJECT);
$response = curlcall($url, $content);
?>

<div>
    <section class="section">
        <div class="section-header">
            <h1>Media Orders</h1>
        </div>

        <div class="section-body">
            <div id="orders" class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">

                            <div class="form-group fa-pull-left">
                                <input class="form-control py-2 bor" type="search" onkeyup="search('mediaordersearch','mediaorder','1')" placeholder="search" id="mediaordersearch">
                            </div>
                            <table class="table" id="mediaorder">
                                <thead>
                                    <tr>
                                        <th>OrderId</th>
                                        <th>Mobile</th>
                                        <th>DeliveryBy</th>
                                        <th>Status</th>
                                        <th>Timestamp</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php if ($response == '') { ?>
                                        <tr>
                                            <td colspan="7">No Media Orders to Display</td>
                                        </tr>
                                    <?php   } else { ?>
                                        <?php foreach ($response as $row) { ?>
                                            <tr>
                                                <td><b><?= @$row['id']; ?></b></td>
                                                <td><?= @$row['phone']; ?></td>
                                                <td contenteditable="true" class="deliveryby" id="<?= @$row['id']; ?>" title="<?= @$row['deliveryby']; ?>">
                                                    <?= @$row['deliveryby']; ?>
                                                    <input type="hidden" id="prev_order_status_<?= @$row['id']; ?>" name="prev_order_status_" value="<?= @$row['status']; ?>">
                                                    <input type="hidden" id="order_id" name="order_id" value="<?php echo $row['id']; ?>"><label for="delivered"></label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="status_<?= @$row['id']; ?>" name="status" <?php if (@$row['status'] == "Cancelled"||@$row['status'] == "Delivered") echo "disabled"; ?> onchange="updateorderStatus(<?= @$row['id']; ?>,this,'media')">
                                                        <option value="">--select--</option>
                                                        <option value="Ordered" <?php if (@$row['status'] == "Ordered") echo "SELECTED"; ?>>Ordered</option>
                                                        <option value="Inprogress" <?php if (@$row['status'] == "Inprogress") echo "SELECTED"; ?>>Inprogress</option>
                                                        <option value="Delivered" <?php if (@$row['status'] == "Delivered") echo "SELECTED"; ?>>Delivered</option>
                                                        <option value="Cancelled" <?php if (@$row['status'] == "Cancelled") echo "SELECTED"; ?>>Cancelled</option>
                                                    </select>
                                                </td>
                                                <td><?= @$row['ordered']; ?></td>
                                            </tr>
                                    <?php   }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form id="mediaorderform" class="needs-validation" novalidate="">
        <div class="modal fade bd-example-modal-lg" id="mediaorderformModalCenter" tabindex="-1" role="dialog" aria-labelledby="mediaorderformModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 1px solid #dee2e6;">
                        <h5 class="modal-title" id="mediaorderformModalLongTitle">Media Orders</h5>
                        <button type="button" class="close" data-dismiss="modal" id="clearform1" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div></div>
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">DeliveryBy</label>
                                <input type="text" class="form-control" id="deliveryby" name="deliveryby">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Ordered Dates</label>
                                <input type="text" class="form-control" id="ordereddate" name="ordereddate">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Total</label>
                                <input type="text" class="form-control" id="total" name="total">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="control-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">--select--</option>
                                    <option value="1">ordered</option>
                                    <option value="2">inprogress</option>
                                    <option value="3">delivered</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Product Image</label>
                                <input type="text" class="form-control" id="imageurl" name="imageurl" placeholder="Image url">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="clearform2" data-dismiss="modal">Close</button>
                            <input type="hidden" id="mediaid" />
                            <button type="button" id="savechanges" name="add" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>

<script>
   $(document).ready(function() {
        var preText;
        $(".deliveryby").click(function(e) {
            preText='';
            preText = e.currentTarget.title;
        });

        $(".deliveryby").keydown(function(event) {
            if (13 == event.which) { // press ENTER-key
                var text = this.innerText;
                var id = this.id;
                var data = {
                    id: id,
                    name: text,
                }
                $.ajax({
                    url: BaseURL + "/api/orderactions.php",
                    method: "POST",
                    data: {
                        data: data,
                        action: "updatemediadeliveryby"
                    },
                    dataType: "json",
                    success: function(response) {
                        $.simplyToast(response, 'success');
                        pageload("master/mediaorders.php");
                    }
                });
                event.preventDefault();
                return false;
            } else if (27 == event.which) { // press ESC-key
                this.innerText= preText;
            }

        });
        $(".deliveryby").focusout(function(e) {
            e.currentTarget.innerText = preText;
        });
    });
</script>
<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}

@$user_id = $_COOKIE['orderuserid'];

$url = "$BaseURL/api/fetchAllUserOrders.php/";

$content = json_encode(array('fetch' => $user_id), JSON_FORCE_OBJECT);


$response = curlcall($url, $content);

?>
<div>
    <section class="section">
        <div class="section-header">
            <h1>All Orders</h1>
        </div>

        <div class="section-body">
            <div id="productinfo" class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group fa-pull-left">
                                <input class="form-control py-2 bor" type="search" onkeyup="search('allordersearch','tblallorders','0')" placeholder="search" id="allordersearch">
                            </div>
                            <table class="table" id="tblallorders">
                                <thead>
                                    <tr>
                                        <th>OrderId</th>
                                        <th>
                                            Mobile
                                        </th>
                                        <th>
                                            Ship To
                                        </th>
                                        <th>
                                            selling price
                                        </th>
                                        <th>
                                            Purchased Date
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($response == '') { ?>
                                        <tr>
                                            <td colspan="6">No Orders To Display</td>
                                        </tr>
                                    <?php   } else { ?>
                                        <?php foreach ($response as $row) { ?>
                                            <tr>
                                                <td><?= @$row['id']; ?></td>
                                                <td><?= @$row['mobile']; ?></td>
                                                <td style="text-align:center"><?= @$row['line1']; ?>&nbsp;<?= @$row['city']; ?>&nbsp;<br><?= @$row['state']; ?>&nbsp;<?= @$row['country']; ?>&nbsp;<?= @$row['pincode']; ?><?= @$row['landamrk']; ?>&nbsp;</td>
                                                <td><?= @$row['total']; ?></td>
                                                <td><?= @$row['date_ordered']; ?></td>
                                                <td><i style="color:green" aria-hidden="true"><?= @$row['status']; ?></i></td>
                                                <td>
                                                    <!-- <form method="POST" action="#"> -->
                                                    <input type="hidden" name="orderId" value="<?= @$row['id']; ?>">
                                                    <input type="hidden" name="user_id" value="<?= @$user_id ?>">
                                                    <a type="button" href="javascript:void(0)" name="<?= @$row['id']; ?>" value="<?= @$row['id']; ?>" id="vieworderedproduct" class="vieworderedproduct">View ordered Products</a>
                                                    <!-- </form> -->
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

    <div class="modal fade bd-example-modal-lg" id="orderedproducts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ordered Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="tblorderedproducts">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Original Price</th>
                                <th>Selling Price</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot style="background-color: #e3eaef;">

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(".vieworderedproduct").click(function() {
     
        var id = this.name;
        vieworderedproducts(id);

    });
    // $(".vieworderedproduct").click(function() {
    //     var id = this.name;
    //     vieworderedproducts(id);

    // });
</script>
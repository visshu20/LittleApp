<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
// $url = "$BaseURL/api/fetching.php/";
// $content = json_encode(array('fetch' => 'enabledProducts'), JSON_FORCE_OBJECT);
// $response = curlcall($url, $content);
$query = "SELECT  (SELECT COUNT(*)FROM user) AS users,(SELECT COUNT(*)FROM product) AS products,(SELECT COUNT(*)FROM orders) AS orders FROM dual";
$result = $pdo->prepare($query);
$result->execute();
$list = $result->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT  (select count(*) from orders where status='cancelled') AS cancelled,
(select count(*) from orders where status='delivered') AS delivered,
(select count(*) from orders where status='inprogress') AS inproress,
 (select count(*) from orders where status='ordered') AS ordered
FROM    dual";
$result1 = $pdo->prepare($query);
$result1->execute();
$list1 = $result1->fetchAll(PDO::FETCH_ASSOC);

$query = "select * from pincode";
$pincoderesult = $pdo->prepare($query);
$pincoderesult->execute();
$pincodelist = $pincoderesult->fetchAll(PDO::FETCH_ASSOC);

$url = "$BaseURL/api/fetching.php";
$content = json_encode(array('fetch' => 'allorders'), JSON_FORCE_OBJECT);
$orderresult = curlcall($url, $content);

?>
<style>
    .tableFixHead {
        overflow-y: auto;
        height: 150px;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
    }
</style>
<div>
    <section class="section">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">
                            Order Statistics
                            <!-- <div class="dropdown d-inline">
                                <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">August</a>
                                <ul class="dropdown-menu dropdown-menu-sm">
                                    <li class="dropdown-title">Select Month</li>
                                    <li><a href="#" class="dropdown-item">January</a></li>
                                    <li><a href="#" class="dropdown-item">February</a></li>
                                    <li><a href="#" class="dropdown-item">March</a></li>
                                    <li><a href="#" class="dropdown-item">April</a></li>
                                    <li><a href="#" class="dropdown-item">May</a></li>
                                    <li><a href="#" class="dropdown-item">June</a></li>
                                    <li><a href="#" class="dropdown-item">July</a></li>
                                    <li><a href="#" class="dropdown-item active">August</a></li>
                                    <li><a href="#" class="dropdown-item">September</a></li>
                                    <li><a href="#" class="dropdown-item">October</a></li>
                                    <li><a href="#" class="dropdown-item">November</a></li>
                                    <li><a href="#" class="dropdown-item">December</a></li>
                                </ul>
                            </div> -->
                        </div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count"><?= @$list[0]['users']; ?></div>
                                <div class="card-stats-item-label">Users</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count"><?= @$list[0]['products']; ?></div>
                                <div class="card-stats-item-label">Products</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count"><?= @$list[0]['orders']; ?></div>
                                <div class="card-stats-item-label">Total Orders</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Inproress</h4>
                        </div>
                        <div class="card-body">
                            <?= @$list1[0]['inproress']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Ordered</h4>
                        </div>
                        <div class="card-body">
                            <?= @$list1[0]['ordered']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="sales-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Delivered</h4>
                        </div>
                        <div class="card-body">
                            <?= @$list1[0]['delivered']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="cancell-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Cancelled</h4>
                        </div>
                        <div class="card-body">
                            <?= @$list1[0]['cancelled']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h4>Invoices</h4>
                        <!-- <div class="card-header-action">
                            <a href="#" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                        </div> -->
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice tableFixHead">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>OrderID</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($orderresult == '') { ?>
                                        <tr>
                                            <td colspan="5">
                                                <label>No Invoices to Display</label>
                                            </td>
                                        </tr>

                                    <?php   } else { ?>

                                        <?php foreach ($orderresult as $row) { ?>
                                            <tr>

                                                <td><b><?= @$row['id']; ?></b></td>
                                                <td><?= @$row['name']; ?></td>
                                                <td>
                                                <?= @$row['phone']; ?>
                                                </td>
                                                <td><?= @$row['status']; ?></td>
                                                <td>
                                                    <a href="#">Detail</a>
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
            <div class="col-md-3 col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Active Pincodes</h4>
                        <div class="card-header-action">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#pincodemodel">
                                Add
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        
                        <div class="table-responsive tableFixHead">
                            <table class="table table-striped">
                                <tbody>
                                    <?php if ($pincodelist == '') { ?>
                                        <tr>
                                            <td colspan="2">
                                                <label>NO DATA FOUND</label>
                                            </td>
                                        </tr>

                                    <?php   } else { ?>

                                        <?php foreach ($pincodelist as $row) { ?>
                                            <tr>
                                                <td contenteditable="true" class="pincodeedit" id="<?= @$row['id']; ?>" title="<?= @$row['pincode']; ?>">
                                                    <?= @$row['pincode']; ?>
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
</div>

<form id='submitpincodeform'>
    <div class="modal fade bd-example-modal-sm" id="pincodemodel" tabindex="-1" role="dialog" aria-labelledby="pincodemodelCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pincodemodelTitle">Pincode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="pincodemodelclose1">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" maxlength="6">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="pincodemodelclose2">Close</button>
                    <input type="hidden" id="pincodeid" />
                    <button type="button" class="btn btn-primary" id="submitpincode">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="assets/js/page/index.js"></script>
<script>
    $(document).ready(function() {

        var id;
        var validator = $("#submitpincodeform").validate({
            rules: {
                pincode: "required",
            },
            messages: {
                pincode: "Please enter pincode",
            }
        });

        $("#submitpincode").click(function() {
            if ($("#submitpincodeform").valid()) {
                submitpincode('', 'insert');
            }
        });

        $("#pincodemodelclose1,#pincodemodelclose2").click(function() {
            validator.resetForm();
            $('#submitpincodeform').find('input:text').val('');
        });

        var preText;
        $(".pincodeedit").click(function(e) {
            preText = '';
            preText = e.currentTarget.title;
        });

        $(".pincodeedit").keydown(function(event) {

            if (13 == event.which) { // press ENTER-key
            
                var text = this.innerText;
                var id = this.id;
                if (text != '') {

                    $.ajax({
                        url: BaseURL + "/actions.php",
                        method: "POST",
                        data: {
                            id: id,
                            pincode: text,
                            action: 'pincodeaction',
                            type: 'update'
                        },
                        dataType: "json",
                        success: function(response) {
                            $.simplyToast(response, 'success');
                            pageload("dashboard/edashboard.php");
                        }
                    });
                } else {
                    $.simplyToast("pincode should not be empty", 'danger');
                }
                event.preventDefault();
                return false;
            } else if (27 == event.which) { // press ESC-key
                this.innerText = preText;
            }

        });
        $(".pincodeedit").focusout(function(e) {
            e.currentTarget.innerText = preText;
        });
    })
</script>
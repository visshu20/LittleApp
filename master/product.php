<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
$url = "$BaseURL/api/fetching.php/";
$content = json_encode(array('fetch' => 'enabledProducts'), JSON_FORCE_OBJECT);
$response = curlcall($url, $content);
$query = "select * from category";
$categorylist = $pdo->prepare($query);
$categorylist->execute();


?>

<div id="mydiv">
    <section class="section">
        <div class="section-header">
            <h1>Enabled Products</h1>
        </div>

        <div id="enabledproductinfo" class="section-body">
            <div class="card">

                <div class="card-body">
                    <div class="form-group fa-pull-left">
                        <input class="form-control py-2 bor" type="search" onkeyup="search('productsearch','tblproducts','1')" placeholder="search" id="productsearch">
                    </div>
                    <div class="form-group fa-pull-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            Add
                        </button>
                    </div>


                    <table class="table" id="tblproducts">

                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Original Price</th>
                                <th>Discount Price</th>
                                <th>Selling Price</th>
                                <th>weight</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_posts_body">
                            <?php if ($response == '') { ?>
                                <tr>
                                    <td colspan="8">No Products To Display</td>
                                </tr>
                            <?php   } else { ?>

                                <?php foreach ($response as $row) { ?>
                                    <tr id="rec-1">
                                        <td><img src="<?= @$row['image']; ?>" id='img-upload' style="height:25px;width:35px" class="imm"></td>
                                        <td><?= @$row['name']; ?></td>
                                        <td><?= @$row['category']; ?></td>
                                        <td><?= @$row['original']; ?></td>
                                        <td><?= @$row['discount']; ?></td>
                                        <td><?= @$row['selling']; ?></td>
                                        <td><?= @$row['weight']; ?></td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" id="onoffswitch_<?= $row['id'] ?>" name="onoffswitchenabled" value="<?= $row['availability'] ?>" class="js-switch" <?= $row['availability'] == '1' ? 'checked' : ''; ?> />
                                                <span class="slider round"></span>
                                            </label>
                                            <a onclick="GetUserDetails('<?= @$row['id']; ?>','enablededit')" class="ml-3" id="editproduct" name="Product_<?= @$row['id']; ?>">
                                                <i class="fa fa-edit" style="color:green;cursor:pointer"></i>
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

    </section>
    <form id="productform" class="needs-validation" novalidate="">
        <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 1px solid #dee2e6;">
                        <h5 class="modal-title" id="exampleModalLongTitle">Enabled Product</h5>
                        <button type="button" class="close" data-dismiss="modal" id="clearform1" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div></div>
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">ProductName</label>
                                <input type="text" class="form-control" id="productname" name="productname">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">--select--</option>
                                    <?php foreach ($categorylist as $category) {
                                    ?>
                                        <option value="<?php echo $category["id"]; ?>"><?php echo $category["category"]; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">Weight</label>
                                        <input class="form-control" type="text" id="weighttext" name="weighttext"/>
                                    </div>
                                    <div class="col-md-4">
                                    <label class="control-label">Unit</label>
                                        <select class="form-control" id="weightselect" name="weightselect">
                                            <option value=""></option>
                                            <option value="1">kg</option>
                                            <option value="2">gram</option>
                                            <option value="3">ltr</option>
                                            <option value="4">ml</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Original Price</label>
                                <input type="text" class="form-control" id="originalprice" name="originalprice">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Selling Price</label>
                                <input type="text" class="form-control" id="sellingprice" name="sellingprice">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Product Image</label>
                                <input type="text" class="form-control" id="productimage" name="productimage" placeholder="Image url">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="clearform2" data-dismiss="modal">Close</button>
                            <input type="hidden" id="product_id" />
                            <button type="button" id="savechanges" name="add" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>

<script>
    $(document).ready(function() {

        var validator = $("#productform").validate({
            rules: {
                productname: "required",
                weight: "required",
                originalprice: "required",
                sellingprice: "required",
                category: "required",
                productimage: "required"
            },
            messages: {
                productname: "Please enter your productname",
                weight: "Please enter your weight",
                originalprice: "Please enter your Original Price",
                sellingprice: "Please enter your Selling Price",
                category: "Please select category",
                productimage: "Please enter image url"
            }
        });

        $("#clearform2,#clearform1").click(function() {
            clearfields();
            validator.resetForm();
        });



        $("#savechanges").click(function() {
            if ($("#productform").valid()) {
                createproduct('enablededit');
            }
        });
        $('input[name=onoffswitchenabled]').click(function() {
            var id = $(this).attr('id').split('_')[1];
            var status = $(this).val();
            var name = this.name;
            updatestatus(id, status, name)

        });

    });
</script>
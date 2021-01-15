<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}


@$restaurantid = $_COOKIE['restaurantid'];

$query = "CALL GetRestarantInfo($restaurantid)";
$result = $pdo->prepare($query);
$result->execute();

//Restaurant Info
if ($result->rowCount() > 0) {
    $response = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    $response = "";
}

//Restaurant Items info

$result->nextRowset();
if ($result->rowCount()) {
    $restaurantiteminfo = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    $restaurantiteminfo = [];
}

//Restaurant Item_category info

$result->nextRowset();
if ($result->rowCount()) {
    $itemcategoryinfo = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    $itemcategoryinfo = "";
}

//Item_category info

$result->nextRowset();
if ($result->rowCount()) {
    $itemcategory = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    $itemcategory = "";
}

?>
<style>
    .checked {
        color: orange;
    }

    ._2n5YQ {
        margin-right: 6px;
        font-size: 12px;
        position: relative;
        top: -1px;
    }

    ._1De48 {
        color: black;
        opacity: .7;
        font-weight: 400;
        font-size: 12px;
        margin-top: 5px;
    }

    ._2l3H5 {
        color: inherit;
        font-weight: 600;
        font-size: 16px;
    }

    ._2aZit {
        display: inline-flex;
    }

    ._2fC4N {
        padding-top: 30px;
    }

    ._2iUp9 {
        padding: 0 35px;
        border-right: 1px solid #6c757d;
        color: black;
    }

    ._2iUp9:last-child {
        border-right: none;
        padding-left: 35px;
        padding-right: 0;
    }
</style>

<div>
    <section class="section">
        <div class="section-header">
            <h1>Restaurants</h1>
        </div>
        <div class="section-body">
            <div id="productinfo" class="section-body">

                <div class="card">
                    <input type="hidden" id="restaurant_id" />
                    <div>
                        <a href="javascript:void(0)" id="back" style="float: right;padding-top: 20px;padding-right: 20px;">
                            Back to Restaurant
                        </a>
                    </div>
                    <?php foreach ($response as $row) { ?>

                        <div class="media" style="padding-top: 20px;padding-left:65px ;padding-bottom: 20px;">
                            <div>
                                <a href="#">
                                    <img class="media-object" src="<?= @$row['image']; ?>" style="border-radius: 10px;width: 350px;height: 250px;">
                                </a>
                            </div>

                            <div>
                                <div style="padding: 0 35px;">
                                    <h1 style="font-size: 2em;color:#191d21;"><?= @$row['name']; ?> </h1>
                                    <span style="color: black;"> <?= @$row['restaurantcategories']; ?><br /></span>
                                </div>
                                <div style="padding: 0 35px;padding-top: 5px;">
                                    <span style="color: black;"> <?= @$row['restaurant_loc']; ?><br /></span>
                                </div>

                                <div class="_2aZit _2fC4N">
                                    <div class="_2iUp9 ">
                                        <div class="_2l3H5"><span><span class="_2n5YQ fa fa-star checked"></span><?= @$row['rating']; ?></span></div>
                                        <div class="_1De48"><span class="_1iYuU">Ratings</span></div>
                                    </div>
                                    <div class="_2iUp9">
                                        <div class="_2l3H5"><span><?= @$row['type']; ?></span></div>
                                        <div class="_1De48"><span class="_1iYuU">Type</span></div>
                                    </div>
                                    <div class="_2iUp9">
                                        <div class="_2l3H5"><span class="_27qo_"><?= @$row['min_order']; ?></span></div>
                                        <div class="_1De48">Delivery Time</div>
                                    </div>
                                    <div class="_2iUp9">
                                        <div class="_2l3H5"><span> <?= @$row['phone']; ?></span></div>
                                        <div class="_1De48">Phone</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php   }
                    ?>
                    <div class="border-top my-3" style="padding-top: 20px;"></div>

                    <div class="form-group fa-pull-right" style="padding-right: 30px;">
                        <button type="button" class="btn btn-primary fa-pull-right" style="border-radius:7px" data-toggle="modal" data-target="#exampleModalCenter" id="additem">
                            Add
                        </button>
                    </div>
                    <div class="row" style="padding-top: 20px;padding-left: 20px;">
                        <div class="col-md-4 border-right">
                            <ul class="list-unstyled" style="text-align: right;">
                                <?php if ($itemcategoryinfo !== "") { ?>
                                    <?php foreach ($itemcategoryinfo as $category) {
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link itemcat" style="font-size: x-large; font-weight: 800;" href="javascript:void(0)" id="<?= preg_replace('/[^a-zA-Z]+/', '', @$category['category']); ?>_<?= @$category['id']; ?>"><?php echo $category["category"]; ?></a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                <?php
                                } else {
                                ?>
                                    <div>
                                        <h5>No Items to display</h5>
                                    </div>
                                <?php
                                }
                                ?>
                            </ul>

                        </div>
                        <div class="col" id="rightitemcat" style="padding-left: 17px;">
                            <?php foreach ($restaurantiteminfo as $row) { ?>
                                <div class="<?php if ($row['category'] != "Biryani") echo "d-none" ?> <?= preg_replace('/[^a-zA-Z]+/', '', @$row['category']); ?>_<?= @$row['itemid']; ?> rightitem" id="<?= preg_replace('/[^a-zA-Z]+/', '', @$row['category']); ?>_<?= @$row['itemid']; ?>">
                                    <ul class="list-unstyled">
                                        <li class="media">
                                            <img class="mr-3" src="<?= @$row['image']; ?>" alt="" width="130px" height="130px" style="border-radius: 8px">

                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1"><?= @$row['name']; ?></h5>
                                                <?php if ($row['type'] == "Non-Veg") { ?>
                                                    <img class="mr-3" src="../../Little_App_New/assets/img/avatar/non-vegetarian-food-symbol.png" alt="" width="20px" height="20px" style="border-radius: 8px"> &nbsp;&#x20B9; <?= @$row['price']; ?>
                                                <?php } else { ?>
                                                    <img class="mr-3" src="../../Little_App_New//assets/img/avatar/vegetarian-food-symbol.png" alt="" width="20px" height="20px" style="border-radius: 8px"> &nbsp;&#x20B9; <?= @$row['price']; ?>
                                                <?php    } ?>
                                            </div>
                                            <div class="col" style="padding-top: 2px;">
                                                <a href="javascript:void(0)" class="fas fa-edit itemedit" id="<?= @$row['id']; ?>"> </a>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                            <?php   }

                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</div>
</section>
</div>
<form id="itemfrom" class="needs-validation" novalidate="">
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid #dee2e6;">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Item</h5>
                    <button type="button" class="close btnclose" data-dismiss="modal" id="clearform1" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div></div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" id="itemname" name="itemname">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Category</label>

                            <select class="form-control" id="itemcategory" name="itemcategory">
                                <option value="">--select--</option>
                                <?php if ($itemcategory !== "") { ?>
                                    <?php foreach ($itemcategory as $category) {
                                    ?>
                                        <option value="<?php echo $category["id"]; ?>"><?php echo $category["type"]; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">--select--</option>
                                <option value="1">Veg</option>
                                <option value="2">Non-Veg</option>
                                <option value="3">Veg&Non-Veg</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="quantity">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">--select--</option>
                                <option value="1" selected>Active</option>
                                <option value="2">InActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label">Item Image</label>
                            <input type="text" class="form-control" id="itemimage" name="itemimage" placeholder="Image url">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btnclose" id="clearform2" data-dismiss="modal">Close</button>
                        <input type="hidden" id="item_id" />
                        <button type="button" id="savechanges" name="add" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
</form>

<script>
    $(document).ready(function() {

        var validator = $("#itemfrom").validate({
            rules: {
                itemname: "required",
                itemcategory: "required",
                type: "required",
                price: "required",
                quantity: "required",
                status: "required",
                itemimage: "required"

            },
            messages: {
                itemname: "Please enter Name",
                itemcategory: "Please select category",
                type: "Please select type",
                price: "Please enter price",
                quantity: "Please enter quantity",
                status: "Please select status",
                itemimage: "Please enter item image URL"
            }
        });

        $("#savechanges").click(function() {
            if ($("#itemfrom").valid()) {
                if ($("#savechanges").hasClass('editmode')) {
                    saverestaurantitem($('#item_id').val());
                } else {
                    saverestaurantitem('');
                }

            }

        });

        $(".itemcat").click(function(event) {
            debugger;
            var leftid = this.id
            $(".rightitem").each(function(event) {
                var rightid = this.id
                if (leftid == rightid) {
                    $("." + rightid).removeClass('d-none');
                } else {
                    $("." + rightid).addClass('d-none');
                }
            });
        });

        function saverestaurantitem(id) {
            let actionTp;
            if (id == '') {
                actionTp = 'insert'
            } else {
                actionTp = 'update'
            }

            data = {
                name: $("#itemname").val(),
                itemcategory: $("#itemcategory").val(),
                type: $("#type :selected").text().trim(),
                price: $("#price").val(),
                quantity: $("#quantity").val(),
                status: $("#status").val(),
                itemimage: $("#itemimage").val(),
                restaurantid: $.cookie("restaurantid"),
                actionType: actionTp,
                itemid: id
            }

            $.ajax({
                url: BaseURL + "/actions.php",
                method: "POST",
                data: {
                    data: data,
                    action: "restaurant_item_action"
                },
                dataType: "json",
                success: function(response) {
                    $('#exampleModalCenter').modal('hide');
                    $.simplyToast(response, 'success');
                    pageload("master/restaurantinfo.php");
                }
            });
        }
        $(".itemedit").click(function(event) {
            $('#item_id').val(this.id);
            $.ajax({
                url: BaseURL + "/actions.php",
                method: "POST",
                data: {
                    id: this.id,
                    action: "restaurant_item_get"
                },
                dataType: "json",
                success: function(response) {
                    $("#exampleModalCenter").modal('show');
                    $("#savechanges").addClass('editmode');
                    $("#itemname").val(response[0].name);
                    $("#itemcategory").val(response[0].category);
                    $("#type    option").filter(function() {
                        return this.text == response[0].type;
                    }).attr('selected', true);
                    $("#price").val(response[0].price);
                    $("#quantity").val(response[0].quantity);
                    $("#status").val(response[0].active);
                    $("#itemimage").val(response[0].image);
                }
            });
        });


        $(".btnclose").click(function() {
            validator.resetForm();
            $('#itemfrom').find('input:text').val('');
            $("#status").val(1);
            $('#type').val('');
            $('#itemcategory').val('')
        });

        $("#back").click(function() {
            $('#item_id').val('');
            $.cookie("restaurantid", "")
            showDiv();
            pageload("master/restaurant.php");
        });
    })
</script>
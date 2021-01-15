<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}

if (isset($_COOKIE['restaurantid'])) {
    unset($_COOKIE['restaurantid']);
    setcookie('restaurantid', '', time() - 3600, '/');
}

$query = 'CALL GetAllRestaurants()';
$result = $pdo->prepare($query);
$result->execute();
if ($result->rowCount() > 0)
    $response = $result->fetchAll(PDO::FETCH_ASSOC);
else
    $response = "";
$result->nextRowset();
if ($result->rowCount() > 0)
    $restaurantcategory = $result->fetchAll(PDO::FETCH_ASSOC);
else
    $restaurantcategory = "";
$result->nextRowset();
if ($result->rowCount() > 0)
    $itemcategory = $result->fetchAll(PDO::FETCH_ASSOC);
else
    $itemcategory = "";
?>

<style>
    .checked {
        color: orange;
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
                    <div class="card-header" style="display: block;">
                        <div class="form-group fa-pull-right">
                            <button type="button" class="btn btn-primary" style="border-radius:7px" data-toggle="modal" data-target="#exampleModalCenter" id="addrestaurant">
                                Add
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="row">
                                <?php if ($response == "") { ?>
                                    <div style="margin-left: 384px;">
                                        <img src="../../Little_App_New/assets/img/avatar/no_data_found.png">
                                    </div>
                                <?php   } else { ?>

                                    <?php foreach ($response as $row) { ?>

                                        <div class="col-lg-3 col-md-4 col-6">

                                            <div class="card">
                                                <a onclick="getRestaurantinfo(<?= @$row['id']; ?>)" class="ml-3" id="mediacategoryedit" href="javascript:void(0);">
                                                    <img src="<?= @$row['image']; ?>" class="card-img-top" alt="" style="height:173px;">
                                                </a>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="d-flex justify-content-between">
                                                               <span><h6 class="card-title" style="display: inline-block;color:#191d21;"><?= @$row['name']; ?></h6></span> 
                                                               <span><i class="fas fa-edit restaurantedit" style="padding: 0 20px;color:#191d21;" id="<?= @$row['id']; ?>"></i></span> 
                                                            </div>
                                                            <span class="fa fa-star checked"></span>
                                                            <span style="font-weight: 700;"><?= @$row['rating']; ?><br /></span>
                                                            <span style="color:#191d21"><?= @$row['restaurantcategories']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                <?php   }
                                }
                                ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<form id="restaurantfrom" class="needs-validation" novalidate="">
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid #dee2e6;">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Restaurants</h5>
                    <button type="button" class="close btnclose" data-dismiss="modal" id="clearform1" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div></div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" id="restaurantname" name="restaurantname">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Restaurant Category</label>

                            <select class="form-control" id="restaurant_category" name="restaurantcategory" multiple="multiple">
                                <?php if ($restaurantcategory !== "") { ?>
                                    <?php foreach ($restaurantcategory as $category) {
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
                            <select class="form-control" id="item_type" name="itemtype">
                                <option value="">--select--</option>
                                <option value="1">Veg</option>
                                <option value="2">NonVeg</option>
                                <option value="3">Veg NonVeg</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label">Min Order</label>
                            <input type="text" class="form-control" id="minorder" name="minorder">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Delivery Time</label>
                            <input type="text" class="form-control" id="deliverytime" name="deliverytime">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label"> Restaurant Location</label>
                            <input type="text" class="form-control" id="restaurantioc" name="restaurantioc">

                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Restaurant Image</label>
                            <input type="text" class="form-control" id="restaurantimage" name="restaurantimage" placeholder="Image url">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btnclose" id="clearform2" data-dismiss="modal">Close</button>
                        <input type="hidden" id="restaurant_id" />
                        <button type="button" id="savechanges" name="add" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {

        $(".restaurantedit").click(function(event) {
            $('#restaurant_id').val(this.id);
            $.ajax({
                url: BaseURL + "/actions.php",
                method: "POST",
                data: {
                    id: this.id,
                    action: "restaurant_restaurant_get"
                },
                dataType: "json",
                success: function(response) {
                    let ids = [];
                    $("#exampleModalCenter").modal('show');
                    $("#savechanges").addClass('editmode');
                    $("#restaurantname").val(response[0].name);
                    var cat = response[0].categories;
                    if (cat.search(',') != -1) {
                        ids = cat.split(',');
                    } else {
                        ids = [cat];
                    }



                    $('#restaurant_category option:selected').each(function() {
                        $(this).prop('selected', false);
                    })

                    $('#restaurant_category').multiselect('refresh');

                    $("#restaurant_category").multiselect('select', ids);

                    let itemtypeid = $('#item_type option').filter(function() {
                        return $(this).html() == response[0].type.trim();
                    }).val();

                    $("#item_type").val(itemtypeid)
                    $("#minorder").val(response[0].min_order);
                    $("#deliverytime").val(response[0].delivery_time);
                    $("#phone").val(response[0].phone);
                    $("#restaurantioc").val(response[0].restaurant_loc);
                    $("#status").val(response[0].active);
                    $("#restaurantimage").val(response[0].image);
                }
            });
        });

        $("#item_category").multiselect({
            enableFiltering: true,
            includeSelectAllOption: true
        });
        $("#restaurant_category").multiselect({
            noneSelectedText: 'Select Something (required)',
            enableFiltering: true,
            includeSelectAllOption: true
        });

        $.validator.addMethod("needsSelection", function(value, element) {
            var count = $(element).find('option:selected').length;
            return count > 0;
        });
        $.validator.messages.needsSelection = 'Please select restaurant category';

        var validator = $("#restaurantfrom").validate({
            rules: {
                restaurantname: "required",
                restaurantcategory: "required needsSelection",
                itemtype: "required",
                minorder: "required",
                deliverytime: "required",
                phone: "required",
                restaurantioc: "required",
                restaurantimage: "required",
                status: "required"
            },
            ignore: ':hidden:not("#restaurant_category")',

            messages: {
                restaurantname: "Please enter Name",
                itemtype: "Please select item category",
                minorder: "Please enter min order",
                deliverytime: "Please enter delivery time",
                phone: "Please enter phone",
                restaurantioc: "Please enter IOC",
                restaurantimage: "Please enter URL",
                status: "Please select status"
            }
        });

        $("#savechanges").click(function() {
            if ($("#restaurantfrom").valid()) {
                var id = $("#restaurant_id").val();
                if ($("#savechanges").hasClass('editmode')) {
                    saverestaurant(id);
                } else {
                    saverestaurant('');
                }
            }

        });

        function saverestaurant(id) {

            if (id == '') {
                actionTp = 'insert'
            } else {
                actionTp = 'update'
            }

            data = {
                name: $("#restaurantname").val(),
                restaurantcategory: $("#restaurant_category").val().toString(),
                type: $("#item_type :selected").text().trim(),
                minorder: $("#minorder").val(),
                deliverytime: $("#deliverytime").val(),
                phone: $("#phone").val(),
                restaurantioc: $("#restaurantioc").val(),
                restaurantimage: $("#restaurantimage").val(),
                status: parseInt($("#status").val()),
                actionType: actionTp,
                restaurantid: id
            }

            $.ajax({
                url: BaseURL + "/actions.php",
                method: "POST",
                data: {
                    data: data,
                    action: "restaurant_action"
                },
                dataType: "json",
                success: function(response) {
                    $('#exampleModalCenter').modal('hide');
                    $.simplyToast(response, 'success');
                    showDiv();
                    pageload("master/restaurant.php");
                    $("#restaurant_id").val("")
                }
            });
        }



        $("#addrestaurant").click(function() {
            clearallinputs()
        });


        $(".btnclose").click(function() {
            clearallinputs()
        });

        function clearallinputs() {
            $('#restaurant_id').val('');
            validator.resetForm();
            $('#restaurantfrom').find('input:text').val('');
            $('#item_type').val('');
            $('#restaurant_category option:selected').each(function() {
                $(this).prop('selected', false);
            })
            $('#restaurant_category').multiselect('refresh');
        }
    })
</script>
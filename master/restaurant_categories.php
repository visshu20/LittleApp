<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
$url = "$BaseURL/api/fetching.php/";
$restaurant_content = json_encode(array('fetch' => 'restaurantcategory'), JSON_FORCE_OBJECT);
$restaurant_response = curlcall($url, $restaurant_content);

$item_content = json_encode(array('fetch' => 'itemcategory'), JSON_FORCE_OBJECT);
$item_response = curlcall($url, $item_content);

?>
<div>
    <section class="section">
        <div class="section-header">
            <h1>Restaurant Category</h1>
        </div>
        <div class="section-body">
            <div id="productinfo" class="section-body">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Restaurant Category</h4>
                                        <div class="card-header-action">
                                            <button type="button" class="btn btn-success" data-toggle="modal" name="restaurant" id="restaurant_category">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <div class="table-responsive tableFixHead">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <?php if ($restaurant_response == '') { ?>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label>NO DATA FOUND</label>
                                                            </td>
                                                        </tr>

                                                    <?php   } else { ?>

                                                        <?php foreach ($restaurant_response as $row) { ?>
                                                            <tr>
                                                                <td contenteditable="true" class="category_edit" id="<?= @$row['id']; ?>" title="restaurant">
                                                                    <?= @$row['type']; ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" style="color:red" class="close btndelete" aria-label="Close" id="<?= @$row['id']; ?>" title="restaurant">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
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
                            <div class="col-md-6 col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Item Category</h4>
                                        <div class="card-header-action">
                                            <button type="button" class="btn btn-success" data-toggle="modal" name="item" id="item_category">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <div class="table-responsive tableFixHead">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <?php if ($item_response == '') { ?>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label>NO DATA FOUND</label>
                                                            </td>
                                                        </tr>

                                                    <?php   } else { ?>

                                                        <?php foreach ($item_response as $row) { ?>
                                                            <tr>
                                                                <td contenteditable="true" class="category_edit" id="<?= @$row['id']; ?>" title="item">
                                                                    <?= @$row['type']; ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" style="color:red" class="close btndelete" aria-label="Close" id="<?= @$row['id']; ?>" title="item">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<form id='category_form'>
    <div class="modal fade bd-example-modal-sm" id="categorymodel" tabindex="-1" role="dialog" aria-labelledby="pincodemodelCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pincodemodelTitle">Category</h5>
                    <button type="button" class="close btnclose" data-dismiss="modal" aria-label="Close" id="pincodemodelclose1">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="category" name="category" placeholder="Category Type">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnclose" data-dismiss="modal" id="categorymodelclose2">Close</button>
                    <input type="hidden" id="pincodeid" />
                    <button type="button" class="btn btn-primary" id="submitcategory">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {

        var id;
        var rqtype;
        var validator = $("#category_form").validate({
            rules: {
                category: "required",
            },
            messages: {
                category: "Please enter Category type",
            }
        });

        $("#restaurant_category,#item_category").click(function(event) {
            rqtype = this.name;
            $("#categorymodel").modal('show')
        });

        $("#submitcategory").click(function() {
            validator.resetForm();
            if ($("#category_form").valid()) {
                actioncategory(rqtype, $("#category").val(), '');
            }
        });

        $(".btnclose").click(function() {
            validator.resetForm();
            $('#category_form').find('input:text').val('');
        });

        var preText;
        $(".category_edit").click(function(e) {
            preText = '';
            preText = e.currentTarget.title;
        });

        $(".btndelete").click(function(event) {
            deletecategory(this.id, this.title)
        });

        $(".category_edit").keydown(function(event) {
            if (13 == event.which) { // press ENTER-key
                if (this.innerText != '') {

                    actioncategory(this.title, this.innerText, this.id);
                } else {
                    $.simplyToast("Category type should not be empty", 'danger');
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

        function actioncategory(type, category, id) {
            var action;
            var data = {
                id: id,
                categorie: category,
                type: type
            };
            if (id == '') {
                action = "insertcategory"
            } else {
                action = "updatecategory";
            }
            $.ajax({
                url: BaseURL + "/actions.php",
                method: "POST",
                data: {
                    data: data,
                    action: action
                },
                dataType: "json",
                success: function(response) {
                    $.simplyToast(response, 'success');
                    $('#categorymodel').modal('hide');
                    pageload("master/restaurant_categories.php");



                }
            });

        }
    })
</script>
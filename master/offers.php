<?php
require_once("../database/connection.php");
require_once("../database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
$url = "$BaseURL/api/fetching.php/";
$content = json_encode(array('fetch' => 'offers'), JSON_FORCE_OBJECT);
$response = curlcall($url, $content);

?>
<div>
    <section class="section">
        <div class="section-header">
            <h1>Offers</h1>
        </div>

        <div class="section-body">
            <div id="productinfo" class="section-body">
                <div class="card">

                    <div class="card-header" style="display: block;">
                        <div class="form-group fa-pull-right">
                            <button type="button" class="btn btn-primary" style="border-radius:7px" data-toggle="modal" data-target="#offerModel">
                                Add
                            </button>
                        </div>
                    </div>


                    <div class="card-body">


                        <div class="row" style="margin-top: auto;">

                            <?php if ($response == '') { ?>
                                <div class="col-lg-3 col-md-4 col-6">
                                    <label>NO DATA FOUND</label>
                                </div>
                            <?php   } else { ?>

                                <?php foreach ($response as $row) { ?>

                                    <div class="col-lg-3 col-md-4 col-6">
                                        <span class="close" id="<?= @$row['id']; ?>">&times;</span>
                                        <img class="img-fluid img-thumbnail" src="<?= @$row['image_url']; ?>" alt="" style="height:173px;width:auto;">
                                    </div>

                            <?php   }
                            }
                            ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<form id='submitofferform'>
    <div class="modal fade bd-example-modal-lg" id="offerModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="offerModelTitle">Offers</h5>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="offersurl" name="offersurl" placeholder="Enter URL">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="offerModelclose2">Close</button>
                    <button type="button" class="btn btn-primary" id="submitoffer">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-sm" id="mi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Are you sure you want to delete?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="yes">Yes</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="modal-btn-no">No</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        var id;
        var validator = $("#submitofferform").validate({
            rules: {
                offersurl: "required",
            },
            messages: {
                offersurl: "Please enter url",
            }
        });

        $("#submitoffer").click(function() {
            if ($("#submitofferform").valid()) {
                submitoffer();
            }
        });

        $("#offerModelclose1,#offerModelclose2").click(function() {
            validator.resetForm();
        });

        $(".close").click(function(e) {
            $("#mi-modal").modal('show');
            id = e.currentTarget.id;
        });

        $("#yes").click(function() {
            deletetext(id, 'delete_offers');
            $("#mi-modal").modal('hide');
            id = '';
        });
    })
</script>
var BaseURL = "http://localhost/Little_App_New";
// var BaseURL="http://shikastudio.com/LittleApp/";
$(document).ready(function () {
   
    var mainid = '';
 

    pageload("dashboard/edashboard.php");

    $("#dashboard").click(function () {
        showDiv();
        pageload("dashboard/edashboard.php");
    });
    $("#normalorders").click(function () {
        showDiv();
        pageload("master/order.php");

    });
    $("#mediaorders").click(function () {
        showDiv();
        pageload("master/mediaorders.php");
    });
    $("#enabledproduct").click(function () {
        showDiv();
        pageload("master/product.php");
    });
    $("#disableproduct").click(function () {
        showDiv();
        pageload("master/disabledproduct.php");
    });
    $("#users").click(function () {
        showDiv();
        pageload("master/user.php");
    });
    $("#notification").click(function () {
        showDiv();
        pageload("master/notification.php");
    });
    $("#offers").click(function () {
        showDiv();
        pageload("master/offers.php");
    });
    $("#categories").click(function () {
        showDiv();
        pageload("master/categories.php");
    });
    $("#mediacategories").click(function () {
        showDiv();
        pageload("master/mediacategories.php");
    });
    $("#restaurant").click(function () {
        showDiv();
        pageload("master/restaurant.php");
    });
    $(".restaurantinfo").click(function () {
        showDiv();
        pageload("master/restaurantinfo.php");
    });
    $("#restaurantcategory").click(function () {
        showDiv();
        pageload("master/restaurant_categories.php");
    });
    $("#itemcategory").click(function () {
        showDiv();
        pageload("master/Item_categories.php");
    });


});

function pageload(page) {
    loader();
    $('#content').load(page);
}


function updatestatus(id, status, name) {
    var id = id;
    var status = status;
    if (status == 1) {
        status = 0;
    } else {
        status = 1;
    }

    var data = {
        id: id,
        status: status
    }

    $.ajax({
        url: BaseURL + "/productedit.php",
        method: "POST",
        data: {
            data: data,
            action: "status"
        },
        dataType: "json",
        success: function (response) {
            $('input[name=onoffswitch]').val(response);

            if (response == 1) {
                $('#onoffswitch_' + id).prop("checked", true);
            } else {
                $('#onoffswitch_' + id).prop("checked", false);
            }
            if (name == 'onoffswitchdisabled') {
                pageload("master/disabledproduct.php");
            } else {
                pageload("master/product.php");
            }

        }
    });

}

function GetMediaOrders(id, edittype) {
    $('#mediaid').val(id);
    $.ajax({
        url: BaseURL + "/productedit.php",
        method: "POST",
        data: { id: id, action: edittype },
        dataType: "json",
        success: function (response) {
            $('#mediaorderformModalCenter').modal('show');
            $("#mobile").val(response[0].phone);
            $("#mobile").attr("disabled", "disabled");
            $("#deliveryby").val(response[0].deliveryby)
            $("#description").val(response[0].description);
            $("#description").attr("disabled", "disabled");
            $("#ordereddate").val(response[0].date_ordered);
            $("#ordereddate").attr("disabled", "disabled");
            $("#total").val(response[0].amount);
            $("#status    option").filter(function () {
                return this.text == response[0].status.trim();
            }).attr('selected', true);
            $("#imageurl").val(response[0].image);
            $("#imageurl").attr("disabled", "disabled");
        }
    });
}

function GetUserDetails(id, edittype) {
    $('#product_id').val(id);
    $.ajax({
        url: BaseURL + "/productedit.php",
        method: "POST",
        data: { id: id, action: "edit" },
        dataType: "json",
        success: function (response) {
            $('#exampleModalCenter').modal('show');
            $('#savechanges').attr('name', edittype);

            var weightselect = response[0].weight.split('-')[1].trim();
            var weighttext = response[0].weight.split('-')[0].trim();

            $("#weightselect    option").filter(function () {
                return this.text == weightselect;
            }).attr('selected', true);
            $("#weighttext").val(weighttext);

            $("#category    option").filter(function () {
                return this.text == response[0].category.trim();
            }).attr('selected', true);


            $("#productname").val(response[0].name);
            $("#productimage").val(response[0].image)
            $("#originalprice").val(response[0].original);
            $("#discountprice").val(response[0].discount);
            $("#sellingprice").val(response[0].selling);
        }
    });
}

function createproduct(edittype) {
    var srcData;
    var originalprice = parseInt($("#originalprice").val());
    var sellingprice = parseInt($("#sellingprice").val());
    // if ($('#savechanges').attr('name') == "add") {
    //     var filesSelected = document.getElementById("productimage").files;
    //     var fileToLoad = filesSelected[0];
    //     var fileReader = new FileReader();
    //     fileReader.addEventListener("load", function () {
    //         srcData = fileReader.result;
    //     }, false);
    //     fileReader.readAsDataURL(fileToLoad);
    // }

    // setTimeout(function () {
    if (originalprice > sellingprice) {


        var discount = (originalprice - sellingprice) / originalprice * 100;

        var data = {
            productname: $("#productname").val(),
            weight: $("#weighttext").val() + "-" + $("#weightselect :selected").text(),
            originalprice: $("#originalprice").val(),
            discountprice: discount.toFixed(2),
            sellingprice: $("#sellingprice").val(),
            category: $("#category :selected").text().trim(),
            id: $("#product_id").val(),
            imageurl: $("#productimage").val()

        };
        if ($('#savechanges').attr('name') == edittype) {
            action = "update"
        } else {
            action = "add";
            // data.base64 = srcData;
        }

        $.ajax({
            url: BaseURL + "/productedit.php",
            method: "POST",
            data: { data: data, action: action },
            dataType: "json",
            success: function (response) {
                $('#exampleModalCenter').modal('hide');
                $.simplyToast(response, 'success');
                $("#product_id").val("")

                if (edittype == 'enablededit') {
                    showDiv();
                    pageload("master/product.php");
                } else {
                    showDiv();
                    pageload("master/disabledproduct.php");
                }

            }
        });
        // }, 1000);
    } else {
        $.simplyToast("selling price must lessthan original price", 'danger');
    }

}

function submitoffer() {
    $.ajax({
        url: BaseURL + "/submitoffer.php",
        method: "POST",
        data: { data: $("#offersurl").val(), action: "submitoffer" },
        dataType: "json",
        success: function (response) {
            $('#offerModel').modal('hide');
            $.simplyToast(response, 'success');
            pageload("master/offers.php");
        }
    });

}

function submitpincode(id, type) {
    $.ajax({
        url: BaseURL + "/actions.php",
        method: "POST",
        data: { id: id, pincode: $("#pincode").val(), action: 'pincodeaction', type: type },
        dataType: "json",
        success: function (response) {
            $('#pincodemodel').modal('hide');
            $.simplyToast(response, 'success');
            pageload("dashboard/edashboard.php");
        }
    });

}

function getcategory(id, type) {
    $.ajax({
        url: BaseURL + "/actions.php",
        method: "POST",
        data: { id: id, action: "getcategory", type: type },
        dataType: "json",
        success: function (response) {
            if (type == 'normal') {
                $('#categoriesmodel').modal('show');
                $('#categorie').val(response[0].category);
                $('#categoryid').val(id)
            } else {
                $('#mediacategoriesmodel').modal('show');
                $('#categorie').val(response[0].category);
                $('#mediacategoryid').val(id)
            }
            $('#image').val(response[0].image);

        }
    });

}

function getRestaurantinfo(id) {
    $.cookie("restaurantid", id);
    pageload("master/restaurantinfo.php");
}

function deletecategory(id, type) {
    $.ajax({
        url: BaseURL + "/actions.php",
        method: "POST",
        data: { id: id, action: "deletecategory", type: type },
        dataType: "json",
        success: function (response) {

            switch (type) {
                case "normal":
                case "media":

                    pageload("master/categories.php");
                    $.simplyToast(response, 'success');
                    break;
                case "restaurant":
                case "item":
                    pageload("master/restaurant_categories.php");
                    $.simplyToast(response, 'success');
                    break;

            }

        }
    });

}

function categoryaction(type, id) {
    var action;
    var data = {
        id: id,
        categorie: $("#categorie").val(),
        image: $("#image").val(),
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
        data: { data: data, action: action },
        dataType: "json",
        success: function (response) {
            if (type == 'normal') {
                $('#categoriesmodel').modal('hide');
                pageload("master/categories.php");
            } else {
                $('#mediacategoriesmodel').modal('hide');
                pageload("master/mediacategories.php");
            }
            $.simplyToast(response, 'success');


        }
    });

}

function UpdateMediaOrder() {
    var data = {
        mobile: $("#mobile").val(),
        deliveryby: $("#deliveryby").val(),
        description: $("#description").val(),
        orderdate: $("#ordereddate").val(),
        total: $("#total").val(),
        status: $("#status :selected").text().trim(),
        id: $("#mediaid").val(),
        imageurl: $("#imageurl").val()

    };
    $.ajax({
        url: BaseURL + "/productedit.php",
        method: "POST",
        data: { data: data, action: "updatemediaorder" },
        dataType: "json",
        success: function (response) {
            $('#mediaorderformModalCenter').modal('hide');
            $.simplyToast(response, 'success');
            $("#product_id").val("")
            pageload("master/mediaorders.php");
        }
    });

}

function savenotification() {
    $.ajax({
        url: BaseURL + "/submitoffer.php",
        method: "POST",
        data: { data: $("#notificationtext").val(), action: "savenotification" },
        dataType: "json",
        success: function (response) {
            $('#notificationModel').modal('hide');
            $.simplyToast(response, 'success');
            pageload("master/notification.php");

        }
    });

}

function deletetext(id, action) {
    $.ajax({
        url: BaseURL + "/actions.php",
        method: "POST",
        data: { data: id, action: action },
        dataType: "json",
        success: function (response) {
            $.simplyToast(response, 'success');
            if (action == "delete_offers") {
                pageload("master/offers.php");
            } else {
                pageload("master/notification.php");
            }
        }
    });

}


function clearfields() {
    $('#productform').find('input:text').val('');
    $("#category").val('');
}


function loader() {
    setTimeout(showPage, 3500);
}

function showPage() {
    document.getElementById("content").style.display = "block";
    document.getElementById("loader").style.display = "none";
}

function showDiv() {
    document.getElementById("content").style.display = "none";
    document.getElementById("loader").style.display = "block";
}

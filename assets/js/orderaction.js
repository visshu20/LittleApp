var BaseURL = "http://localhost/Little_App_New";
// var BaseURL="http://shikastudio.com/LittleApp/";
function updateorderStatus(id, ths, type) {

    // var splitid = id.split("_");
    var status = ths.selectedOptions[0].text;
    // var id = splitid[1];
    var prevStatus = document.getElementById('prev_order_status_' + id).value;
    if (!(prevStatus != 'Ordered' && status == 'Ordered')) {

        var data = {
            order_status: status,
            order_id: id,
            type: type
        }

        $.ajax({
            url: BaseURL + "/api/orderactions.php",
            method: "POST",
            data: {
                data: data,
                action: "orderstatus"
            },
            dataType: "json",
            success: function (response) {

                if (type == 'normal') {
                    pageload("master/order.php");
                } else {
                    pageload("master/mediaorders.php");
                }

                $.simplyToast("Status Updated as " + status, 'success');

            }
        });
    } else {

        $.simplyToast("Can't move your status to orderd as it is already inprogress", 'warning');
        $("#status_" + id).val(prevStatus);

    }
}

function cancelorder(id) {

    var splitid = id.split("_");
    var id = splitid[1];

    $.ajax({
        url: BaseURL + "/api/orderactions.php",
        method: "POST",
        data: {
            id: id,
            action: "ordercancel"
        },
        dataType: "json",
        success: function (response) {
            $.simplyToast(response, 'success');
            pageload("master/order.php");
        }
    });

}

function showalladdress(userid) {
    $("#divuseraddresseven").empty();
    $("#divuseraddressodd").empty();
    $.ajax({
        url: BaseURL + "/api/orderactions.php",
        method: "POST",
        data: {
            id: userid,
            action: "showalladdress"
        },
        dataType: "json",
        success: function (response) {
            $('#useraddress').modal('show');
            if (response == '') {
                $("#divuseraddresseven").append("No Data Found");
            } else {
                $.each(response, function (index, value) {
                    if (index % 2 == 0) {
                        $("#divuseraddresseven").append("<div class='panel panel-default' style='width: 18rem;padding-bottom: 25px;'><div class='panel-body' style='border-style: solid;border-color: #dee2e6;'><address class='card-text' style='color:black;font-style:Arial,sans-serif;text-align: center;'>Name: " + response[index].name + "<br> Mobile: " + response[index].mobile + "<br> City: " + response[index].city + "<br> State: " + response[index].state + "<br> Country: " + response[index].country + "<br> Pincode: " + response[index].pincode + "<br> Landmark: " + response[index].landmark + "<br> Line1: " + response[index].line1 + "</address></div></div>");
                    } else {
                        $("#divuseraddressodd").append("<div class='panel panel-default' style='width: 18rem;padding-bottom: 25px;'><div class='panel-body' style='border-style: solid;border-color: #dee2e6;'><address class='card-text' style='color:black;font-style:Arial,sans-serif;text-align: center;'>Name: " + response[index].name + "<br> Mobile: " + response[index].mobile + "<br> City: " + response[index].city + "<br> State: " + response[index].state + "<br> Country: " + response[index].country + "<br> Pincode: " + response[index].pincode + "<br> Landmark: " + response[index].landmark + "<br> Line1: " + response[index].line1 + "</address></div></div>");
                    }

                });
            }
        }
    });

}

function vieworderedproducts(id) {
 
    $.ajax({
        url: BaseURL + "/api/orderactions.php",
        method: "POST",
        data: {
            id: id,
            action: "vieworderedproducts"
        },
        dataType: "json",
        success: function (response) {
            $('#tblorderedproducts tbody').empty();
            $('#tblorderedproducts tfoot').empty();
            $('#orderedproducts').modal('show');
            if (response == '') {
                $("#tblorderedproducts").append("<tr><td colspan='4'>No Data Found</td></tr>");
            } else {

                $.each(response, function (index, value) {

                    // $('table tfoot td').text('Total: ' + response[index].total);


                    $("#tblorderedproducts").append("<tr><td>" + response[index].name + "</td><td>" + response[index].quantity + "</td></td><td>" + response[index].original + "</td><td class='price'>" + response[index].selling + "</td></tr>");



                });

                var sum = 0;

                $(".price").each(function () {
                    sum += parseFloat($(this).text());
                });
                $("#tblorderedproducts tfoot").append("<td colspan='4'> <div style='float: left; text-align: left'>Total Price: </div> <div style='float: right; margin-right: 109px'>" + sum.toFixed(2) + "</div></td>");
            }
        }
    });

}



function search(searchtext, tablename, feildindex) {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById(searchtext);
    filter = input.value.toLowerCase().trim();
    table = document.getElementById(tablename);
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[feildindex];

        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
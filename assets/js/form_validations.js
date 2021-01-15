$(document).ready(function(){
    $("#productform").validate({
        rules: {
            productname: "required"
        },
        messages: {
            productname: "Please enter your productname"
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});

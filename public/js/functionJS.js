function form_ajax(url, frm_id, methodType, callback) {
    var frm_id = "#" + frm_id;
    var formData = new FormData($(frm_id)[0]);

    $.ajax({
        url: url,
        type: methodType,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf-token"]').attr("content");
        },
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: callback,
        error: function (jqXHR, textStatus, errorThrow) {
            console.log(jqXHR.responseText);
        },
    });
}

function form_ajax_customdata(url, formData, callback) {
    $.ajax({
        url: url,
        type: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf-token"]').attr("content");
        },
        data: formData,
        dataType: "JSON",
        success: callback,
        error: function (jqXHR, textStatus, errorThrow) {
            console.log(jqXHR.responseText);
        },
    });
}


var msg = null;

function alert_success(msg) {
    swal.fire({
        title: msg,
        icon: "success",
        timer: 2000,
        showConfirmButton: false,
    });
}
var msg = null;
var msg_txt = null;

function alert_error(msg, msg_txt) {
    swal.fire({
        title: msg,
        text: msg_txt,
        icon: "error",
    });
}
var msg = null;
var ele = null;
var msg_txt = null;

function alert_warning(msg, ele, msg_txt) {
    swal.fire({
        title: msg,
        text: msg_txt,
        icon: "warning",
    }).then(function (isConfirm) {
        if (isConfirm == true) {
            $("#" + ele).focus();
        }
    });
}

function validateField(checkiSerror, fieldId, msg_err) {

    var $field = $(fieldId);
    if ($field.val() == "") {
        $field.addClass('error');
        $field.next('.text-danger').remove();
        var txt_err = `<span class="text-danger">${msg_err}</span>`;
        $field.after(txt_err);
        
        checkiSerror = true;
    } else {
        $field.removeClass('error');
        $field.next('.text-danger').remove();
    }
    return checkiSerror;
}


$().ready(function () {
   
});

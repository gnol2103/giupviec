function form_validate() {
    document.getElementById('error_email').innerHTML = "";
    var emailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    flag = 1
    if ($('#email').val() == '') {
        document.getElementById('error_email').innerHTML = "Email không được để trống!";
        flag = 0;
    } else {
        if (!document.getElementById('email').value.match(emailformat)) {
            document.getElementById('error_email').innerHTML = "Email không đúng định dạng!";
            flag = 0;
        }
    }
    return flag;
}

function validate() {
    if (form_validate() == 1) {
        return true;
    } else {
        return false;
    }
}

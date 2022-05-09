function form_validate() {
    flag = 1
    document.getElementById('error_password').innerHTML = "";
    document.getElementById('error_repassword').innerHTML = "";
    if ($('#password').val() == '') {
        document.getElementById('error_password').innerHTML = "Mật khẩu không được để trống!";
        flag = 0;
    } else {
        if (document.getElementById('password').value.length < 8) {
            document.getElementById('error_password').innerHTML = "Mật khẩu không được ngắn hơn 8 ký tự!";
            flag = 0;
        }
    }
    if ($('#repassword').val() == '') {
        document.getElementById('error_repassword').innerHTML = "Mật khẩu không được để trống!";
        flag = 0;
    } else {
        if (document.getElementById('repassword').value != document.getElementById('password').value) {
            document.getElementById('error_repassword').innerHTML = "Mật khẩu nhập lại không khớp!";
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

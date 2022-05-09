$(document).ready(function() {
    $('#province').select2({
        placeholder: "Chọn Tỉnh/Thành phố",
        minimumResultsForSearch: -1
    });
    $('#district').select2({
        placeholder: "Chọn Quận/Huyện",
        minimumResultsForSearch: Infinity
    });
});


function form_register_validate() {
    document.getElementById('error_name').innerHTML = "";
    document.getElementById('error_phone').innerHTML = "";
    document.getElementById('error_email').innerHTML = "";
    document.getElementById('error_password').innerHTML = "";
    document.getElementById('error_repassword').innerHTML = "";
    document.getElementById('error_birth').innerHTML = "";
    document.getElementById('error_province').innerHTML = "";
    document.getElementById('error_district').innerHTML = "";
    document.getElementById('error_address').innerHTML = "";
    flag = 1;
    var phoneformat = /^\d+/;
    var emailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if ($('#name').val() == '') {
        document.getElementById('error_name').innerHTML = "Họ tên không được để trống!";
        flag = 0;
    }
    if ($('#phone').val() == '') {
        document.getElementById('error_phone').innerHTML = "Số điện thoại không được để trống!";
        flag = 0;
    } else {
        if (!document.getElementById('phone').value.match(phoneformat)) {
            document.getElementById('error_phone').innerHTML = "Số điện thoại không đúng định dạng!";
            flag = 0;
        }
    }
    if ($('#email').val() == '') {
        document.getElementById('error_email').innerHTML = "Email không được để trống!";
        flag = 0;
    } else {
        if (!document.getElementById('email').value.match(emailformat)) {
            document.getElementById('error_email').innerHTML = "Email không đúng định dạng!";
            flag = 0;
        }
    }
    if ($('#password').val() == '') {
        document.getElementById('error_password').innerHTML = "Mật khẩu không được để trống!";
        flag = 0;
    }
    if ($('#repassword').val() == '') {
        document.getElementById('error_repassword').innerHTML = "Nhập lại mật khẩu không được để trống!";
        flag = 0;
    } else {
        if (document.getElementById('password').value != document.getElementById('repassword').value) {
            document.getElementById('error_repassword').innerHTML = "Nhập lại mật khẩu không khớp!";
            flag = 0;
        }
    }
    if ($('#birth').val() == '') {
        document.getElementById('error_birth').innerHTML = "Ngày sinh không được để trống!";
        flag = 0;
    }
    if ($('#province').val() == '') {
        document.getElementById('error_province').innerHTML = "TỈnh/Thành phố không được để trống!";
        flag = 0;
    }
    if ($('#district').val() == '') {
        document.getElementById('error_district').innerHTML = "Quận/Huyện không được để trống!";
        flag = 0;
    }
    if ($('#address').val() == '') {
        document.getElementById('error_address').innerHTML = "Địa chỉ cụ thể không được để trống!";
        flag = 0;
    }
    return flag;
}


function validate() {
    if (form_register_validate() == 1) {
        return true;
    } else {
        return false;
    }
}

const ipnFileElement = document.querySelector('#avata');
const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];

ipnFileElement.addEventListener('change', function(e) {
    const files = e.target.files
    const file = files[0]
    const fileType = file['type']

    if (!validImageTypes.includes(fileType)) {
        alert('Ảnh không đúng định dạng')
        return
    }

    const fileReader = new FileReader()
    fileReader.readAsDataURL(file)

    fileReader.onload = function() {
        const url = fileReader.result;
        document.getElementById('show_avata').innerHTML = `<img src="${url}" alt="${file.name}" class="preview-img" />`;
    }
})

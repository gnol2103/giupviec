$(document).ready(function() {
    $('#province').select2({
        placeholder: "Chọn Tỉnh/Thành phố",
        minimumResultsForSearch: -1
    });
    $('#district').select2({
        placeholder: "Chọn Quận/Huyện",
        minimumResultsForSearch: Infinity
    });
    $('#job_style').select2({
        placeholder: "Có thể chọn cùng lúc nhiều loại công việc",
        minimumResultsForSearch: Infinity
    });
    $('#experience').select2({
        placeholder: "Lựa chọn kinh nghiệm",
        minimumResultsForSearch: Infinity
    });
    $('#education').select2({
        placeholder: "Lựa chọn trình độ học vấn",
        minimumResultsForSearch: Infinity
    });
    $('#sal_time').select2({
        minimumResultsForSearch: Infinity
    });
    $('#t7 .col_time').remove();
    $('#t7').append('<div class="schedule_msg" id="schedule_msg_t7">Tôi không làm việc</div>');
    $('#cn .col_time').remove();
    $('#cn').append('<div class="schedule_msg" id="schedule_msg_cn">Tôi không làm việc</div>');
    $('#add_t2').hide();
    $('#add_t3').hide();
    $('#add_t4').hide();
    $('#add_t5').hide();
    $('#add_t6').hide();
    $('#add_t7').hide();
    $('#add_cn').hide();
});

function hide_schedule_row(id) {
    schedule = '';
    var schedule = $('#' + id + ' .col_time').html();
    if (schedule) {
        $('#' + id + ' .col_time').remove();
        $('#' + id).append('<div class="schedule_msg" id="schedule_msg_' + id + '">Tôi không làm việc</div>');
    } else {
        $('#schedule_msg_' + id).remove();
        $('#' + id).append(`<div class="col_2 col_time" id="${id}_am">
		<span>Từ</span>
		<input type="text" value="07:00" class="start" name='${id}_am_start'>
		<span>Đến</span>
		<input type="text" value="11:00" class="end" name='${id}_am_end'>
		<button type="button" onclick="add_schedule_row('${id}')" id="add_${id}"><img src="/images/add_schedule.svg" alt=""></button>
	</div>
	<div class="col_3 col_time" id="${id}_pm">
		<span>Từ</span>
		<input type="text" value="18:00" class="start" name='${id}_pm_start'>
		<span>Đến</span>
		<input type="text" value="21:00" class="end" name='${id}_pm_end'>
		<button type="button" onclick="minus_schedule_row('${id}')" id="minus_${id}"><img src="/images/clear_schedule.svg" alt=""></button>
	</div>`);
        $('#add_' + id).hide();
    }
}

function add_schedule_row(id) {
    var schedule = $('#' + id + '_pm').html();
    if (!schedule) {
        $('#' + id).append(`
	<div class="col_3 col_time" id="${id}_pm">
		<span>Từ</span>
		<input type="text" value="18:00" class="start" name='${id}_pm_start'>
		<span>Đến</span>
		<input type="text" value="21:00" class="end" name='${id}_pm_end'>
		<button type="button" onclick="minus_schedule_row('${id}')" id="minus_t2"><img src="/images/clear_schedule.svg" alt=""></button>
	</div>`);
        $('#add_' + id).hide();
    }
}

function minus_schedule_row(id) {
    var schedule = $('#' + id + '_pm').html();
    if (schedule) {
        $('#' + id + '_pm').remove();
        $('#add_' + id).show();
    }
}

$('#option-1').click(function() {
    document.getElementById('dynamic').style.display = "none";
    document.getElementById('static').style.display = "block";
})

$('#option-2').click(function() {
    document.getElementById('dynamic').style.display = "block";
    document.getElementById('static').style.display = "none";
})

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
    document.getElementById('error_job_style').innerHTML = "";
    document.getElementById('error_experience').innerHTML = "";
    document.getElementById('error_education').innerHTML = "";
    document.getElementById('error_schedule').innerHTML = "";
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
    if ($('#job_style').val() == '') {
        document.getElementById('error_job_style').innerHTML = "Loại công việc không được để trống!";
        flag = 0;
    }
    if ($('#experience').val() == '') {
        document.getElementById('error_experience').innerHTML = "Kinh nghiệm không được để trống!";
        flag = 0;
    }
    if ($('#education').val() == '') {
        document.getElementById('error_education').innerHTML = "Trình độ học vấn không được để trống!";
        flag = 0;
    }
    schedule_checked = document.getElementsByClassName('checkbox_schedule');
    flag_schedule = 0;
    for (var i = 0; i < schedule_checked.length; i++) {
        if (schedule_checked[i].checked === true) {
            flag_schedule = 1;
        }
    }
    if (flag_schedule == 0) {
        document.getElementById('error_schedule').innerHTML = "Lịch làm việc không được để trống!";
    }

    if ($('#t2_am').html()) {
        if (validate_schedule_time('t2_am')) {
            flag = 0
        }
    }
    if ($('#t3_am').html()) {
        if (validate_schedule_time('t3_am')) {
            flag = 0
        }
    }
    if ($('#t4_am').html()) {
        if (validate_schedule_time('t4_am')) {
            flag = 0
        }
    }
    if ($('#t5_am').html()) {
        if (validate_schedule_time('t5_am')) {
            flag = 0
        }
    }
    if ($('#t6_am').html()) {
        if (validate_schedule_time('t6_am')) {
            flag = 0
        }
    }
    if ($('#t7_am').html()) {
        if (validate_schedule_time('t7_am')) {
            flag = 0
        }
    }
    if ($('#cn_am').html()) {
        if (validate_schedule_time('cn_am')) {
            flag = 0
        }
    }
    if ($('#t2_pm').html()) {
        if (validate_schedule_time('t2_pm')) {
            flag = 0
        }
    }
    if ($('#t3_pm').html()) {
        if (validate_schedule_time('t3_pm')) {
            flag = 0
        }
    }
    if ($('#t4_pm').html()) {
        if (validate_schedule_time('t4_pm')) {
            flag = 0
        }
    }
    if ($('#t5_pm').html()) {
        if (validate_schedule_time('t5_pm')) {
            flag = 0
        }
    }
    if ($('#t6_pm').html()) {
        if (validate_schedule_time('t6_pm')) {
            flag = 0
        }
    }
    if ($('#t7_pm').html()) {
        if (validate_schedule_time('t7_pm')) {
            flag = 0
        }
    }
    if ($('#cn_pm').html()) {
        if (validate_schedule_time('cn_pm')) {
            flag = 0
        }
    }


    // if (validate_schedule_time('t3')) {
    //     flag = 0
    // }
    // if (validate_schedule_time('t4')) {
    //     flag = 0
    // }
    // if (validate_schedule_time('t5')) {
    //     flag = 0
    // }
    // if (validate_schedule_time('t6')) {
    //     flag = 0
    // }
    // if (validate_schedule_time('t7')) {
    //     flag = 0
    // }
    // if (validate_schedule_time('cn')) {
    //     flag = 0
    // }
    return flag;
}

function validate_schedule_time(day) {
    var timeformat = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/;
    start_m = $('#' + day + ' .start').val();
    end_m = $('#' + day + ' .end').val();
    if (!start_m.match(timeformat) || !end_m.match(timeformat)) {
        document.getElementById('error_schedule').innerHTML = "Sai định dạng thời gian!";
        return false;
    } else if (start_m.length > 5 || end_m.length > 5) {
        document.getElementById('error_schedule').innerHTML = "Sai định dạng thời gian!";
        return false;
    } else {
        timestring_star_m = start_m.split(/:/);
        time_value_start_m = '';
        for (j = 0; j < timestring_star_m.length; j++) {
            time_value_start_m += timestring_star_m[j];
        }

        timestring_end_m = end_m.split(/:/);
        time_value_end_m = '';
        for (j = 0; j < timestring_end_m.length; j++) {
            time_value_end_m += timestring_end_m[j];
        }
        if (Number(time_value_start_m) - Number(time_value_end_m) >= 0) {
            document.getElementById('error_schedule').innerHTML = "Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc!";
            return false;
        }
    }
    return true;
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

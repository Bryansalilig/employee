// Enable Strict Mode for All code for future errors in Pragma

"use strict";

const settings = {
  popup: {
    confirm_delete: { type:'warning', title:'Do you really delete this?', showCancelButton:true, confirmButtonColor:'#ff4f81' },
    warning_required: { type:'warning', title:'Please fill out all required fields.', confirmButtonColor:'#ff4f81' },
    success_request: {type:'success', title:'Your request is successfully done.', confirmButtonColor:'#ff4f81' },
    error_request: { type:'error', title:'Your request is invalid.', confirmButtonColor:'#ff4f81' },
    error_contact: { type:'error', title:'Please contact to admin.', confirmButtonColor:'#ff4f81' },
    error_email: { type:'error', title:'Email address is already registered.', confirmButtonColor:'#ff4f81' },
    error_invalid: { type:'error', title:'Input value is invalid.', confirmButtonColor:'#ff4f81' },
    error_upload_fail: { type:'error', title:'Fail to upload files.', confirmButtonColor:'#ff4f81' },
    error_upload_max: { type:'error', title:'Exceeded the number of uploads.', confirmButtonColor:'#ff4f81' },
    error_level: { type:'error', title:'No permission.', confirmButtonColor:'#ff4f81' }
  }
};
$.messageHandler = {
  getMessage: function(type) {
    return settings.popup[type];
  },
  showMessage: function(type) {
    swal(settings.popup[type]);
  },
  customMessage: function(type, msg) {
    swal({ type:type, title:msg });
  }
};
$.requestHandler = {
  checkRequirement: function(form) {
    var ret = true;
    $(form).find('input[required], select[required], textarea[required]').each(function() {
        console.log($(this));
      if($(this).val().trim() == '') {
        $(this).focus();
        if($(this).hasClass('select2')) {
          $(this).closest('.form-group').find('.select2-container').addClass('border-danger').css({'border':'1px solid'});
        } else {
          $(this).addClass('border-danger');
        }

        $.messageHandler.customMessage('warning', $(this).data('label') + ' field is required.');
        return ret = false;
      }
      $(this).removeClass('border-danger');
      $(this).closest('.form-group').find('.select2-container').removeClass('border-danger').css({'border' : 'none'});
    });
    return ret;
  }
};
$(function() {
  $('.select2').select2();
  $('.mdate').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', maxDate: new Date(), time: false, clearButton: true });
  $('.mdate2').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', time: false, clearButton: true });
  $('.mdatetime').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD HH:mm', clearButton: true });

  $('input.numeric').keyup(function() {
    $(this).val($(this).val().replace(/[^\d]/g ,''));
  });

  $('.btn-submit').click(function(e) {
    e.preventDefault();

    if (!$.requestHandler.checkRequirement($(this).closest('form'))) return false;

    $('body').css({'pointer-events':'none'});
    $(this).attr('disabled', true);
    $(this).val('Please wait');
    $(this).closest('form').submit();

    return false;
  });

  $('.btn-delete').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    swal({
      title: 'Are you sure you want to delete?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55'
    }, function() {
      $.get(obj.data('url'), {'id':obj.data('id')}, function(data) {
        if (data.ret == 1) {
          swal({
            title: data.msg,
            type: 'success'
          }, function() {
            if (obj.data('view') === undefined) {
              location.reload();
            } else {
              location.replace(data.url);
            }
          });
        }
      }, 'json');
    });

    return false;
  });

  $('.btn-action').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var title = (obj.data('title') === undefined) ? 'Are you sure?' : obj.data('title');
    var type = (obj.data('type') === undefined) ? 'warning' : obj.data('type');
    var color = (obj.data('color') === undefined) ? '#258cd1' : obj.data('color');

    swal({
      title: title,
      type: type,
      showCancelButton: true,
      confirmButtonColor: color
    }, function() {
      $.post(obj.data('url'), {id : obj.data('id'), _token: $('meta[name="csrf-token"]').attr('content')}, function(data) {
        if (data.ret == 1) {
          swal({
            title: data.msg,
            type: 'success'
          }, function() {
            if (obj.data('view') === undefined) {
              location.reload();
            } else {
              location.replace(data.url);
            }
          });
        } else {
          swal({
            title: data.msg,
            type: 'error'
          });
        }
      }, 'json');
    });

    return false;
  });
});
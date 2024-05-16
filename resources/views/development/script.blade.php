<script type="text/javascript">
  $(function (){
    var custom = <?= isset($item->count) ? $item->count : 0 ?>;
function calculateResult() {
    rating = 0;
    i = 0;

    $('.rating').each(function(key){
        rating += parseInt($(this).val());
        i++;
    });

    total = parseFloat(rating / i).toFixed(2);
    cls_talent = 'result_growth';
    talent = 'Growth';
    cls_final = 'result_ready';
    final = 'Ready';

    if(total == 5) {
        cls_talent = 'result_high';
        talent = 'High Talent';
    }
    if(total < 3) {
        cls_talent = 'result_core';
        talent = 'Core';
        cls_final = 'result_not';
        final = 'Not Ready';
    }
    if(total < 1) {
        cls_talent = 'result_develop';
        talent = 'To Develop';
        cls_final = 'result_not';
        final = 'Not Ready';
    }

    $('.result_score').text(total);
    $('.result_talent').removeClass('result_high').removeClass('result_growth').removeClass('result_core').addClass(cls_talent).text(talent);
    $('.result_recommendation').removeClass('result_ready').removeClass('result_not').addClass(cls_final).text(final);
    $('input[name="result-score"]').val(total);
    $('input[name="result-talent"]').val(talent);
    $('input[name="result-recommendation"]').val(final);
}

$('body').on('click', '.close', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();

        calculateResult();
    });

    $('body').on('click', '.bg-remark', function(e){
        e.preventDefault();

        var obj = $(this),
            row = obj.closest('tr'),
            score = obj.data('score'),
            value = row.find('textarea.remark').val(),
            text = obj.text();

        row.find('.bg-remark').each(function(e) {
            if($(this).data('score') != score) {
                $(this).text('');
            }
        });

        if(!obj.hasClass('bg-active')) {
            obj.text('');
            obj.append('<textarea class="form-control form-active" rows="5"></textarea>');
            obj.find('textarea').focus();

            if(value == '') {
                obj.find('textarea').val(text);
            } else {
                obj.find('textarea').val(value);
            }
        }
        obj.addClass('bg-active');
    });

    $('body').on('blur', '.form-active', function(e) {
        e.preventDefault();

        var obj = $(this),
            text = obj.val(),
            row = obj.closest('tr'),
            td = obj.closest('td'),
            score = td.data('score'),
            rating = row.find('.rating');

        td.removeClass('bg-active');
        td.text(text);
        row.find('textarea.remark').val(text);
        if(text == '') {
            rating.val('0');
        } else {
            rating.val(score);
        }
        obj.remove();

        calculateResult();
    });

    $('body').on('click', '.bg-recommend', function(e) {
        e.preventDefault();

        var obj = $(this),
            text = obj.text();

        obj.removeClass('bg-required');
        if(!obj.hasClass('bg-active')) {
            obj.text('');
            obj.append('<textarea class="form-control form-recommend" rows="5"></textarea>');
            obj.find('textarea').focus();
            obj.find('textarea').val(text);
        }
        obj.addClass('bg-active');
    });

    $('body').on('blur', '.form-recommend', function(e) {
        e.preventDefault();

        var obj = $(this),
            text = obj.val(),
            row = obj.closest('tr'),
            td = obj.closest('td');

        td.removeClass('bg-active');
        td.text(text);
        row.find('textarea.recommendation').val(text);
        obj.remove();
    });

    $(".accordion-toggle").click(function (e) {
          e.preventDefault();
  
          $(this).toggleClass("active");
          if($(this).hasClass('active')) {
              $('.accordion-content').show(200);
              $(this).find("em").toggleClass("fa-toggle-down fa-toggle-up");
          } else {
              $('.accordion-content').hide(200);
              $(this).find("em").toggleClass("fa-toggle-up fa-toggle-down");
          }
      });

      $('.btn-add').click(function(e) {
        e.preventDefault();

        var role = $('input[name="role-name"]');
        var description = $('input[name="role-description"]');
        var entry = $('#row-entry');

        if(role.val() == ''){
            role.focus();
            role.css({'border':'1px solid #ff0000'});

            result = false;

            return false;
        }

        if(description.val() == ''){
            description.focus();
            description.css({'border':'1px solid #ff0000'});

            result = false;

            return false;
        }

        var html = '<tr>'+
                '<td class="bg bg-technical" style="height:100px">'+
                    '<input type="hidden" name="others-role['+custom+']" value="'+role.val()+'">'+
                    '<input type="hidden" name="others-description['+custom+']" value="'+description.val()+'">'+
                    '<input type="hidden" class="rating" name="others-score['+custom+']" value="0">'+
                    '<textarea class="remark" name="others-remark['+custom+']" style="display: none;"></textarea>'+
                    '<textarea class="recommendation" name="others-recommendation['+custom+']" style="display: none;"></textarea>'+
                    '<span class="fa fa-remove close btn btn-danger"></span>'+
                    role.val()+
                '</td>'+
                '<td>'+description.val()+'</td>'+
                '<td data-score="1" class="bg-remark"></td>'+
                '<td data-score="3" class="bg-remark"></td>'+
                '<td data-score="5" class="bg-remark"></td>'+
                '<td class="bg-recommend"></td>'+
            '</tr>';

        entry.before(html);
        role.val('');
        description.val('');

        custom++;

        calculateResult();
    });
    $('a.toggle-modal').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            form = obj.closest('form'),
            modal = $('#'+obj.data('target')),
            action = obj.data('action');

        if(obj.data('target') == 'save-form') {
            modal.find('.modal-body').css({'display':'none'});
        }
        modal.modal('show');
        form.attr('action', action);
    });
  });
</script>
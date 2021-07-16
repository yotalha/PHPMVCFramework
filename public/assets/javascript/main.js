$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

//$(document).ready(function() {
//     $('#new-course-form').submit(function (e) {
//         e.preventDefault();
//         var data = $('#new-course-form');
//         console.log(data);
//         $.ajax({
//             url:'/validate-course',
//             method: 'POST',
//             // Expect a `mycustomtype` back from server
//             contentType: 'application/json',
//             // dataType: 'json',
//             // data: JSON.stringify($("#new-course-form").serializeObject()),
//             // data: $("#new-course-form").serialize(),
//             data: { name: "John", location: "Boston" }
//         }).done(function(data) {
//             alert(res);
//         }).fail(function (jqXHR, textStatus, errorThrown){
//             alert(jqXHR.responseJSON.message);
//         })
//         return false;
//     });
//});
$(document).ready(function (){
    $('.ajax-form').submit(function (e){
        e.preventDefault();
        var self = this;
        $.post($(this).attr('action'), $(self).serialize(), function (data) {
            $('.invalid-feedback').empty()
            $('.invalid-feedback').css('display', 'none')
            window.location.href = JSON.parse(data);
        }).fail(function(data) {
            var parsedData = JSON.parse(data.responseText)
            $('.invalid-feedback').empty()
            $('.invalid-feedback').css('display', 'none')

            Object.keys(parsedData).forEach(function (key) {
                var field = $(self).children('input[name="' + key + '"]');
                field.siblings('.invalid-feedback').text(parsedData[key][0]).css('display', 'block')
            })
        })
    })
});

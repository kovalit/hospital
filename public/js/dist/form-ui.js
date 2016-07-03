
$(function () {
    
        var fields = {
            specialize  : '#BookingForm_specializeId',
            hospitals   : '#BookingForm_hospitalId',
            doctors     : '#BookingForm_doctorId',
            date        : '#BookingForm_date',
            time        : '#BookingForm_time' 
        };
    
        var dataList = {};

        function  fillTime () {

                var timeList = $(fields.time);
                var date = $(this).data("date");

                $(fields.date).val(date);
                timeList.empty();
                timeList.append($("<option></option>").val('').html('Выберете время...'));
                $.each(dataList[date], function (key, value) {
                        if (key !== '') timeList.append($("<option></option>").val(key).html(value));
                });

                timeList.parents('.form-row').fadeIn();
        } 


    
        $(fields.specialize).on('change', function() {
                var specializeId = $(this).val();
                if (specializeId === '') {
                    return;
                }
                $.ajax({
                    type: "GET",
                    url: "/getHospitals/" + specializeId,
                    cache: false,
                    dataType: 'JSON',

                    success: function(result){
                          changeVisibility(result, 'specialize');
                    }
                });
        });
    
    function changeVisibility(data, source) {
        var hospitalsList = $(fields.hospitals);
        var doctorsList = $(fields.doctors);
        var timeList = $(fields.time);
        var date = $(fields.date);
       
        
        switch (source) {
            
            case 'specialize':
                
     
                hospitalsList.empty();
                hospitalsList.append($("<option></option>").val('').html(data['']));
                $.each(data, function (key, value) {
                        if (key !== '') hospitalsList.append($("<option></option>").val(key).html(value));
                });     
                
                hospitalsList.parents('.form-row').fadeIn();
                doctorsList.parents('.form-row').fadeOut();
                date.val('');
                timeList.parents('.form-row').fadeOut();
                
                break;
                
            case 'hospitals':
                

                doctorsList.empty();
                doctorsList.append($("<option></option>").val('').html(data['']));
                $.each(data, function (key, value) {
                        if (key !== '') doctorsList.append($("<option></option>").val(key).html(value));
                });
                
                doctorsList.parents('.form-row').fadeIn();
                date.val('');
                timeList.parents('.form-row').fadeOut();
              
              break;
              
            case 'doctors':
                

                
                var eventData = [];
                date.val('');
                
                dataList = data;

                for (var date in data) {
                    eventData.push({"date": date, "badge": false, "title": ""})
                }

                $("#calendar").empty();
                var calendar = $('<div></div');
                calendar.attr('id', 'my-calendar');
                $("#calendar").append(calendar);
                
                $("#my-calendar").zabuto_calendar({
                    language: "ru",
                    show_previous: false,
                    data: eventData,
                    show_next: 2,
                });
                
                $("td.event").on('click', fillTime);
                
                
                
                
                timeList.parents('.form-row').fadeOut();
                break;
        }
    }
    
    
     $(fields.hospitals).on('change', function() {
            var specializeId = $(fields.specialize).val();
            var hospitalId = $(this).val();
            if (hospitalId === '') {
                return;
            }
            $.ajax({
                type: "GET",
                url: "/getDoctors/" + hospitalId + '/' + specializeId,
                cache: false,
                dataType: 'JSON',

                success: function(result){
                      changeVisibility(result, 'hospitals');

                }
            });
    });
    
    
    $(fields.doctors).on('change', function() {
            var hospitalId = $(fields.hospitals).val();
            var doctorId = $(this).val();
             if (doctorId === '') {
                return;
            }
            
            $.ajax({
                type: "GET",
                url: "/getSchedule/" + hospitalId + '/' + doctorId,
                cache: false,
                dataType: 'JSON',

                success: function(result){
                    changeVisibility(result, 'doctors') 




                }
            });
    });
    
 

    $(".stepsForm").stepsForm({
            width: '100%',
            active: 0,
            errormsg: 'Check faulty fields.',
            sendbtntext: 'Отправить',
            posturl: 'core/demo_steps_form.php',
            theme: 'green',
    });

    $(".container .themes>span").click(function (e) {
            $(".container .themes>span").removeClass("selectedx");
            $(this).addClass("selectedx");
            $(".stepsForm").removeClass().addClass("stepsForm");
            $(".stepsForm").addClass("sf-theme-" + $(this).attr("data-value"));
    });

});




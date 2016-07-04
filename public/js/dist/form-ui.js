
$(function () {
    
        var fields = {
                specialize  : '#Booking_specializeId',
                hospitals   : '#Booking_hospitalId',
                doctors     : '#Booking_doctorId',
                date        : '#Booking_date',
                time        : '#Booking_time'   
        };
    
    
        var intervalsList = {};


        var selectDate = function() {

                var timeList = $(fields.time);
                var date = $(this).data("date");
                
                // select date
                $('.event').removeClass('event_select');
                $(this).addClass('event_select');
                
                // save date
                $(fields.date).val(date);
                
                // fill time list
                timeList.empty();
                timeList.append($("<option></option>").val('').html('Выберете время...'));
                $.each(intervalsList[date], function (key, value) {
                        if (key !== '') timeList.append($("<option></option>").val(value).html(value));
                });

                timeList.parents('.form-row').fadeIn();
        }; 

        
    
        var changeFileds = function(data, source) {
        
                var hospitalsList   = $(fields.hospitals);
                var doctorsList     = $(fields.doctors);
                var timeList        = $(fields.time);
                var date            = $(fields.date);

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

                        intervalsList = data;
                        
                        // fill aviable date
                        for (var date in data) {
                                eventData.push({"date": date, "badge": false, "title": ""});
                        }

                        // add calendar 
                        $("#wrapper-calendar").empty();
                        var calendar = $('<div></div');
                        calendar.attr('id', 'calendar');
                        $("#wrapper-calendar").append(calendar);

                        // init calendat
                        calendar.zabuto_calendar({
                                language: "ru",
                                show_previous: false,
                                data: eventData,
                                show_next: 2,
                                legend: [
                                        {type: "block", label: "Доступно для записи"}
                                ]
                        });

                        $("td.event").on('click', selectDate);

                        timeList.parents('.form-row').fadeOut();
                        
                        break;
                };
        };
    
    
        // change specialize
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
                            changeFileds(result, 'specialize');
                    }
                });
        });
    
    
        // change hospitals
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
                              changeFileds(result, 'hospitals');
                        }
                });
        });
        
    
        // change doctors
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
                                changeFileds(result, 'doctors');
                        }
                });
        });
    
    
        $(".stepsForm").stepsForm({
                width: '100%',
                active: 0,
                errormsg: 'Заполните все поля',
                sendbtntext: 'Отправить',
                posturl: '/',
                theme: 'green',
        });


        $(".container .themes>span").click(function (e) {
                $(".container .themes>span").removeClass("selectedx");
                $(this).addClass("selectedx");
                $(".stepsForm").removeClass().addClass("stepsForm");
                $(".stepsForm").addClass("sf-theme-" + $(this).attr("data-value"));
        });

});




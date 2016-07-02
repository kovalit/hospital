
$(function () {
    
   

 
    

    

    
    $("#BookingForm_specializeId").on('change', function() {
 
        
        
        
            var specializeId = $(this).val();
            var hospitals = $("#BookingForm_hospitalId");
            var doctors = $("#BookingForm_doctorId");
                $.ajax({
                    type: "GET",
                    url: "/getHospitals/" + specializeId,
                    cache: false,
                    dataType: 'JSON',

                    success: function(result){
                          hospitals.empty();
                          doctors.parents('.form-row').fadeOut();
                          hospitals.append($("<option></option>").val('').html(result['']));
                            $.each(result, function (key, value) {
                                    if (key !== '') hospitals.append($("<option></option>").val(key).html(value));
                            });
                            hospitals.parents('.form-row').fadeIn();
                    }
                });
    });
    
     $("#BookingForm_hospitalId").on('change', function() {

            var specializeId = $('#BookingForm_specializeId').val();
            var hospitalId = $(this).val();
            var doctors = $("#BookingForm_doctorId");
                $.ajax({
                    type: "GET",
                    url: "/getDoctors/" + hospitalId + '/' + specializeId,
                    cache: false,
                    dataType: 'JSON',

                    success: function(result){
                          doctors.empty();
                          doctors.append($("<option></option>").val('').html(result['']));
                            $.each(result, function (key, value) {
                                    if (key !== '') doctors.append($("<option></option>").val(key).html(value));
                            });
                            doctors.parents('.form-row').fadeIn();

                    }
                });
    });
    
    
    $("#BookingForm_doctorId").on('change', function() {
        
        
         

            var hospitalId = $('#BookingForm_hospitalId').val();
            var doctorId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "/getSchedule/" + hospitalId + '/' + doctorId,
                    cache: false,
                    dataType: 'JSON',

                    success: function(result){

                           var eventData = [];

                           for (var date in result) {
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
                                   show_next: 2
                           });

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





$(function () {

    var eventData = [
            {"date": "2016-07-04", "badge": false, "title": "Example 1"},
            {"date": "2016-07-18", "badge": false, "title": "Example 2"}
    ];
    
    $("#my-calendar").zabuto_calendar({
            language: "ru",
            show_previous: false,
            data: eventData,
            show_next: 2
    });
    
    $("#BookingForm_specializeId").on('change', function() {
            var specializeId = $(this).val();
            var hospitals = $("#BookingForm_hospitalId");
                $.ajax({
                    type: "GET",
                    url: "/getHospitals/" + specializeId,
                    cache: false,
                    dataType: 'JSON',

                    success: function(result){
                          hospitals.empty();
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




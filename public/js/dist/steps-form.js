(function ($) {
    $.fn.stepsForm = function(t) {
        var e = {
                width: "100%",
                active: 0,
                errormsg: "Check faulty fields.",
                sendbtntext: "Create Account",
                posturl: "core/demo_steps_form.php",
                theme: "default"
            },
            t = $.extend(e, t);
        return this.each(function() {
            function e(e) {
                for (requredcontrol = !1, i = 0; i < e; i++) f.find(".sf-steps-form>ul").eq(i).find(":input").each(function() {
                    "true" == $(this).attr("data-required") && "" == $(this).val() ? ($(this).addClass("sf-error"), requredcontrol = !0) : "true" != $(this).attr("data-required") || "radio" != $(this).attr("type") && "checkbox" != $(this).attr("type") ? "" != $(this).val() && ("true" == $(this).attr("data-email") && 0 == r($(this).val()) && ($(this).addClass("sf-error"), requredcontrol = !0), "true" == $(this).attr("data-number") && isNaN($(this).val()) && ($(this).addClass("sf-error"), requredcontrol = !0), "true" == $(this).attr("data-confirm") && (h.push($(this).val()), u.push($(this)), a())) : "radio" == $(this).attr("type") ? $(this).parent().parent().find("input[type='radio']:checked").length < 1 && ($(this).addClass("sf-error"), requredcontrol = !0) : $(this).parent().parent().find("input[type='checkbox']:checked").length < 1 && ($(this).addClass("sf-error"), requredcontrol = !0)
                });
                d(), h.length = 0, requredcontrol ? f.find("#sf-msg").html(t.errormsg) : (o(), u.length = 0, t.active = e, t.active > c - 1 ? (t.active--, f.find("#sf-msg").text("")) : (n(), requredcontrol = !1, f.find("#sf-msg").text("")))
            }

            function s() {
                f.width() > 500 ? (f.find(".column_1").css({
                    width: "16.666666667%",
                    "margin-bottom": "0px"
                }), f.find(".column_2").css({
                    width: "33.333333334%",
                    "margin-bottom": "0px"
                }), f.find(".column_3").css({
                    width: "50%",
                    "margin-bottom": "0px"
                }), f.find(".column_4").css({
                    width: "66.666666667%",
                    "margin-bottom": "0px"
                }), f.find(".column_5").css({
                    width: "83.333333334%",
                    "margin-bottom": "0px"
                }), f.find(".column_6").css({
                    width: "100%",
                    "margin-bottom": "0px"
                }), f.find(".sf-content>li").css({
                    "margin-bottom": "2rem"
                }), f.find(".sf-steps-content").removeClass("sf-steps-center"), f.find(".sf-steps-navigation").removeClass("sf-align-center").addClass("sf-align-right")) : (f.find(".column_1").css({
                    width: "100%",
                    "margin-bottom": "2rem"
                }), f.find(".column_2").css({
                    width: "100%",
                    "margin-bottom": "2rem"
                }), f.find(".column_3").css({
                    width: "100%",
                    "margin-bottom": "2rem"
                }), f.find(".column_4").css({
                    width: "100%",
                    "margin-bottom": "2rem"
                }), f.find(".column_5").css({
                    width: "100%",
                    "margin-bottom": "2rem"
                }), f.find(".column_6").css({
                    width: "100%",
                    "margin-bottom": "2rem"
                }), f.find(".sf-content>li").css({
                    "margin-bottom": "0px"
                }), f.find(".sf-steps-content").addClass("sf-steps-center"), f.find(".sf-steps-navigation").removeClass("sf-align-right").addClass("sf-align-center"))
            }

            function n() {
                f.find(".sf-steps-content>div").removeClass("sf-active"), f.find(".sf-steps-form>.sf-content").css({
                    display: "none"
                }), f.find(".sf-steps-form>ul").eq(t.active).fadeIn(), f.find(".sf-steps-content>div").eq(t.active).addClass("sf-active"), f.find("#sf-next").text(t.active == c - 1 ? t.sendbtntext : l), f.find("#sf-prev").css(0 == t.active ? {
                    display: "none"
                } : {
                    display: "inline-block"
                })
            }

            function r(t) {
                var e = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return e.test(t)
            }

            function a() {
                var t = h[0];
                for (index = 0; index < h.length; index++) h[index] != t && (requredcontrol = !0), fisrctval = h[index]
            }

            function d() {
                for (index = 0; index < u.length; index++) u[index].addClass("sf-error")
            }

            function o() {
                for (index = 0; index < u.length; index++) u[index].removeClass("sf-error")
            }
            var f = $(this),
                c = f.find(".sf-steps-content").find("div").length,
                l = f.find("#sf-next").text(),
                h = new Array,
                u = new Array;
            f.css({
                width: t.width
            }), f.addClass("sf-theme-" + t.theme), n(), f.find(":input").on("click", function() {
                var t = $(this).parent().parent().find("input").attr("type");
                "radio" == t || "checkbox" == t ? $(this).parent().parent().find("input").removeClass("sf-error") : $(this).removeClass("sf-error")
            }), f.find(".sf-steps-content>div").on("click", function() {
                "sf-active" != $(this).attr("class") && (t.active > $(this).index() ? (t.active = $(this).index(), n()) : e($(this).index()))
            }), f.find("#sf-next").on("click", function() {
                requredcontrol = !1, f.find(".sf-steps-form>ul").eq(t.active).find(":input").each(function() {
                    "true" == $(this).attr("data-required") && "" == $(this).val() ? ($(this).addClass("sf-error"), requredcontrol = !0) : "true" != $(this).attr("data-required") || "radio" != $(this).attr("type") && "checkbox" != $(this).attr("type") ? "" != $(this).val() && ("true" == $(this).attr("data-email") && 0 == r($(this).val()) && ($(this).addClass("sf-error"), requredcontrol = !0), "true" == $(this).attr("data-number") && isNaN($(this).val()) && ($(this).addClass("sf-error"), requredcontrol = !0), "true" == $(this).attr("data-confirm") && (h.push($(this).val()), u.push($(this)), a())) : "radio" == $(this).attr("type") ? $(this).parent().parent().find("input[type='radio']:checked").length < 1 && ($(this).addClass("sf-error"), requredcontrol = !0) : $(this).parent().parent().find("input[type='checkbox']:checked").length < 1 && ($(this).addClass("sf-error"), requredcontrol = !0)
                }), d(), h.length = 0, requredcontrol ? f.find("#sf-msg").html(t.errormsg) : (o(), u.length = 0, f.find("#sf-next").text() == t.sendbtntext ? (f.find("#sf-msg").text(""), $.ajax({
                    type: "POST",
                    url: t.posturl,
                    data: f.find("form").serialize()
                }).success(function(t) {
                    f.find("#sf-msg").html(t)
                })) : (t.active++, t.active > c - 1 ? (t.active--, f.find("#sf-msg").text("")) : (n(), requredcontrol = !1, f.find("#sf-msg").text(""))))
            }), f.find("#sf-prev").on("click", function() {
                t.active--, t.active < 0 ? t.active++ : (n(), requredcontrol = !1)
            }), s(), $(window).resize(function() {
                s()
            })
        })
    }
})(jQuery);
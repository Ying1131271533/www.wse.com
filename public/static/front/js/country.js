    $(function () {
        $("#country").chosen();
        var slider = $('#partnerSlider');
        slider.kxbdMarquee({
            direction: 'left',
            isEqual: false
        });
        $('#nextBtn').click(function () {
            slider.kxbdMarquee("scrollSize", 500);
        });
        $('#prevBtn').click(function () {
            slider.kxbdMarquee("scrollSize", -500);
        });
        $('.carousel').carousel();
        var ValidatePricingForm = function () {
            var weight = $("#weight").val();
            var length = $("#length").val();
            var width = $("#width").val();
            var height = $("#height").val();
            if (!$("#weight").val()) {
                alert("请填写包裹重量.");
                return false;
            }
            if (!$("#length").val() || !$("#width").val() || !$("#height").val()) {
                alert("请填写包裹包装规格.");
                return false;
            }
            if (jQuery.trim(weight).length > 0
&& jQuery.trim(length).length > 0
&& jQuery.trim(width).length > 0
&& jQuery.trim(height).length > 0) {
                var arr = weight.split(".");
                if (!limitInput(arr)) { return false; }
                arr = length.split(".");
                if (!limitInput(arr)) { return false; }
                arr = width.split(".");
                if (!limitInput(arr)) { return false; }
                var arr = height.split(".");
                if (!limitInput(arr)) { return false; }
            }
            return true;
        }
        $("#pricing_calculator form").submit(ValidatePricingForm);
        $("input[name='supplier']").click(function () {
            $("#divChanneltype").toggle(this.value !== "0");
        });
    });

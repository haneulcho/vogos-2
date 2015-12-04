$(function() {
    $("#btn_more_item").on("click", function() {
        var $this = $(this);
        var url   = $this.data("url");
        var page  = $this.data("page");
        var $msg  = $("#item_load_msg");

        if($msg.is(":visible"))
            return false;

        if($this.hasClass("no_more_item")) {
            alert("No more items");
            return false;
        }

        $msg.css("display", "block");

        $.ajax({
            type: "POST",
            data: { page: page },
            url: url,
            cache: false,
            async: true,
            dataType: "json",
            success: function(data) {
                if(data.error != "") {
                    alert(data.error);
                    return false;
                }

                var $items = $(data.item).find("li");
                var cnt = $items.size();

                if(cnt < 1) {
                    alert("No more items");
                    $msg.css("display", "none");
                    $this.addClass("no_more_item");
                    return false;
                }

                $("ul.sct_wrap").append($items);
    var li = $('.sct_10 .sct_li');
    var win_width = $(window).width();
    li.removeClass (function (index, css) {
        return (css.match (/(^|\s)lic\S+/g) || []).join(' ');
    });

    if(win_width>1023) { var lic = 1024 }
        else if(win_width>767) { var lic = 768 }
        else if(win_width>639) { var lic = 640 }
        else if(win_width>479) { var lic = 480 }
        else if(win_width>359) { var lic = 360 }
        else { var lic = 340 }
    var lic = 'lic'+lic;
    li.addClass(lic);
                $this.data("page", data.page);
                $msg.css("display", "none");
            }
        });
    });
});
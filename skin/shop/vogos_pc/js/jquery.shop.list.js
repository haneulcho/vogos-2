$(function (){
    $(".btn_cart").on("click", function() {
        var it_id = $(this).data("it_id");
        var $opt = $(this).parent().siblings(".sct_cart_op");
        var $btn = $(this).parent();

        $(".sct_cart_op").not($opt).css("display", "");

        $.ajax({
            url: g5_shop_skin_url+"/ajax.itemoption.php",
            type: "POST",
            data: {
                "it_id" : it_id
            },
            dataType: "json",
            async: true,
            cache: false,
            success: function(data, textStatus) {
                if(data.error != "") {
                    alert(data.error);
                    return false;
                }

                $opt.html(data.html);

                if(!data.option) {
                    add_cart($opt.find("form").get(0));
                    return;
                }

                $btn.css("display","none");
                $opt.css("display","block");

                $("select.it_option").fancyOptionSelect();
            }
        });
    });

    $(".btn_cart_m").on("click", function() {
        var it_id = $(this).data("it_id");
        var $opt = $(this).parent().siblings(".sct_cart_op");
        var $btn = $(this).parent();

        $(".sct_cart_op").not($opt).css("display", "");

        $.ajax({
            url: g5_shop_skin_url+"/ajax.itemoption.php",
            type: "POST",
            data: {
                "it_id" : it_id
            },
            dataType: "json",
            async: true,
            cache: false,
            success: function(data, textStatus) {
                if(data.error != "") {
                    alert(data.error);
                    return false;
                }

                $opt.html(data.html);

                if(!data.option) {
                    add_cart($opt.find("form").get(0));
                    return;
                }

                $btn.css("display","none");
                $opt.css("display","block");

                $("select.it_option").fancyOptionSelect();
            }
        });
    });

    $("li.sct_li").on("mouseover", function() {
        var $opt = $(this).find(".sct_cart_op");
        var $btn = $(this).find(".sct_cart_btn");

        if($opt.is(":hidden") && $btn.is(":hidden"))
            $btn.css("display", "block");
    });

    $("li.sct_li").on("mouseout", function() {
        var $opt = $(this).find(".sct_cart_op");
        var $btn = $(this).find(".sct_cart_btn");

        if($opt.is(":hidden") && $btn.is(":visible"))
            $btn.css("display", "");
    });

    $(document).on("click", ".cart_add", function() {
        add_cart(this.form);
    });

    $(document).on("click", ".cartop_close", function() {
        var $el = $(this).closest(".sct_cart_op");
        $el.css("display","none");
    });

    $(".btn_wish").on("click", function() {
        add_wishitem(this);
    });
});

function add_wishitem(el)
{
    var $el   = $(el);
    var it_id = $el.data("it_id");

    if(!it_id) {
        alert("상품코드가 올바르지 않습니다.");
        return false;
    }

    $.post(
        g5_shop_skin_url + "/ajax.wishupdate.php",
        { it_id: it_id },
        function(error) {
            if(error != "OK") {
                alert(error.replace(/\\n/g, "\n"));
                return false;
            }

            alert("ADDED TO YOUR CART!");
            return;
        }
    );
}

function add_cart(frm)
{
    var $frm = $(frm);
    var $opt = $frm.find("ul.options li.selected");
    var $sel = $frm.find("select.it_option");
    var it_name = $frm.find("input[name^=it_name]").val();
    var it_price = parseInt($frm.find("input[name^=it_price]").val());
    var id = "";
    var value, info, sel_opt, item, price, stock, run_error = false;
    var option = sep = "";
    var count = $opt.size();

    if($sel.size() != count) {
        alert("사이즈와 컬러를 제대로 선택해주세요.");
        return false;
    }

    if(count > 0) {
        info = $opt.eq(count - 1).data("raw-value").split(",");

        $opt.each(function(index) {
            value = String($(this).data("raw-value"));
            item = $(this).closest(".fancy-select").prev("label").text();

            if(!value) {
                run_error = true;
                return false;
            }

            // 옵션선택정보
            sel_opt = value.split(",")[0];

            if(id == "") {
                id = sel_opt;
            } else {
                id += chr(30)+sel_opt;
                sep = " / ";
            }

            option += sep + item + ": " + sel_opt;
        });

        if(run_error) {
            alert(it_name+"의 "+item+"을(를) 선택해 주십시오.");
            return false;
        }

        price = info[1];
        stock = info[2];
    } else {
        price = 0;
        stock = $frm.find("input[name^=it_stock]").val();
        option = it_name;
    }

    // 금액 음수 체크
    if(it_price + parseInt(price) < 0) {
        alert("구매금액이 음수인 상품은 구매할 수 없습니다.");
        return false;
    }

    // 옵션 선택정보 적용
    $frm.find("input[name^=io_id]").val(id);
    $frm.find("input[name^=io_value]").val(option);
    $frm.find("input[name^=io_price]").val(price);

    $.ajax({
        url: frm.action,
        type: "POST",
        data: $(frm).serialize(),
        dataType: "json",
        async: true,
        cache: false,
        success: function(data, textStatus) {
            if(data.error != "") {
                alert(data.error);
                return false;
            }

            alert("ADDED TO YOUR CART!");
            $(".sct_cart_op").fadeOut(300);
        }
    });

    return false;
}

// php chr() 대응
if(typeof chr == "undefined") {
    function chr(code)
    {
        return String.fromCharCode(code);
    }
}

// Generated by CoffeeScript 1.4.0
// Modified chicpro
(function() {
    var $;

    $ = window.jQuery || window.Zepto || window.$;

    $.fn.fancyOptionSelect = function(opts) {
        var isiOS, settings;
        if (opts == null) {
          opts = {};
        }
        settings = $.extend({
            forceiOS: false,
            includeBlank: false,
            optionTemplate: function(optionEl) {
                return optionEl.text();
            },
            triggerTemplate: function(optionEl) {
                return optionEl.text();
            }
        }, opts);
        isiOS = !!navigator.userAgent.match(/iP(hone|od|ad)/i);
        return this.each(function() {
            var copyOptionsToList, disabled, options, sel, trigger, updateTriggerText, wrapper;
            sel = $(this);
            if (sel.hasClass('fancified') || sel[0].tagName !== 'SELECT') {
                return;
            }
            sel.addClass('fancified');
            sel.css({
                width: 1,
                height: 1,
                display: 'block',
                position: 'absolute',
                top: 0,
                left: 0,
                opacity: 0
            });
            sel.wrap('<div class="fancy-select">');
            wrapper = sel.parent();
            if (sel.data('class')) {
                wrapper.addClass(sel.data('class'));
            }
            wrapper.append('<div class="trigger">');
            if (!(isiOS && !settings.forceiOS)) {
                wrapper.append('<ul class="options">');
            }
            trigger = wrapper.find('.trigger');
            options = wrapper.find('.options');
            disabled = sel.prop('disabled');
            if (disabled) {
                wrapper.addClass('disabled');
            }
            updateTriggerText = function() {
                var triggerHtml;
                triggerHtml = settings.triggerTemplate(sel.find(':selected'));
                return trigger.html(triggerHtml);
            };
            sel.on('blur.fs', function() {
                if (trigger.hasClass('open')) {
                    return setTimeout(function() {
                        return trigger.trigger('close.fs');
                    }, 120);
                }
            });
            trigger.on('close.fs', function() {
                trigger.removeClass('open');
                return options.removeClass('open');
            });
            trigger.on('click.fs', function() {
                var offParent, parent;
                if (!disabled) {
                    trigger.toggleClass('open');
                    if (isiOS && !settings.forceiOS) {
                        if (trigger.hasClass('open')) {
                            return sel.focus();
                        }
                    } else {
                        if (trigger.hasClass('open')) {
                            parent = trigger.parent();
                            offParent = parent.offsetParent();
                            if ((parent.offset().top + parent.outerHeight() + options.outerHeight() + 20) > $(window).height() + $(window).scrollTop()) {
                                options.addClass('overflowing');
                            } else {
                                options.removeClass('overflowing');
                            }
                        }
                        options.toggleClass('open');
                        if (!isiOS) {
                            return sel.focus();
                        }
                    }
                }
            });
            sel.on('enable', function() {
                sel.prop('disabled', false);
                wrapper.removeClass('disabled');
                disabled = false;
                return copyOptionsToList();
            });
            sel.on('disable', function() {
                sel.prop('disabled', true);
                wrapper.addClass('disabled');
                return disabled = true;
            });
            sel.on('change.fs', function(e) {
                if (e.originalEvent && e.originalEvent.isTrusted) {
                    return e.stopPropagation();
                } else {
                    var $frm = $(this).closest("form");
                    var $sel = $frm.find("select.it_option");
                    var sel_count = $sel.size();
                    var idx = $sel.index($(this));
                    var val = $(this).val();
                    var it_id = $frm.find("input[name='it_id[]']").val();

                    // 선택값이 없을 경우 하위 옵션은 disabled
                    if(val == "") {
                        $frm.find("select.it_option:gt("+idx+")").val("").attr("disabled", true);
                        return;
                    }

                    // 하위선택옵션로드
                    if(sel_count > 1 && (idx + 1) < sel_count) {
                        var opt_id = "";

                        // 상위 옵션의 값을 읽어 옵션id 만듬
                        if(idx > 0) {
                            $frm.find("select.it_option:lt("+idx+")").each(function() {
                                if(!opt_id)
                                    opt_id = $(this).val();
                                else
                                    opt_id += chr(30)+$(this).val();
                            });

                            opt_id += chr(30)+val;
                        } else if(idx == 0) {
                            opt_id = val;
                        }

                        $.post(
                            g5_shop_url + "/itemoption.php",
                            { it_id: it_id, opt_id: opt_id, idx: idx, sel_count: sel_count },
                            function(data) {
                                $sel.eq(idx+1).empty().html(data).attr("disabled", false).trigger("enable").trigger("update.fs");

                                // select의 옵션이 변경됐을 경우 하위 옵션 disabled
                                if(idx+1 < sel_count) {
                                    var idx2 = idx + 1;
                                    $frm.find("select.it_option:gt("+idx2+")").val("").attr("disabled", true);
                                }
                            }
                        );
                    } else if((idx + 1) == sel_count) { // 선택옵션처리
                        if(val == "")
                            return;

                        var info = val.split(",");
                        // 재고체크
                        if(parseInt(info[2]) < 1) {
                            alert("선택하신 선택옵션상품은 재고가 부족하여 구매할 수 없습니다.");
                            return false;
                        }
                    }

                    return updateTriggerText();
                }
            });
            sel.on('keydown', function(e) {
                var hovered, newHovered, w;
                w = e.which;
                hovered = options.find('.hover');
                hovered.removeClass('hover');
                if (!options.hasClass('open')) {
                    if (w === 13 || w === 32 || w === 38 || w === 40) {
                        e.preventDefault();
                        return trigger.trigger('click.fs');
                    }
                } else {
                    if (w === 38) {
                        e.preventDefault();
                        if (hovered.length && hovered.index() > 0) {
                            hovered.prev().addClass('hover');
                        } else {
                            options.find('li:last-child').addClass('hover');
                        }
                    } else if (w === 40) {
                        e.preventDefault();
                        if (hovered.length && hovered.index() < options.find('li').length - 1) {
                            hovered.next().addClass('hover');
                        } else {
                            options.find('li:first-child').addClass('hover');
                        }
                    } else if (w === 27) {
                        e.preventDefault();
                        trigger.trigger('click.fs');
                    } else if (w === 13 || w === 32) {
                        e.preventDefault();
                        hovered.trigger('mousedown.fs');
                    } else if (w === 9) {
                        if (trigger.hasClass('open')) {
                            trigger.trigger('close.fs');
                        }
                    }
                    newHovered = options.find('.hover');
                    if (newHovered.length) {
                        options.scrollTop(0);
                        return options.scrollTop(newHovered.position().top - 12);
                    }
                }
            });
            options.on('mousedown.fs', 'li', function(e) {
                var clicked;
                clicked = $(this);
                sel.val(clicked.data('raw-value'));
                if (!isiOS) {
                    sel.trigger('blur.fs').trigger('focus.fs');
                }
                options.find('.selected').removeClass('selected');
                clicked.addClass('selected');
                trigger.addClass('selected');
                return sel.val(clicked.data('raw-value')).trigger('change.fs').trigger('blur.fs').trigger('focus.fs');
            });
            options.on('mouseenter.fs', 'li', function() {
                var hovered, nowHovered;
                nowHovered = $(this);
                hovered = options.find('.hover');
                hovered.removeClass('hover');
                return nowHovered.addClass('hover');
            });
            options.on('mouseleave.fs', 'li', function() {
                return options.find('.hover').removeClass('hover');
            });
            copyOptionsToList = function() {
                var selOpts;
                updateTriggerText();
                if (isiOS && !settings.forceiOS) {
                    return;
                }
                selOpts = sel.find('option');
                return sel.find('option').each(function(i, opt) {
                    var optHtml;
                    opt = $(opt);
                    if (!opt.prop('disabled') && (opt.val() || settings.includeBlank)) {
                        optHtml = settings.optionTemplate(opt);
                        if (opt.prop('selected')) {
                            return options.append("<li data-raw-value=\"" + (opt.val()) + "\" class=\"selected\">" + optHtml + "</li>");
                        } else {
                            return options.append("<li data-raw-value=\"" + (opt.val()) + "\">" + optHtml + "</li>");
                        }
                    }
                });
            };
            sel.on('update.fs', function() {
                wrapper.find('.options').empty();
                return copyOptionsToList();
            });
                return copyOptionsToList();
        });
    };
}).call(this);
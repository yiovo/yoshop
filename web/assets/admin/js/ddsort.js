/**
 * DDSort: drag and drop sorting.
 * Documentation: https://github.com/Barrior/DDSort
 */
+function ($) {
    var defaultOptions = {
        down: $.noop,
        move: $.noop,
        up: $.noop,
        target: 'li',
        delay: 100,
        cloneStyle: {
            'background-color': '#eee'
        },
        floatStyle: {
            // 用固定定位可以防止定位父级不是Body的情况的兼容处理，表示不兼容IE6，无妨
            'position': 'fixed',
            'border': '1px solid #ccc',
            'background-color': '#fff',
            // 'box-shadow': '10px 10px 20px 0 #eee',
            // 'webkitTransform': 'rotate(4deg)',
            // 'mozTransform': 'rotate(4deg)',
            // 'msTransform': 'rotate(4deg)',
            // 'transform': 'rotate(4deg)'
        }
    };

    $.fn.DDSort = function (options) {
        var $doc = $(document);
        var settings = $.extend(true, {}, defaultOptions, options);

        return this.each(function () {

            var that = $(this);
            var height = 'height';
            var width = 'width';

            if (that.css('box-sizing') == 'border-box') {
                height = 'outerHeight';
                width = 'outerWidth';
            }

            that.on('mousedown.DDSort touchstart.DDSort', settings.target, function (e) {

                var startTime = new Date().getTime();

                // 桌面端只允许鼠标左键拖动
                if (e.type == 'mousedown' && e.which != 1) return;

                // 防止表单元素，a 链接，可编辑元素失效
                var tagName = e.target.tagName.toLowerCase();
                if (tagName == 'input' || tagName == 'textarea' || tagName == 'select' ||
                    tagName == 'a' || $(e.target).prop('contenteditable') == 'true') {
                    return;
                }

                var self = this;
                var $this = $(self);
                // 鼠标按下时的元素偏移
                var offset = $this.offset();

                // 鼠标按下时的光标坐标
                // 桌面端
                var pageX = e.pageX;
                var pageY = e.pageY;

                // 移动端
                var targetTouches = e.originalEvent.targetTouches;
                if (e.type == 'touchstart' && targetTouches) {
                    pageX = targetTouches[0].pageX;
                    pageY = targetTouches[0].pageY;
                }

                var clone = $this.clone()
                        .css(settings.cloneStyle)
                        .css('height', $this[height]())
                        .empty();

                var hasClone = 1;

                // 缓存计算
                var thisOuterHeight = $this.outerHeight(),
                    thisOuterWidth = $this.outerWidth(),
                    thatOuterHeight = that.outerHeight(),
                    thatOuterWidth = that.outerWidth();

                // 滚动速度
                var upSpeed = thisOuterHeight,
                    downSpeed = thisOuterHeight,
                    leftSpeed = thisOuterWidth,
                    rightSpeed = thisOuterWidth,
                    maxSpeed = thisOuterHeight * 3;

                settings.down.call(self);

                $doc.on('mousemove.DDSort touchmove.DDSort', function (e) {

                    // 鼠标移动时的光标坐标
                    // 桌面端
                    var _pageX = e.pageX;
                    var _pageY = e.pageY;

                    // 移动端
                    var targetTouches = e.originalEvent.targetTouches;
                    if (e.type == 'touchmove' && targetTouches) {
                        _pageX = targetTouches[0].pageX;
                        _pageY = targetTouches[0].pageY;
                    }

                    if (new Date().getTime() - startTime < settings.delay) {
                        return;
                    }

                    if (hasClone) {
                        $this.before(clone)
                            .css('width', $this[width]())
                            .css(settings.floatStyle)
                            .appendTo($this.parent());

                        hasClone = 0;
                    }

                    var disX = pageX - _pageX;
                    var disY = pageY - _pageY;
                    var left = offset.left - disX;
                    var top = offset.top - disY;

                    $this.offset({
                        left: left,
                        top: top
                    });

                    var $left = getLeft(clone),
                        $right = getRight(clone, $this),
                        $top = getTop(clone),
                        $under = getUnder(clone, $this);


                    if ($top && $top.length && top < $top.offset().top + $top.outerHeight(true) / 2) {
                        // 向上排序
                        $top.before(clone);

                    } else if ($under && $under.length && top + thisOuterHeight > $under.offset().top + $under.outerHeight(true) / 2) {
                        // 向下排序
                        $under.after(clone);

                    } else if($left && $left.length && left < $left.offset().left + $left.outerWidth(true) / 2) {
                        //向左排序
                        $left.before(clone);

                    } else if($right && $right.length && left + thisOuterWidth > $right.offset().left + $right.outerWidth(true) / 2) {
                        //向右排序
                        $right.after(clone);

                    }

                    // 处理滚动条，that 是带着滚动条的元素，这里默认以为 that 元素是这样的元素（正常情况就是这样），
                    // 如果使用者事件委托的元素不是这样的元素，那么需要提供接口出来
                    var thatScrollTop = that.scrollTop();
                    var thatOffsetTop = that.offset().top;
                    if (top < thatOffsetTop) {
                        // 向上滚动
                        downSpeed = thisOuterHeight;
                        upSpeed = ++upSpeed > maxSpeed ? maxSpeed : upSpeed;
                        var scrollVal = thatScrollTop - upSpeed;
                        that.scrollTop(scrollVal);
                    } else if (top + thisOuterHeight - thatOffsetTop > thatOuterHeight) {
                        // 向下滚动
                        upSpeed = thisOuterHeight;
                        downSpeed = ++downSpeed > maxSpeed ? maxSpeed : downSpeed;
                        var scrollVal = thatScrollTop + downSpeed;
                        that.scrollTop(scrollVal);
                    }

                    var thatScrollLeft = that.scrollLeft();
                    var thatOffsetLeft = that.offset().left;
                    if (left < that.offset().left) {
                        // 向左滚动
                        rightSpeed = thisOuterWidth;
                        leftSpeed = ++leftSpeed > maxSpeed ? maxSpeed : leftSpeed;
                        var scrollVal = thatScrollLeft - leftSpeed;
                        that.scrollLeft(scrollVal);
                    } else if (left + thisOuterWidth - thatOffsetLeft > thatOuterWidth) {
                        // 向右滚动
                        leftSpeed = thisOuterWidth;
                        rightSpeed = ++rightSpeed > maxSpeed ? maxSpeed : rightSpeed;
                        var scrollVal = thatScrollLeft + rightSpeed;
                        that.scrollLeft(scrollVal);
                    }

                    settings.move.call(self, left, top);
                })
                .on('mouseup.DDSort touchend.DDSort', function () {

                    $doc.off('mousemove.DDSort mouseup.DDSort touchmove.DDSort touchend.DDSort');

                    // click 的时候也会触发 mouseup 事件，加上判断阻止这种情况
                    if (!hasClone) {
                        clone.before($this.removeAttr('style')).remove();
                        settings.up.call(self);
                    }
                });

                return false;
            });
        });
    };


    //允许计算误差
    var deviation = 5;

    var getLeft = function (clone) {
        var left = clone.prev();
        if(left.length && clone.offset().top==left.offset().top) {
            var _dev = Math.abs(clone.offset().left - (left.offset().left + left.outerWidth(true)));
            if(_dev <= deviation) {
                return left;
            }
        }
        return undefined;
    }
    var getTop = function (clone, prev) {
        if(!prev){
            prev = clone.prev();
        }
        if(!prev.length) {
            return undefined;
        }
        if(clone.offset().left==prev.offset().left) {
            var _dev = Math.abs(clone.offset().top - (prev.offset().top+prev.outerHeight(true)));
            if(_dev <= deviation) {
                return prev;
            }
        }
        return getTop(clone, prev.prev());
    }
    var getRight = function (clone, $this) {
        var rigth = clone.next().not($this);
        if(rigth.length && clone.offset().top==rigth.offset().top) {
            var _dev = Math.abs(clone.offset().left - (rigth.offset().left-clone.outerWidth(true)));
            if(_dev <= deviation) {
                return rigth;
            }
        }
        return undefined;
    }
    var getUnder = function (clone, $this, next) {
        if(!next){
            next = clone.next().not($this);
        }
        if(!next.length) {
            return undefined;
        }
        if(clone.offset().left==next.offset().left) {
            var _dev = Math.abs(clone.offset().top - (next.offset().top-clone.outerHeight(true)));
            if(_dev <= deviation) {
                return next;
            }
        }
        return getUnder(clone, $this, next.next().not($this));
    }
}(jQuery);

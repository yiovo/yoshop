(function () {

    /***
     * 配送区域表格
     * @param param
     * @constructor
     */
    function Delivery(param) {
        this.tableElement = param.table;
        this.RegionalChoice = new RegionalChoice(param.regional, param.datas);
        this.initCreateRegion();
        this.clickEditEvent();
        this.clickDeleteEvent();
        this.clickMethodEvent();
    }

    Delivery.prototype = {

        /**
         * 初始化添加区域事件
         */
        initCreateRegion: function () {
            var _this = this;
            $(_this.tableElement).find('.add-region').click(function () {
                // 渲染地域
                var str = '';
                $(_this.tableElement).find('input[type=hidden]').each(function (index, item) {
                    str += $(item).val() + ',';
                });
                var alreadyIds = str.length > 0 ? str.substring(0, str.length - 1).split(',') : [];
                if (alreadyIds.length === 373) {
                    layer.msg('已经选择了所有区域~');
                    return false;
                }
                _this.RegionalChoice.render(alreadyIds);
                _this.showRegionalModal(function () {
                    // 弹窗交互完成
                    var Checked = _this.RegionalChoice.getCheckedContent();
                    Checked.ids.length > 0 && _this.appendRulesTr(Checked.content, Checked.ids);
                });
            });
        },

        /**
         * 创建可配送区域规则
         */
        appendRulesTr: function (regionStr, checkedIds) {
            var $html = $(
                '<tr>' +
                '<td class="am-text-left">' +
                '   <p class="selected-content am-margin-bottom-xs">' +
                '   ' + regionStr +
                '   </p>' +
                '   <p class="operation am-margin-bottom-xs">' +
                '       <a class="edit" href="javascript:;">编辑</a>' +
                '       <a class="delete" href="javascript:;">删除</a>' +
                '   </p>' +
                '   <input type="hidden" name="delivery[rule][region][]" value="' + checkedIds + '">' +
                '</td>' +
                '<td>' +
                '   <input type="number" name="delivery[rule][first][]" value="1" required>' +
                '</td>' +
                '<td>' +
                '   <input type="number" name="delivery[rule][first_fee][]" value="0.00" required>' +
                '</td>' +
                '<td>' +
                '   <input type="number" name="delivery[rule][additional][]" value="0">' +
                '</td>' +
                '<td>' +
                '   <input type="number" name="delivery[rule][additional_fee][]" value="0.00">' +
                '</td>' +
                '</tr>'
            );
            $(this.tableElement).children().find('tr:last').before($html);
        },

        /**
         * 显示区域选择窗口
         * @param callback
         */
        showRegionalModal: function (callback) {
            var _this = this;
            layer.open({
                type: 1,
                shade: false,
                title: '选择可配送区域',
                btn: ['确定', '取消'],
                area: ['820px', '520px'], //宽高
                content: $('.regional-choice'),
                yes: function (index) {
                    callback && callback();
                    layer.close(index);
                },
                end: function () {
                    // 销毁已选中区域
                    _this.RegionalChoice.destroy();
                }
            });
        },

        /**
         * 编辑区域事件
         */
        clickEditEvent: function () {
            var _this = this
                , $table = $(_this.tableElement);
            $table.on('click', '.edit', function () {
                // 渲染地域
                var $html = $(this).parent().parent()
                    , $content = $html.find('.selected-content')
                    , $input = $html.find('input[type=hidden]');
                _this.RegionalChoice.render([], $input.val().split(','));
                // 显示地区选择弹窗
                _this.showRegionalModal(function () {
                    // 弹窗交互完成
                    var Checked = _this.RegionalChoice.getCheckedContent();
                    if (Checked.ids.length > 0) {
                        $content.html(Checked.content);
                        $input.val(Checked.ids);
                    }
                });
            });
        },

        /**
         * 删除区域事件
         */
        clickDeleteEvent: function () {
            var $table = $(this.tableElement);
            $table.on('click', '.delete', function () {
                var $delete = $(this);
                layer.confirm('确定要删除吗？', function (index) {
                    $delete.parents('tr').remove();
                    layer.close(index);
                });
            });
        },

        /**
         * 切换计费方式
         */
        clickMethodEvent: function () {
            $('input:radio[name="delivery[method]"]').change(function (e) {
                var $first = $('.first')
                    , $additional = $('.additional');
                if (e.currentTarget.value === '20')
                    $first.text('首重 (Kg)') && $additional.text('续重 (Kg)');
                else
                    $first.text('首件 (个)') && $additional.text('续件 (个)');
            });
        },

    };

    window.Delivery = Delivery;

})(window);

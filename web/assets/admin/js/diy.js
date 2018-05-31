(function () {
    /**
     * 默认diy元素参数
     * @type {{items: {search: {id: string, params: {placeholder: string}, style: {background: string, iconColor: string, inputBackground: string, inputColor: string, textAlign: string, paddingTop: string, paddingLeft: string}}}}}
     */
    // let defaultData = {
    //     items: {
    //         search: {
    //             "id": "search",
    //             "params": {"placeholder": "请输入关键字进行搜索"},
    //             "style": {
    //                 "background": "#f1f1f2",
    //                 "iconColor": "#b4b4b4",
    //                 "inputBackground": "#ffffff",
    //                 "inputColor": "#999999",
    //                 "textAlign": "left",
    //                 "paddingTop": "10",
    //                 "paddingLeft": "10",
    //             },
    //         },
    //     },
    // };

    /***
     * 前端可视化diy
     * @constructor
     */
    function diyPhone(data, opts) {
        // 配置信息
        let defaults = {
            container: '#phone-main',
            editor: '#diy-editor',
        };
        this.options = $.extend({}, defaults, opts);
        this.data = data;
        // 渲染已有diy数据
        this.initRender();
        // 初始化元素拖拽事件
        this.initItemDDSort();
        // 初始化选中元素事件
        this.initItemSelected();
        // 注册数据绑定
        this.diyDataBind();
    }

    diyPhone.prototype = {

        /**
         * 注册数据绑定
         */
        diyDataBind: function () {
            let _this = this;
            // 绑定input修改事件
            $(_this.options.editor).on('change', 'input[data-bind]', function () {
                let $this = $(this)
                    , val = $this.val()
                    , itemIndex = $this.data('bind').split('.')
                    , itemId = $this.parents('form').data('itemid');
                // 数据绑定 (最多支持3级)
                _this.setData(itemId, itemIndex, val);
                // 渲染元素
                _this.render(itemId);
            });
        },

        /**
         * 初始化选中元素事件
         */
        initItemSelected: function () {
            let _this = this;
            let $container = $(this.options.container);
            $container.on('click', '.drag', function () {
                let $drag = $(this);
                if (!$drag.hasClass('selected')) {
                    // 设置选中
                    $container.children().removeClass('selected');
                    $drag.addClass('selected');
                    // 渲染编辑器
                    _this.renderEditor($drag.data('itemid'));
                }
            });
        },


        /**
         * 初始化元素拖拽事件
         */
        initItemDDSort: function () {
            // diy元素拖拽
            $(this.options.container).DDSort({
                target: '.drag',
                delay: 100, // 延时处理，默认为 50 ms，防止手抖点击 A 链接无效
                floatStyle: {
                    'border': '1px solid #ccc',
                    'background-color': '#fff'
                }
            });
        },

        /**
         * 渲染当前diy元素
         */
        initRender: function () {
            let html = '';
            $.each(this.data.items, function (index, item) {
                html += template('tpl_diy_' + item.type, item);
            });
            $(this.options.container).html(html);
        },

        /**
         * 渲染diy子元素
         * @param itemId
         */
        render: function (itemId) {
            let item = this.data.items[itemId]
                , html = template('tpl_diy_' + item.type, item);
            $('#diy_' + item.id).prop('outerHTML', html);
        },

        /**
         * 渲染元素编辑器
         * @param itemId
         */
        renderEditor: function (itemId) {
            let $diyEditor = $('#diy-editor')
                ,item = this.data.items[itemId]
                , html = template('tpl_editor_' + item.type, item);
            $diyEditor.find('.inner').html(html);
            $diyEditor.find('input[type=checkbox], input[type=radio]').uCheck();
        },

        /**
         * 数据绑定
         * @param itemId
         * @param itemIndex
         * @param val
         */
        setData: function (itemId, itemIndex, val) {
            let item = this.data.items[itemId][itemIndex[0]];
            switch (itemIndex.length) {
                case 1:
                    item = val;
                    break;
                case 2:
                    item[itemIndex[1]] = val;
                    break;
                case 3:
                    item[itemIndex[1]][itemIndex[2]] = val;
                    break;
            }
        },

    };

    window.diyPhone = diyPhone;

})(window);

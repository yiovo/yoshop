;(function ($, window, document, undefined) {

    function FileLibrary(trigger, options) {
        // 配置项
        var defaults = {
            layerId: 'file-library'
            , layerSkin: 'file-library'
        };
        this.options = $.extend({}, defaults, options);
        // 触发对象
        this.$trigger = trigger;
        // 容器元素
        this.$element = null;
        // 初始化对象事件
        this.init();
    }

    FileLibrary.prototype = {

        /**
         * 初始化
         */
        init: function () {
            var _this = this;
            _this.triggerEvent();
        },

        /**
         * 触发元素事件
         */
        triggerEvent: function () {
            var _this = this;
            // 点击开启文件库弹窗
            _this.$trigger.click(function () {
                _this.showLibraryModal();
            });
        },

        /**
         * 显示文件库弹窗
         */
        showLibraryModal: function () {
            var _this = this
                , loadIndex = layer.load();
            _this.getJsonData({}, function (data) {
                layer.close(loadIndex);
                // 捕获页
                layer.open({
                    type: 1
                    , id: _this.options.layerId
                    , title: '图片库'
                    , skin: _this.options.layerSkin
                    , area: '840px'
                    , offset: '120px'
                    , closeBtn: 1
                    , shade: 0.3
                    , btn: ['确定', '取消']
                    , content: template('tpl-file-library', data)
                    , success: function (layero) {
                        // 初始化文件库弹窗
                        _this.initLibraryModal(layero);
                    }
                    , yes: function (index) {
                        // 确认回调
                        _this.done();
                        layer.close(index);
                    }
                });
            });
        },

        /**
         * 初始化文件库弹窗
         */
        initLibraryModal: function (element) {
            var _this = this;
            _this.$element = element;
            var $fileGroup = _this.$element.find('.file-group');
            // 注册selete元素
            _this.$element.find('[data-am-selected]').selected();
            // 注册分类切换事件
            $fileGroup.find('li').click(function () {
                var $this = $(this);
                // 切换选中状态
                $fileGroup.find('li.active').removeClass('active');
                $this.addClass('active');
                // 重新渲染文件列表
                _this.getJsonData({group_id: $this.data('group-id')}, function (data) {
                    _this.renderFileList(data);
                });
            });
            // 绑定文件选中事件
            _this.$element.on('click', '#file-item-box li', function () {
                $(this).toggleClass('active');
            });
        },

        /**
         * 获取文件库列表数据
         * @param params
         * @param success
         */
        getJsonData: function (params, success) {
            typeof params === 'function' && (success = params);
            // 获取文件库列表
            $.getJSON(BASE_URL + '/upload/library', params, function (data) {
                typeof success === 'function' && success(data);
            });
        },

        /**
         * 渲染文件列表
         * @param data
         */
        renderFileList: function (data) {
            this.$element.find('#file-item-box').html(template('tpl-file-list', data));
        },

        /**
         * 获取选中的文件列表
         */
        getSelectedData: function () {
            var selectedList = [];
            this.$element.find('#file-item-box > li.active').each(function (index) {
                var $this = $(this);
                selectedList[index] = {
                    file_id: $this.data('file-id')
                    , file_path: $this.data('file-path')
                };
            });
            return selectedList;
        },

        /**
         * 确认回调
         */
        done: function () {
            var selectedList = this.getSelectedData();
            selectedList.length > 0 && typeof this.options.done === 'function' && this.options.done(selectedList);
        }

    };

    // 在Jquery插件中使用FileLibrary对象
    $.fn.fileLibrary = function (options) {
        new FileLibrary(this, options);
    };

})(jQuery, window, document);

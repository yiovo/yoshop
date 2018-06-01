(function () {

    // 默认添加的
    let addItemData = {
        banner: {
            imgUrl: 'http://wm.awm1314.com/addons/ewei_shopv2/plugin/app/static/images/default/banner-1.jpg',
            imgName: '',
            linkUrl: '',
        },
    };

    /**
     * 私有方法
     */
    let method = {
        editor: {
            // 添加元素
            addItem: {

                /**
                 * 添加banner
                 * @param $items
                 * @param data
                 */
                banner: function ($items, data) {
                    let itemId = $items.parent().data('itemid')
                        , dataId = 'n' + Math.random().toString().substr(3)
                        , newData = $.extend(true, {}, addItemData.banner);
                    data.items[itemId].data[dataId] = newData;
                    let $html = $(
                        '<div class="item">' +
                        '    <div class="item-image"> <img src="' + newData.imgUrl + '" alt=""> </div>' +
                        '    <div class="item-form am-form-file">' +
                        '        <div class="input-group">' +
                        '            <input type="text" data-bind="data.' + dataId + '.imgName"' +
                        '               value="' + newData.imgName + '" placeholder="请选择图片">' +
                        '            <span class="input-group-addon">上传图片</span>' +
                        '            <input type="hidden" data-bind="data.' + dataId + '.imgName"' +
                        '                value="' + newData.imgName + '">' +
                        '        </div>' +
                        '        <div class="input-group" style="margin-top:10px;">' +
                        '            <input type="text" class="" placeholder="请输入链接地址    例：page/index/index" value="">' +
                        '        </div>' +
                        '    </div>' +
                        '    <i class="iconfont icon-shanchu item-delete"></i>' +
                        '</div>'
                    );
                    $items.append($html);
                    // 文件上传
                    method.editor.event.upload();
                },
            },

            /**
             * 事件管理
             */
            event: {

                /**
                 * 事件注册
                 */
                register: function ($html, data) {
                    // input单事件
                    method.editor.event.input($html);
                    // 删除子元素事件
                    method.editor.event.itemDelete($html, data);
                    // 添加子元素事件
                    method.editor.event.itemAdd($html, data);
                },

                /**
                 * 单/多选框事件
                 * @param $html
                 */
                input: function ($html) {
                    // 单/多选框
                    $html.find('input[type=checkbox], input[type=radio]').uCheck();
                },

                /**
                 * 删除子元素事件
                 * @param $html
                 */
                itemDelete: function ($html) {
                    // 子元素删除事件
                    $html.on('click', '.item-delete', function () {
                        if ($html.find('.item-delete').length <= 1) {
                            layer.msg('至少保留一个');
                            return false;
                        }
                        let _this = this;
                        layer.confirm('您确定要删除吗？', {
                            title: '友情提示'
                        }, function (index) {
                            $(_this).parent().remove();
                            layer.close(index);
                        });
                    });
                },

                /**
                 * 添加子元素事件
                 * @param $html
                 * @param data
                 */
                itemAdd: function ($html, data) {
                    $html.find('.form-item-add').click(function () {
                        let $items = $(this).prev('.form-items');
                        method.editor.addItem.banner($items, data);


                        console.log(data);
                    });
                },

                /**
                 * 单文件上传事件
                 * 因webupload插件特殊性, 所以需添加html元素后再调用
                 */
                upload: function () {
                    let option = {
                        pick: '.input-group-addon',
                        list: '.item-image'
                    };
                    // 文件大小
                    let maxSize = option.maxSize !== undefined ? option.maxSize : 2
                        // 初始化Web Uploader
                        , uploader = WebUploader.create({
                            // 选完文件后，是否自动上传。
                            auto: true,
                            // 允许重复上传
                            duplicate: true,
                            // 文件接收服务端。
                            server: BASE_URL + '/upload/images',
                            // 选择文件的按钮。可选。
                            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                            pick: {
                                id: option.pick,
                                multiple: false
                            },
                            // 文件上传域的name
                            fileVal: 'iFile',
                            // 图片上传前不进行压缩
                            compress: false,
                            // 文件总数量
                            // fileNumLimit: 1,
                            // 文件大小2m => 2097152
                            fileSingleSizeLimit: maxSize * 1024 * 1024,
                            // 只允许选择图片文件。
                            accept: {
                                title: 'Images',
                                extensions: 'gif,jpg,jpeg,bmp,png',
                                mimeTypes: 'image/*'
                            },
                            // 缩略图配置
                            thumb: {
                                quality: 100,
                                crop: false,
                                allowMagnify: false
                            }
                        });
                    //  验证大小
                    uploader.on('error', function (type) {
                        if (type === "F_DUPLICATE") {
                        } else if (type === "F_EXCEED_SIZE") {
                            alert("文件大小不可超过" + maxSize + "m 哦！换个小点的文件吧！");
                        }
                    });

                    // 当有文件添加进来的时候
                    uploader.on('fileQueued', function (file) {
                        let $input = $('#rt_' + file.source.ruid).parent().prev('input')
                            , $list = $input.parent().parent().prev(option.list)
                            , $li = $('<div>' +
                            '<img>' +
                            '</div>'),
                            $img = $li.find('img');
                        $list.empty().append($li);
                        uploader.makeThumb(file, function (error, src) {
                            if (error) {
                                $img.replaceWith('<span>不能预览</span>');
                                return;
                            }
                            $img.attr('src', src);
                        }, 1, 1);
                    });
                    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
                    uploader.on('uploadSuccess', function (file, response) {
                        if (response.code === 1) {
                            let $addon = $('#rt_' + file.source.ruid).parent();
                            $addon.prev('input').val(response.data.path).change();
                            $addon.next('input').val(response.data.file_path).change();
                        } else
                            alert('图片上传失败');
                    });
                    // 文件上传失败
                    uploader.on('uploadError', function () {
                        alert('图片上传失败');
                    });

                },

            }
        }
    };

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
            $(_this.options.editor).on('propertychange change', 'input[data-bind]', function () {
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
         * 初始化diy元素选中事件
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
         * 初始化diy元素拖拽事件
         */
        initItemDDSort: function () {
            // diy元素拖拽
            $(this.options.container).DDSort({
                target: '.drag',
                delay: 100, // 延时处理，默认为 50 ms，防止手抖点击 A 链接无效
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
                , html = template('tpl_diy_' + item.type, item)
                , $diy = function () {
                return $('#diy_' + item.id);
            };
            $diy().prop('outerHTML', html).addClass('selected');
            $diy().addClass('selected');
        },

        /**
         * 渲染元素编辑器
         * @param itemId
         */
        renderEditor: function (itemId) {
            let item = this.data.items[itemId]
                , $form = $(template('tpl_editor_' + item.type, item))
                , $formItems = $form.find('.form-items');
            // 拖拽事件
            $formItems.DDSort({
                target: '.item',
                delay: 100, // 延时处理，默认为 50 ms，防止手抖点击 A 链接无效
            });
            // 注册所有事件
            method.editor.event.register($form, this.data);
            // 写入编辑器
            $('#diy-editor').find('.inner').html($form);
            // 注册文件上传
            method.editor.event.upload();
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

;(function ($, window, document, undefined) {

    /**
     * 文件库模块
     * @param trigger
     * @param options
     * @constructor
     */
    function FileLibrary(trigger, options) {
        // 配置项
        var defaults = {
            type: 'image',
            layerId: 'file-library'
            , layerSkin: 'file-library'
        };
        this.options = $.extend({}, defaults, options);
        // 触发对象
        this.$trigger = trigger;
        this.$touch = null; // 当前触发元素
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
            // 打开文件库事件
            _this.triggerEvent();
        },

        /**
         * 打开文件库事件
         */
        triggerEvent: function () {
            var _this = this;
            // 点击开启文件库弹窗
            _this.$trigger.click(function () {
                _this.$touch = $(this);
                _this.showLibraryModal();
            });
        },

        /**
         * 显示文件库弹窗
         */
        showLibraryModal: function () {
            var _this = this;
            _this.getJsonData({group_id: -1}, function (data) {
                data.is_default = true;
                // 捕获页
                layer.open({
                    type: 1
                    , id: _this.options.layerId
                    , title: '图片库'
                    , skin: _this.options.layerSkin
                    , area: '840px'
                    , offset: 'auto'
                    , anim: 1
                    , closeBtn: 1
                    , shade: 0.3
                    , btn: ['确定', '取消']
                    , content: template('tpl-file-library', data)
                    , success: function (layero) {
                        // 初始化文件库弹窗
                        _this.initModal(layero);
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
        initModal: function (element) {
            var _this = this;
            _this.$element = element;
            // 注册分组下拉选择组件
            _this.selectDropdown();
            // 注册分类切换事件
            _this.switchClassEvent();
            // 注册文件点击选中事件
            _this.selectFilesEvent();
            // 新增分组事件
            _this.addGroupEvent();
            // 编辑分组事件
            _this.editGroupEvent();
            // 删除分组事件
            _this.deleteGroupEvent();
            // 注册文件上传事件
            _this.uploadImagesEvent();
            // 注册文件删除事件
            _this.deleteFilesEvent();
            // 注册文件移动事件
            _this.moveFilesEvent();
            // 注册文件列表分页事件
            _this.fileListPage();
        },

        /**
         * 注册文件列表分页事件
         */
        fileListPage: function () {
            var _this = this;
            _this.$element.find('#file-list-body').on('click', '.switch-page', function () {
                var page = $(this).data('page');
                _this.renderFileList(page);
            });
        },

        /**
         * 文件移动事件
         */
        moveFilesEvent: function () {
            var _this = this
                , $groupSelect = _this.$element.find('.group-select');
            // 绑定文件选中事件
            $groupSelect.on('click', '.move-file-group', function () {
                $groupSelect.dropdown('close');
                var groupId = $(this).data('group-id')
                    , fileIds = _this.getSelectedFileIds();
                if (fileIds.length === 0) {
                    layer.msg('您还没有选择任何文件~', {offset: 't', anim: 6});
                    return false;
                }
                layer.confirm('确定移动选中的文件吗？', {title: '友情提示'}, function (index) {
                    var load = layer.load();
                    $.post(STORE_URL + '/upload.library/moveFiles', {
                        group_id: groupId
                        , fileIds: fileIds
                    }, function (result) {
                        layer.msg(result.msg);
                        if (result.code === 1) {
                            _this.renderFileList();
                        }
                        layer.close(load);
                    });
                    layer.close(index);
                });
            });
        },

        /**
         * 删除选中的文件
         */
        deleteFilesEvent: function () {
            var _this = this;
            _this.$element.on('click', '.file-delete', function () {
                var fileIds = _this.getSelectedFileIds();
                if (fileIds.length === 0) {
                    layer.msg('您还没有选择任何文件~', {offset: 't', anim: 6});
                    return;
                }
                layer.confirm('确定删除选中的文件吗？', {title: '友情提示'}, function (index) {
                    var load = layer.load();
                    $.post(STORE_URL + '/upload.library/deleteFiles', {
                        fileIds: fileIds
                    }, function (result) {
                        layer.close(load);
                        if (result.code === 1) {
                            _this.renderFileList();
                        }
                    });
                    layer.close(index);
                });
            });
        },

        /**
         * 文件上传 (多文件)
         */
        uploadImagesEvent: function () {
            var _this = this;
            var loadIndex = null;
            // 文件大小
            var maxSize = 2;
            // 初始化Web Uploader
            var uploader = WebUploader.create({
                // 选完文件后，是否自动上传。
                auto: true,
                // 文件接收服务端。
                server: STORE_URL + '/upload/image',
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: {
                    id: '.j-upload',
                    multiple: true
                },
                // 文件上传域的name
                fileVal: 'iFile',
                // 图片上传前不进行压缩
                compress: false,
                // 允许重复
                duplicate: true,
                // 文件总数量
                // fileNumLimit: 10,
                // 文件大小2m => 2097152
                fileSingleSizeLimit: maxSize * 1024 * 1024,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                // 文件上传header扩展
                headers: {
                    'Accept': 'application/json, text/javascript, */*; q=0.01',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            //  验证大小
            uploader.on('error', function (type) {
                if (type === 'F_DUPLICATE') {
                    console.log('请不要重复选择文件！');
                } else if (type === 'F_EXCEED_SIZE') {
                    alert('文件大小不可超过' + maxSize + 'm 哦！换个小点的文件吧！');
                }
            });
            // 文件上传前触发,添加附带参数
            uploader.on('uploadBeforeSend', function (obj, data) {
                data.group_id = _this.getCurrentGroupId();
            });
            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function (file, response) {
                if (response.code === 1) {
                    var $list = _this.$element.find('ul.file-list-item');
                    $list.prepend(template('tpl-file-list-item', [response.data]));
                } else {
                    uploader.uploadError(file, response);
                }
            });
            // 监听文件上传失败
            uploader.on('uploadError', function (file, reason) {
                uploader.uploadError(file, reason);
            });
            // 文件上传失败回调函数
            uploader.uploadError = function (file, reason) {
                layer.msg(reason.msg, {anim: 6});
            };
            // 文件开始上传
            uploader.on('startUpload', function () {
                loadIndex = layer.load();
            });
            // 文件上传结束
            uploader.on('uploadFinished', function () {
                layer.close(loadIndex);
            });
        },

        /**
         * 新增分组事件
         */
        addGroupEvent: function () {
            var _this = this
                , $groupList = _this.$element.find('.file-group > ul');
            _this.$element.on('click', '.group-add', function () {
                layer.prompt({title: '请输入新分组名称'}, function (value, index) {
                    var load = layer.load();
                    $.post(STORE_URL + '/upload.library/addGroup', {
                        group_name: value,
                        group_type: _this.options.type
                    }, function (result) {
                        layer.msg(result.msg);
                        if (result.code === 1) {
                            $groupList.append(template('tpl-group-item', result.data));
                            var $groupSelectList = _this.$element.find('.group-select > .group-list');
                            $groupSelectList.append(
                                '<li>' +
                                '    <a class="move-file-group" data-group-id="' + result.data.group_id + '"' +
                                '       href="javascript:void(0);">' + result.data.group_name + '</a>' +
                                '</li>'
                            );
                        }
                        layer.close(load);
                    });
                    layer.close(index);
                });
            });
        },

        /**
         * 编辑分组事件
         */
        editGroupEvent: function () {
            var _this = this;
            _this.$element.find('.file-group').on('click', '.group-edit', function () {
                var $li = $(this).parent()
                    , group_id = $li.data('group-id');
                layer.prompt({title: '修改分组名称', value: $li.attr('title')}, function (value, index) {
                    var load = layer.load();
                    $.post(STORE_URL + '/upload.library/editGroup', {
                        group_id: group_id
                        , group_name: value
                    }, function (result) {
                        layer.msg(result.msg);
                        if (result.code === 1) {
                            $li.attr('title', value).find('.group-name').text(value);
                            var $groupSelectList = _this.$element.find('.group-select > .group-list');
                            $groupSelectList.find('[data-group-id="' + group_id + '"]').text(value);
                        }
                        layer.close(load);
                    });
                    layer.close(index);
                });
                return false;
            });
        },

        /**
         * 删除分组事件
         */
        deleteGroupEvent: function () {
            var _this = this;
            _this.$element.find('.file-group').on('click', '.group-delete', function () {
                var $li = $(this).parent()
                    , group_id = $li.data('group-id');
                layer.confirm('确定删除该分组吗？', {title: '友情提示'}, function (index) {
                    var load = layer.load();
                    $.post(STORE_URL + '/upload.library/deleteGroup', {
                        group_id: group_id
                    }, function (result) {
                        layer.msg(result.msg);
                        if (result.code === 1) {
                            $li.remove();
                            var $groupSelectList = _this.$element.find('.group-select > .group-list');
                            $groupSelectList.find('[data-group-id="' + group_id + '"]').remove();
                        }
                        layer.close(load);
                    });
                    layer.close(index);
                });
                return false;
            });
        },

        /**
         * 注册文件选中事件
         */
        selectFilesEvent: function () {
            // 绑定文件选中事件
            this.$element.find('#file-list-body').on('click', '.file-list-item li', function () {
                $(this).toggleClass('active');
            });
        },

        /**
         * 分类切换事件
         */
        switchClassEvent: function () {
            var _this = this;
            // 注册分类切换事件
            _this.$element.find('.file-group').on('click', 'li', function () {
                var $this = $(this);
                // 切换选中状态
                $this.addClass('active').siblings('.active').removeClass('active');
                // 重新渲染文件列表
                _this.renderFileList();
            });
        },

        /**
         * 注册分组下拉选择组件
         */
        selectDropdown: function () {
            this.$element.find('.group-select').dropdown();
        },

        /**
         * 获取文件库列表数据
         * @param params
         * @param success
         */
        getJsonData: function (params, success) {
            var loadIndex = layer.load();
            typeof params === 'function' && (success = params);
            // 获取文件库列表
            $.getJSON(STORE_URL + '/upload.library/fileList', params, function (result) {
                layer.close(loadIndex);
                if (result.code === 1) {
                    typeof success === 'function' && success(result.data);
                } else {
                    layer.msg(result.msg, {anim: 6});
                }
            });
        },

        /**
         * 重新渲染文件列表
         * @param page
         */
        renderFileList: function (page) {
            var _this = this
                , groupId = this.getCurrentGroupId();
            // 重新渲染文件列表
            _this.getJsonData({group_id: groupId, page: page || 1}, function (data) {
                _this.$element.find('#file-list-body').html(template('tpl-file-list', data.file_list));
            });
        },

        /**
         * 获取选中的文件列表
         * @returns {Array}
         */
        getSelectedFiles: function () {
            var selectedList = [];
            this.$element.find('.file-list-item > li.active').each(function (index) {
                var $this = $(this);
                selectedList[index] = {
                    file_id: $this.data('file-id')
                    , file_path: $this.data('file-path')
                };
            });
            return selectedList;
        },

        /**
         * 获取选中的文件的ID集
         * @returns {Array}
         */
        getSelectedFileIds: function () {
            var fileList = this.getSelectedFiles();
            var data = [];
            fileList.forEach(function (item) {
                data.push(item.file_id);
            });
            return data;
        },

        /**
         * 获取当前分组id
         * @returns {*}
         */
        getCurrentGroupId: function () {
            return this.$element.find('.file-group > ul > li.active').data('group-id');
        },

        /**
         * 确认回调
         */
        done: function () {
            var selectedList = this.getSelectedFiles();
            selectedList.length > 0 && typeof this.options.done === 'function'
            && this.options.done(selectedList, this.$touch);
        }

    };

    // 在Jquery插件中使用FileLibrary对象
    $.fn.fileLibrary = function (options) {
        new FileLibrary(this, options);
    };

})(jQuery, window, document);

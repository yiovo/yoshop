/**
 * jquery全局函数封装
 */
(function ($) {
    /**
     * Jquery类方法
     */
    $.fn.extend({
        superForm: function (option) {
            // 默认选项
            var defaultOption = {
                buildData: function () {
                    return {};
                },
                validation: function () {
                    return true;
                }
            };
            option = $.extend(true, {}, defaultOption, option);

            var $form = $(this)
                , btn_submit = $('.j-submit');
            $form.validator({
                onValid: function (validity) {
                    $(validity.field).next('.am-alert').hide();
                },
                /**
                 * 显示错误信息
                 * @param validity
                 */
                onInValid: function (validity) {
                    var $field = $(validity.field)
                        , $group = $field.parent()
                        , $alert = $group.find('.am-alert');

                    if ($field.data('validationMessage') !== undefined) {
                        // 使用自定义的提示信息 或 插件内置的提示信息
                        var msg = $field.data('validationMessage') || this.getValidationMessage(validity);
                        if (!$alert.length) {
                            $alert = $('<div class="am-alert am-alert-danger"></div>').hide().appendTo($group);
                        }
                        $alert.html(msg).show();
                    }
                },
                submit: function () {
                    if (this.isFormValid() === true) {
                        // 自定义验证
                        if (!option.validation())
                            return false;
                        // 禁用按钮, 防止二次提交
                        btn_submit.attr('disabled', true);
                        // 表单提交
                        $form.ajaxSubmit({
                            type: "post",
                            dataType: "json",
                            data: option.buildData(),
                            success: function (result) {
                                result.code === 1 ? $.show_success(result.msg, result.url)
                                    : $.show_error(result.msg);
                                btn_submit.attr('disabled', false);
                            }
                        });
                    }
                    return false;
                }
            });
        },

        /**
         * 删除元素
         */
        delete: function (index, url) {
            $(this).click(function () {
                var param = {};
                param[index] = $(this).attr('data-id');
                layer.confirm('确定要删除吗？', function (index) {
                    $.post(url, param, function (result) {
                        result.code === 1 ? $.show_success(result.msg, result.url)
                            : $.show_error(result.msg);
                    });
                    layer.close(index);
                });
            });
        },

        /**
         * 选择图片文件
         * @param option
         */
        selectImages: function (option) {
            var $this = this
                // 配置项
                , defaults = {
                    name: ''            // input name
                    , imagesList: '.uploader-list'    // 图片列表容器
                    , imageDelete: '.file-item-delete'   // 删除按钮元素
                    , multiple: false    // 是否多选
                    , done: null  // 选择完成后的回调函数
                }
                , options = $.extend({}, defaults, option);
            // 显示文件库 选择文件
            $this.fileLibrary({
                type: 'image'
                , done: function (data, $touch) {
                    var list = options.multiple ? data : [data[0]];
                    // 判断回调参数是否存在, 否则执行默认
                    if (typeof options.done === 'function') {
                        return options.done(data, $touch);
                    }
                    // 新增图片列表
                    var $html = $(template('tpl-file-item', {list: list, name: options.name}))
                        , $imagesList = $this.next(options.imagesList);
                    // 注册删除事件
                    $html.find(options.imageDelete).click(function () {
                        $(this).parent().remove();
                    });
                    // 渲染html
                    options.multiple ? $imagesList.append($html) : $imagesList.html($html);
                }
            });
        }

    });

    /**
     * Jquery全局函数
     */
    $.extend({
        /**
         * 操作成功弹框提示
         * @param msg
         * @param url
         */
        show_success: function (msg, url) {
            layer.msg(msg, {
                icon: 1
                , time: 1800
                // , anim: 1
                , shade: 0.5
                , end: function () {
                    url === undefined ? window.location.reload() : window.location = url;
                }
            });
        },

        /**
         * 操作失败弹框提示
         * @param msg
         * @param reload
         */
        show_error: function (msg, reload) {
            var time = reload ? 1800 : 0;
            layer.alert(msg, {
                title: '提示'
                , icon: 2
                , time: time
                , anim: 6
                , end: function () {
                    reload && window.location.reload();
                }
            });
        },

        /**
         * 文件上传 (单文件)
         * 支持同一页面多个上传元素
         *  $.uploadImage({
         *   pick: '.upload-file',  // 上传按钮
         *   list: '.uploader-list' // 缩略图容器
         * });
         */
        uploadImage: function (option) {
            // 文件大小
            var maxSize = option.maxSize !== undefined ? option.maxSize : 2
                // 初始化Web Uploader
                , uploader = WebUploader.create({
                    // 选完文件后，是否自动上传。
                    auto: true,
                    // 允许重复上传
                    duplicate: true,
                    // 文件接收服务端。
                    server: STORE_URL + '/upload/image',
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
                    },
                    // 文件上传header扩展
                    headers: {
                        'Accept': 'application/json, text/javascript, */*; q=0.01',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
            //  验证大小
            uploader.on('error', function (type) {
                // console.log(type);
                if (type === "F_DUPLICATE") {
                    // console.log("请不要重复选择文件！");
                } else if (type === "F_EXCEED_SIZE") {
                    alert("文件大小不可超过" + maxSize + "m 哦！换个小点的文件吧！");
                }
            });

            // 当有文件添加进来的时候
            uploader.on('fileQueued', function (file) {
                var $uploadFile = $('#rt_' + file.source.ruid).parent()
                    , $list = $uploadFile.next(option.list)
                    , $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '<input type="hidden" name="' + $uploadFile.data('name') + '" value="">' +
                    '<i class="iconfont icon-shanchu file-item-delete"></i>' +
                    '</div>'
                    ),
                    $img = $li.find('img'),
                    $delete = $li.find('.file-item-delete');
                // 删除文件
                $delete.on('click', function () {
                    uploader.removeFile(file);
                    $delete.parent().remove();
                });
                // $list为容器jQuery实例
                $list.empty().append($li);
                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
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
                    var $item = $('#' + file.id);
                    $item.addClass('upload-state-done')
                        .children('input[type=hidden]').val(response.data.path);
                } else
                    uploader.uploadError(file);
            });
            // 文件上传失败
            uploader.on('uploadError', function (file) {
                uploader.uploadError(file);
            });
            // 显示上传出错信息
            uploader.uploadError = function (file) {
                var $li = $('#' + file.id),
                    $error = $li.find('div.error');
                // 避免重复创建
                if (!$error.length) {
                    $error = $('<div class="error"></div>').appendTo($li);
                }
                $error.text('上传失败');
            };
        }

    });

})(jQuery);

/**
 * app.js
 */
$(function () {

    /**
     * 点击侧边开关 (一级)
     */
    $('.switch-button').on('click', function () {
        var header = $('.tpl-header'), wrapper = $('.tpl-content-wrapper'), leftSidebar = $('.left-sidebar');
        if (leftSidebar.css('left') !== "0px") {
            header.removeClass('active') && wrapper.removeClass('active') && leftSidebar.css('left', 0);
        } else {
            header.addClass('active') && wrapper.addClass('active') && leftSidebar.css('left', -280);
        }
    });

    /**
     * 侧边栏开关 (二级)
     */
    $('.sidebar-nav-sub-title').click(function () {
        $(this).toggleClass('active');
    });

    // 刷新按钮
    $('.refresh-button').click(function () {
        window.location.reload();
    });

    // 删除图片 (数据库已有的)
    $('.file-item-delete').click(function () {
        var _this = this;
        layer.confirm('您确定要删除该图片吗？', {
            title: '友情提示'
        }, function (index) {
            $(_this).parent().remove();
            layer.close(index);
        });
    });

});

//******* 地区选择插件 *******//
(function () {

    /***
     * 地区选择插件
     * @param container
     * @param datas
     * @constructor
     */
    function RegionalChoice(container, datas) {
        this.container = container;
        this.datas = datas;
        this.initInterface();  // 初始化地域界面
    }

    RegionalChoice.prototype = {

        /**
         * 条件渲染
         * @param alreadyIds 已存在的区域ID: 用于新增
         * @param checkedIds 已选中的区域ID: 用于编辑
         * @param
         */
        render: function (alreadyIds, checkedIds) {
            alreadyIds = alreadyIds || [];
            alreadyIds.length > 0 && this.setAlready(alreadyIds);
            checkedIds = checkedIds || [];
            checkedIds.length > 0 && this.setChecked(checkedIds);
        },

        /**
         * 初始化地域界面
         */
        initInterface: function () {
            var _this = this;
            $(_this.container).append(
                $('<div/>', {
                    class: 'place-div'
                }).append(
                    $('<div/>', {}).append(
                        $('<div/>', {
                            class: 'checkbtn'
                        })
                            .append(
                                $('<label/>', {})
                                // 全选框
                                    .append(
                                        $('<input/>', {
                                            type: 'checkbox',
                                            change: function () {
                                                var checked = $(this).is(':checked'),
                                                    $allCheckbox = $('.place').find('input[type=checkbox]');
                                                $('.ratio').html('');
                                                $allCheckbox.prop('checked', checked);
                                            }
                                        })
                                    )
                                    .append(' 全国')
                            )
                            .append(
                                $('<a/>', {
                                    class: 'clearCheck',
                                    text: '清空',
                                    click: function () {
                                        _this.destroy();
                                    }
                                })
                            )
                    ).append(
                        // 省份
                        $('<div/>', {
                            class: 'place clearfloat'
                        }).append(function () {
                            return _this.getSmallPlace();
                        }())
                    )
                )
            );

        },

        /**
         * 遍历省份
         * @returns {jQuery}
         * @constructor
         */
        getSmallPlace: function () {
            var _this = this;
            return $('<div/>', {
                class: 'smallplace clearfloat'
            }).append(
                $.map(_this.datas, function (item) {
                    return $('<div/>', {
                        class: 'place-tooltips'
                    })
                        .append(
                            $('<label/>', {})
                                .append(
                                    $('<input/>', {
                                        id: item.id,
                                        type: 'checkbox',
                                        class: 'province',
                                        change: function () {
                                            var $this = $(this)
                                                , small = $this.parent().next('.citys').find('input')
                                                , $placeTooltips = $this.parents('.place-tooltips');
                                            if ($this.prop('checked')) {
                                                small.prop('checked', true);
                                                $placeTooltips.find('.ratio').html('(' + small.length + '/' + small.length + ')');
                                            } else {
                                                small.prop('checked', false);
                                                $placeTooltips.find('.ratio').html('');
                                            }

                                        }
                                    })
                                )
                                .append(
                                    // 省份名称
                                    $('<span/>', {
                                        class: 'province_name',
                                        text: item.name
                                    })
                                )
                                .append(function () {
                                    // 城市数量
                                    if (item.city) {
                                        return $('<span/>', {
                                            class: 'ratio'
                                        })
                                    }
                                })
                        ).append(function () {
                            // 城市列表
                            if (item.city) {
                                return $('<div/>', {
                                    class: 'citys'
                                }).append(
                                    $('<i/>', {
                                        class: 'jt'
                                    }).append($('<i/>', {}))
                                ).append(
                                    _this.getSmallCitys(item.city)
                                )
                            }
                        })
                })
            )
        },

        /**
         * 遍历城市
         * @param datas
         * @returns {jQuery}
         * @constructor
         */
        getSmallCitys: function (datas) {
            return $('<div/>', {
                class: 'row-div clearfloat'
            }).append(
                $.map(datas, function (item) {
                    return $('<p/>', {}).append(
                        $('<label/>', {}).append(
                            $('<input/>', {
                                id: item.id,
                                type: 'checkbox',
                                name: 'city[]',
                                class: 'city',
                                change: function () {
                                    var $citys = $(this).parents('.citys')
                                        , $placeTooltips = $(this).parents('.place-tooltips')
                                        , tf = $citys.find('input:checked').length
                                        , $province = $placeTooltips.find('.province')
                                        , $ratio = $placeTooltips.find('.ratio');
                                    if (tf > 0) {
                                        $province.prop('checked', true);
                                        $ratio.html('(' + tf + '/' + $citys.find('input').length + ')');
                                    } else if (tf === 0) {
                                        $province.prop('checked', false);
                                        $ratio.html('');
                                    }
                                }
                            })
                        ).append(
                            $('<span/>', {
                                text: item.name
                            })
                        )
                    )
                })
            )
        },

        /**
         * 获取已选中的省市id
         * @returns {array}
         * @constructor
         */
        getCheckedIds: function () {
            var checkedIds = [];
            $('input[type=checkbox][name="city[]"]:checked').each(function (index, item) {
                checkedIds.push(item.id);
            });
            return checkedIds;
        },

        /**
         * 获取已选中的省市id (树状)
         * @returns {Array}
         */
        getCheckedTree: function () {
            var _this = this;
            // 遍历省份
            var data = [];
            $('input.province:checked').each(function (index, province) {
                var $this = $(this)
                    , $citys = $this.parent().next()
                    , $cityInputChecked = $citys.find('input.city:checked')
                    , cityData = []
                    , cityTotal = Object.keys(_this.datas[province.id].city).length;
                // 遍历城市
                if (cityTotal !== $cityInputChecked.length) {
                    $cityInputChecked.each(function (index, item) {
                        cityData.push({id: item.id, name: $(this).next().text()});
                    });
                }
                data.push({
                    id: province.id,
                    name: $this.next().text(),
                    city: cityData
                });
            });
            return data;
        },

        /**
         * 获取已选中地区内容
         * @returns {{content: string, checkedIds: *|Array}}
         */
        getCheckedContent: function () {
            // 获取已选中的省市id
            var dataTree = this.getCheckedTree()
                , checkedIds = this.getCheckedIds()
                , content = '';
            if (checkedIds.length === 373) {
                content = '全国';
            } else {
                var str = '';
                dataTree.forEach(function (item) {
                    str += item.name;
                    if (item.city.length > 0) {
                        var cityStr = '';
                        item.city.forEach(function (city) {
                            cityStr += city.name + '、';
                        });
                        str += ' (<span class="am-link-muted">'
                            + cityStr.substring(0, cityStr.length - 1) + '</span>)';
                    }
                    str += '、';
                });
                content = str.substring(0, str.length - 1);
            }
            return {
                content: content,
                ids: checkedIds
            };
        },

        /**
         * 批量选中
         * @param checkedIds 已选中的区域ID: 用于编辑
         * @constructor
         */
        setChecked: function (checkedIds) {
            var $place = $('.place-div');
            $.each(checkedIds, function (i, id) {
                $place.find('#' + id).trigger('click');
            });
        },

        /**
         * 批量删除已存在的区域
         * @param alreadyIds 已存在的区域ID: 用于新增
         * @constructor
         */
        setAlready: function (alreadyIds) {
            var $place = $('.place-div');
            $.each(alreadyIds, function (i, id) {
                var $p = $place.find('#' + id).parent().parent()
                    , $siblings = $p.siblings();
                $siblings.length > 0 ? $p.remove() : $p.closest('.place-tooltips').remove();
            });
        },

        /**
         * 清空
         */
        destroy: function () {
            var $place = $('.place-div');
            $place.find('input[type=checkbox]').prop('checked', false);
            $place.find('.ratio').html('');
        }

    };

    window.RegionalChoice = RegionalChoice;

})(window);




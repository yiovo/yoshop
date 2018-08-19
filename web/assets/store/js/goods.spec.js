(function () {

    // 商品规格数据
    var data = {
            spec_attr: [],
            spec_list: []
        }

        // 配置信息
        , setting = {
            container: '.goods-spec-many'
        };

    function GoodsSpec(options, baseData) {
        // 配置信息
        setting = $.extend(true, {}, setting, options);
        // 已存在的规格数据
        typeof baseData !== 'undefined' && baseData !== null && (data = baseData);
        // 初始化
        this.initialize();
    }

    GoodsSpec.prototype = {
        /**
         * 初始化
         */
        initialize: function () {
            // 注册html容器
            this.$container = $(setting.container);
            this.$specAttr = this.$container.find('.spec-attr');
            // 显示添加规则组表单事件
            this.showAddSpecGroupEvent();
            // 确认新增规则组事件
            this.submitAddSpecGroupEvent();
            // 取消新增规则组事件
            this.cancelAddSpecGroupEvent();
            // 注册添加规格元素事件
            this.addSpecItemEvent();
            // 注册删除规则组事件
            this.deleteSpecGroupEvent();
            // 注册删除规则元素事件
            this.deleteSpecItemEvent();
            // 注册批量设置sku事件
            this.batchUpdateSku();
            // 注册表格input数据修改事件
            this.updateSpecInputEvent();
            // 渲染已存在的sku信息
            this.renderHtml();
        },

        /**
         * 显示添加规则组表单
         */
        showAddSpecGroupEvent: function () {
            // 显示添加规则组表单
            this.$container.on('click', '.btn-addSpecGroup', function () {
                var $specGroupButton = $(this).parent()
                    , $specGroupAdd = $specGroupButton.next();
                $specGroupButton.hide();
                $specGroupAdd.show();
            });
        },

        /**
         * 确认新增规则组
         */
        submitAddSpecGroupEvent: function () {
            var _this = this;
            // 确认添加
            _this.$container.on('click', '.btn-addSpecName', function () {
                var $specGroupAdd = $(this).parent().parent()
                    , $specGroupButton = $specGroupAdd.prev()
                    , $specNameInput = _this.$container.find('.input-specName')
                    , $specValueInput = _this.$container.find('.input-specValue')
                    , specValueInputValue = $specValueInput.val()
                    , specNameInputValue = $specNameInput.val();
                if (specNameInputValue === '' || specValueInputValue === '') {
                    layer.msg('请填写规则名或规则值');
                    return false;
                }
                // 添加到数据库
                var load = layer.load();
                $.post(STORE_URL + '/goods.spec/addSpec', {
                    spec_name: specNameInputValue,
                    spec_value: specValueInputValue
                }, function (result) {
                    layer.close(load);
                    if (result.code !== 1) {
                        layer.msg(result.msg);
                        return false;
                    }
                    // 清空输入内容
                    $specNameInput.val('') && $specValueInput.val('');
                    // 记录规格数据
                    data.spec_attr.push({
                        group_id: result.data.spec_id,
                        group_name: specNameInputValue,
                        spec_items: [{
                            item_id: result.data.spec_value_id,
                            spec_value: specValueInputValue
                        }]
                    });
                    // 渲染规格属性html
                    _this.renderHtml();
                    // 隐藏添加规格组表单
                    $specGroupAdd.hide() && $specGroupButton.show();
                });

            });
        },

        /**
         * 取消新增规格组
         */
        cancelAddSpecGroupEvent: function () {
            this.$container.on('click', '.btn-cancleAddSpecName', function () {
                var $specGroupAdd = $(this).parent().parent()
                    , $specGroupButton = $specGroupAdd.prev();
                // 隐藏添加规格组表单
                $specGroupAdd.hide() && $specGroupButton.show()
            });
        },

        /**
         * 添加规则元素事件
         */
        addSpecItemEvent: function () {
            var _this = this;
            _this.$container.on('click', '.btn-addSpecItem', function () {
                var $this = $(this)
                    , $iptSpecItem = $this.prev('.ipt-specItem')
                    , specItemInputValue = $iptSpecItem.val()
                    , $specItemAddContainer = $this.parent()
                    , $specGroup = $specItemAddContainer.parent().parent();
                if (specItemInputValue === '') {
                    layer.msg('规格值不能为空');
                    return false;
                }
                // 添加到数据库
                var load = layer.load();
                $.post(STORE_URL + '/goods.spec/addSpecValue', {
                    spec_id: $specGroup.data('group-id'),
                    spec_value: specItemInputValue
                }, function (result) {
                    layer.close(load);
                    if (result.code !== 1) {
                        layer.msg(result.msg);
                        return false;
                    }
                    // 记录规格数据
                    data.spec_attr[$specGroup.data('index')].spec_items.push({
                        item_id: result.data.spec_value_id,
                        spec_value: specItemInputValue
                    });
                    // 渲染规格属性html
                    _this.renderHtml();
                });
            });
        },

        /**
         * 删除规则组事件
         */
        deleteSpecGroupEvent: function () {
            var _this = this;
            _this.$container.on('click', '.spec-group-delete', function () {
                // 规则组索引
                var index = $(this).parent().parent().attr('data-index');
                layer.confirm('确定要删除该规则组吗？确认后不可恢复请谨慎操作', function (layerIndex) {
                    // 删除指定规则组
                    data.spec_attr.splice(index, 1);
                    // 重新渲染规格属性html
                    _this.renderHtml();
                    layer.close(layerIndex);
                });
            });
        },

        /**
         * 删除规则组事件
         */
        deleteSpecItemEvent: function () {
            var _this = this;
            _this.$container.on('click', '.spec-item-delete', function () {
                var $item = $(this).parent()
                    , $specGroup = $item.parent().parent()
                    , groupIndex = $specGroup.attr('data-index')
                    , itemIndex = $item.attr('data-item-index');
                layer.confirm('确定要删除该规则吗？确认后不可恢复请谨慎操作', function (layerIndex) {
                    // 删除指定规则组
                    data.spec_attr[groupIndex].spec_items.splice(itemIndex, 1);
                    // 重新渲染规格属性html
                    _this.renderHtml();
                    layer.close(layerIndex);
                });
            });
        },

        /**
         * 注册批量设置sku事件
         */
        batchUpdateSku: function () {
            var _this = this,
                $specBatch = _this.$container.find('.spec-batch');
            $specBatch.on('click', '.btn-specBatchBtn', function () {
                var formData = {};
                $specBatch.find('input').each(function () {
                    var $this = $(this)
                        , formType = $this.data('type')
                        , value = $this.val();
                    if (typeof formType !== 'undefined' && formType !== '' && value !== '') {
                        formData[formType] = value;
                    }
                });
                if (!$.isEmptyObject(formData)) {
                    data.spec_list.forEach(function (item, index) {
                        data.spec_list[index].form = $.extend({}, data.spec_list[index].form, formData);
                    });
                    // 渲染商品规格table
                    _this.renderTabelHtml();
                }
            });
        },

        /**
         * 渲染多规格模块html
         */
        renderHtml: function () {
            // 渲染商品规格元素
            this.$specAttr.html(template('tpl_spec_attr', data));
            // 渲染商品规格table
            this.renderTabelHtml();
        },

        /**
         * 渲染表格html
         */
        renderTabelHtml: function () {
            var $specTabel = this.$container.find('.spec-sku-tabel')
                , $goodsSku = $specTabel.parent();
            // 商品规格为空：隐藏sku容器
            if (data.spec_attr.length === 0) {
                $specTabel.empty();
                $goodsSku.hide();
                return false;
            }
            // 构建规格组合列表
            this.buildSpeclist();
            // 渲染table
            $specTabel.html(template('tpl_spec_table', data));
            // 显示sku容器
            $goodsSku.show();
        },

        /**
         * 构建规格组合列表
         */
        buildSpeclist: function () {
            // 规格组合总数 (table行数)
            var totalRow = 1;
            for (var i = 0; i < data.spec_attr.length; i++) {
                totalRow *= data.spec_attr[i].spec_items.length;
            }
            // 遍历tr 行
            var spec_list = [];
            for (i = 0; i < totalRow; i++) {
                var rowData = [], rowCount = 1, specSkuIdAttr = [];
                // 遍历td 列
                for (var j = 0; j < data.spec_attr.length; j++) {
                    var skuValues = data.spec_attr[j].spec_items;
                    rowCount *= skuValues.length;
                    var anInterBankNum = (totalRow / rowCount)
                        , point = ((i / anInterBankNum) % skuValues.length);
                    if (0 === (i % anInterBankNum)) {
                        rowData.push({
                            rowspan: anInterBankNum,
                            item_id: skuValues[point].item_id,
                            spec_value: skuValues[point].spec_value
                        });
                    }
                    specSkuIdAttr.push(skuValues[parseInt(point.toString())].item_id);
                }
                spec_list.push({
                    spec_sku_id: specSkuIdAttr.join('_'),
                    rows: rowData,
                    form: {}
                });
            }
            // 合并旧sku数据
            if (data.spec_list.length > 0 && spec_list.length > 0) {
                for (i = 0; i < spec_list.length; i++) {
                    var overlap = data.spec_list.filter(function (val) {
                        return val.spec_sku_id === spec_list[i].spec_sku_id;
                    });
                    if (overlap.length > 0) spec_list[i].form = overlap[0].form;
                }
            }
            data.spec_list = spec_list;
        },

        /**
         * 输入规格信息自动同步更新spec_list
         */
        updateSpecInputEvent: function () {
            var _this = this;
            _this.$container.find('.spec-sku-tabel').on('propertychange change', 'input', function () {
                var $this = $(this)
                    , dataType = $this.attr('name')
                    , specIndex = $this.parent().parent().data('index');
                data.spec_list[specIndex].form[dataType] = $this.val();
            });
        },

        /**
         * 获取当前data
         */
        getData: function () {
            return data;
        },

        /**
         * sku列表是否为空
         * @returns {boolean}
         */
        isEmptySkuList: function () {
            return !data.spec_list.length;
        }

    };

    window.GoodsSpec = GoodsSpec;

})();


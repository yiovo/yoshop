(function () {
    // 'use strict'

    let settings = {};

    /***
     * 商品多规格交互
     * @param options
     * @constructor
     */
    function GoodsSpec(options) {
        // 配置信息
        settings = $.extend(true, {}, {container: '.goods-spec-many'}, options);

        // 初始化
        this.initialize();
    }

    GoodsSpec.prototype = {

        /**
         * 初始化
         */
        initialize: function () {
            // 添加规则组
            this.addSpecGroupEvent();
        },

        /**
         * 添加规则组
         */
        addSpecGroupEvent: function () {
            // 添加规则名称
            $('#btn-addspecName').click(function () {
                let $specName = $('.input-spec-name');
                console.log(
                    $specName.val()
                );
            });



        },

    };

    window.GoodsSpec = GoodsSpec;

})(window);

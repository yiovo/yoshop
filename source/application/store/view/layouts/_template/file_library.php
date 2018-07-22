<script id="tpl-file-library" type="text/template">
    <div class="row">
        <div class="file-group">
            <ul class="nav-new">
                <li class="ng-scope {{ active_group_id === -1 ? 'active' : '' }}" data-group-id="-1">
                    <a class="group-name am-text-truncate" href="javascript:void(0);" title="全部">全部</a>
                </li>
                <li class="ng-scope {{ active_group_id === 0 ? 'active' : '' }}" data-group-id="0">
                    <a class="group-name am-text-truncate" href="javascript:void(0);" title="未分组">未分组</a>
                </li>
            </ul>
            <ul id="file-group-item" class="nav-new">
                {{ include 'tpl-file-group-item' file_group }}
            </ul>
            <a class="file-group-add" href="javascript:void(0);">新增分组</a>
        </div>
        <div class="file-list">
            <div class="v-box-header am-cf">
                <div class="h-left am-fl am-cf">
                    <div class="am-fl">
                        <select class="am-fl" name="goods[category_id]"
                                data-am-selected="{btnSize: 'sm',  placeholder:'移动至'}">
                            <option value=""></option>
                            {{ each file_group }}
                            <option value="{{ $value.group_id }}">{{ $value.group_name }}</option>
                            {{ /each }}
                        </select>
                    </div>
                    <div class="am-fl tpl-table-black-operation">
                        <a href="javascript:;" class="item-delete tpl-table-black-operation-del" data-id="2">
                            <i class="am-icon-trash"></i> 删除
                        </a>
                    </div>
                </div>
                <div class="h-rigth am-fr">
                    <button type="button" class="btn-addSpecGroup am-btn">
                        <i class="iconfont icon-add1"></i>
                        上传图片
                    </button>
                </div>
            </div>
            <div class="v-box-body">
                <ul id="file-item-box">
                    {{ include 'tpl-file-list' data }}
                </ul>
            </div>
            <div class="v-box-footer"></div>
        </div>
    </div>

</script>

<script id="tpl-file-list" type="text/template">
    {{ each $data.file_list }}
    <li class="ng-scope" title="{{ $value.file_name }}" data-file-id="{{ $value.file_id }}"
        data-file-path="{{ $value.file_path }}">
        <div class="img-cover"
             style="background-image: url('{{ $value.file_path }}')">
        </div>
        <p class="file-name am-text-center am-text-truncate">{{ $value.file_name }}</p>
        <div class="select-mask">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADcAAAAmCAYAAAEXVjPuAAAABGdBTUEAALGPC/xhBQAAAllJREFUaAXtmLFOwzAQhhskhg5IjMx0RvACSCyMzIwIFl6IgRVeAB6gL8DM1hkmusDIQPgv5CJz2M7ZsRtH4qSTHdv/ff6dJq06m8VEjZghd6S4meBB88Ls8zxVaKIb8HWw8tw6TyWaia7TLpPXDY/m/ky0AutExZPa1lndVYAEFL/mf4bEYLvCN9cVMReZ/W5BX4dEfWuC51FzP0Z01Vq4V4shYNF6mKhFL11VnCRMPLrEThFTbOJekU2sFlnE0Nb606MCEDwg37jYaC02wfcf3fo220YEiGBhR6bdmQqERbvIA21R2zoViIRYuECa4XxKBoGkGER+shjuBWOR+WEgTdw9gtALTgZSOH4mG0bEOZIgeQ2AdJwHJMFDrrHpa+Q8+Ms7FArIFzQNJyvMBNEms8EkCKwjAiYPAiHNOEwOoYIgFATCbk6H2lQ5wqJ3JMc8Bgqx7uiYYrRBQDWovaHbBoi7KmAQiI8MomBgFCgGOAgUAkwC0gCTgnqAuo83Fwlp4cL2ocFwE+nfdShrA6YH8SkIYD4QA0tvcSAXyE8kxwqdvdL37d0fDNBvZ/mgsMEnr7jUyR5TZG6NXJS6f+u+lKam9Zz+m7Le6wIHk94pFDtDfiA56H8l1W+8lGcDpu/tR3ujF4X+mcLiY1I5Yonx7CbBSGvKPHEUv3OY4+EsJrOaEgbpd5b8V4TNcZvE5MZMmQapD3A2k6OZymmyGFMpTRZraojJyZiKNAl/1gj7npLwTV1j65oXDzuchil5eD0mRzWV7J9lmNyC8UvkCfIVeVNV1Qva0eIbDsLBOpJ6XroAAAAASUVORK5CYII=">
        </div>
    </li>
    {{ /each }}
</script>

<script id="tpl-file-group-item" type="text/template">
    {{ each $data }}
    <li class="ng-scope {{ active_group_id === $value.group_id ? 'active' : '' }}"
        data-group-id="{{ $value.group_id }}" title="{{ $value.group_name }}">
        <a class="group-edit" href="javascript:void(0);" title="编辑分组">
            <i class="iconfont icon-bianji"></i>
        </a>
        <a class="group-name am-text-truncate" href="javascript:void(0);">
            {{ $value.group_name }}
        </a>
        <a class="group-delete" href="javascript:void(0);" title="删除分组">
            <i class="iconfont icon-shanchu1"></i>
        </a>
    </li>
    {{ /each }}
</script>


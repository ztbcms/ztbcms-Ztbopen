<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap" id="app">
    <Admintemplate file="Common/Nav"/>
    <div class="h_a">模版详情</div>
    <div class="table_full">
        <table cellpadding=0 cellspacing=0 width="100%" class="table_form">
            <tr>
                <th width="140">标题:</th>
                <td><input v-model="title" placeholder="请输入标题" type="text" class="input" size="40"></td>
            </tr>
            <tr>
                <th width="140">英文名:</th>
                <td><input v-model="name" placeholder="请输入英文名" type="text" class="input" size="40"></td>
            </tr>
            <tr>
                <th width="140">模板ID:</th>
                <td><input v-model="template_id" placeholder="请输入模板ID" type="text" class="input" size="40"></td>
            </tr>
            <tr>
                <th width="140">描述:</th>
                <td><textarea v-model="description" cols="30" rows="10" placeholder="请输入描述"></textarea></td>
            </tr>
        </table>
    </div>
    <div class="btn_wrap">
        <div class="btn_wrap_pd">
            <button @click="submitBtnEvent" class="btn btn_submit mr10">提交</button>
            <button @click="closeBtnEvent" class="btn btn-default  mr10">关闭</button>
        </div>
    </div>
</div>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script type="text/javascript">
    $(function () {
        new Vue({
            el: '#app',
            mixins: [window.__vueCommon],
            data: {
                id: '{:I("get.id", 0)}',
                app_id: '{:I("get.app_id", 0)}',
                name: '',
                title: '',
                template_id: '',
                description: '',
            },
            methods: {
                closeBtnEvent:function () {
                    window.parent.layer.closeAll();
                },
                submitBtnEvent: function () {
                    var data = {
                        id: this.id,
                        app_id: this.app_id,
                        name: this.name,
                        title: this.title,
                        template_id: this.template_id,
                        description: this.description,
                    };
                    this.httpPost('{:U("addEditTemplate")}', data, function (res) {
                        console.log(res);
                        if (res.status) {
                            layer.msg(res.msg);
                            setTimeout(function () {
                                window.parent.location.reload();
                            }, 1000)
                        } else {
                            layer.msg(res.msg);
                        }
                    });
                    console.log('submit');
                },
                getDetail: function () {
                    var that = this;
                    this.httpGet('{:U("getTemplate")}', {id: this.id, app_id: this.app_id}, function (res) {
                        console.log(res);
                        if (res.status) {
                            var data = res.data;
                            that.name = data.name;
                            that.title = data.title;
                            that.template_id = data.template_id;
                            that.description = data.description;
                        } else {
                            layer.msg(res.msg);
                            setTimeout(function () {
                                window.parent.location.reload();
                            }, 1000)
                        }
                    })
                }
            },
            mounted: function () {
                if (this.id != '0') {
                    this.getDetail();
                }
            }
        });
    })
</script>
</body>
</html>

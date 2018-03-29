<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap" id="app">
    <Admintemplate file="Common/Nav"/>
    <div class="h_a">应用信息</div>
    <div class="table_full">
        <table cellpadding=0 cellspacing=0 width="100%" class="table_form">
            <tr>
                <th width="140">应用名称:</th>
                <td><input v-model="name" placeholder="请输入应用名称" type="text" class="input" size="40"></td>
            </tr>
            <tr>
                <th width="140">app_id:</th>
                <td><input v-model="app_id" placeholder="请输入应用app_id" type="text" class="input" size="40"></td>
            </tr>
            <tr>
                <th width="140">app_secret:</th>
                <td><input v-model="app_secret" placeholder="请输入应用app_secret" type="text" class="input" size="40"></td>
            </tr>
            <tr>
                <th width="140">是否默认:</th>
                <td>
                    <label for="yes"><input id="yes" v-model="is_default" type="radio" value="1" name="is_default">
                        是</label>
                    <label for="no"><input id="yes" v-model="is_default" type="radio" value="0" name="is_default">
                        否</label>
                </td>
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
                id: 0,
                name: '',
                app_id: '',
                app_secret: '',
                is_default: 1,
            },
            methods: {
                closeBtnEvent:function () {
                    window.parent.layer.closeAll();
                },
                submitBtnEvent: function () {
                    var data = {
                        id: this.id,
                        name: this.name,
                        app_id: this.app_id,
                        app_secret: this.app_secret,
                        is_default: this.is_default
                    };
                    this.httpPost('{:U("createApplication")}', data, function (res) {
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
                getApplicationDetail: function () {
                    var that = this;
                    this.httpGet('{:U("getApplicationDetail")}', {id: this.id}, function (res) {
                        console.log(res);
                        if (res.status) {
                            var data = res.data;
                            that.name = data.name;
                            that.app_id = data.app_id;
                            that.app_secret = data.app_secret;
                            that.is_default = data.is_default;
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
                var id = this.getUrlQuery('id');
                if (id) {
                    //有id传入，获取该记录详情
                    this.id = id;
                    this.getApplicationDetail();
                }
                console.log(id);
            }
        });
    })
</script>
</body>
</html>

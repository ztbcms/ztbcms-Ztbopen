<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap" id="app">
    <div class="mb10">
        <a @click="createBtnEvent" href="javascript:void(0)" class="btn btn-default" title="添加内容"><span
                    class="add"></span>添加内容</a>
    </div>
    <div class="table_list">
        <table width="100%">
            <thead>
            <tr>
                <td align="center">应用名称</td>
                <td align="center">app_id</td>
                <td align="center">app_secret</td>
                <td align="center">是否默认</td>
                <td align="center">创建时间</td>
                <td align="center">更新时间</td>
                <td align="center">操作</td>
            </tr>
            </thead>
            <tbody>
            <template v-for="item in items">
                <tr>
                    <td align="center">{{ item.name }}</td>
                    <td align="center">{{ item.app_id }}</td>
                    <td align="center">{{ item.app_secret }}</td>
                    <td align="center">{{ item.is_default==1?'是':'否' }}</td>
                    <td align="center">{{ item.create_time | getFormatDatetime }}</td>
                    <td align="center">{{ item.update_time | getFormatDatetime }}</td>
                    <td align="center">
                        <a :href="'{:U('Ztbopen/Ztbopen/templateList')}&app_id='+item.app_id" class="btn btn-primary">模版消息</a>
                        <a href="javascript:;" @click="editBtnEvent(item.id)" class="btn btn-primary">编辑</a>
                        <a href="javascript:;" @click="deleteBtnEvent(item.id)" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
    <div>
        <v-page @update="getLists" :page="page" :page_count="total_pages"></v-page>
    </div>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<Admintemplate file="Ztbopen/Common/vPageComponnet"/>
<script>
    $(function () {
        new Vue({
            data: {
                items: [],
                page: 1,
                limit: 20,
                total_pages: 0,
            },
            el: '#app',
            methods: {
                deleteBtnEvent: function (id) {
                    var that = this;
                    layer.confirm('是否确定删除', {}, function (res) {
                        console.log(id);
                        that.httpPost('{:U("deleteApplication")}', {id: id}, function (res) {
                            console.log(res);
                            if (res.status) {
                                location.reload();
                            } else {
                                layer.msg(res.msg);
                            }
                        })
                    });
                },
                editBtnEvent: function (id) {
                    console.log(id);
                    layer.open({
                        type: 2,
                        title: '编辑应用',
                        shade: false,
                        area: ['800px', '500px;'],
                        content: "{:U('createApplication')}&id=" + id,
                    });
                },
                createBtnEvent: function () {
                    layer.open({
                        type: 2,
                        title: '新增应用',
                        shade: false,
                        area: ['800px', '500px;'],
                        content: "{:U('createApplication')}",
                    });
                },
                getLists: function () {
                    var that = this;

                    this.httpGet("{:U('getApplications')}", {page: this.page, limit: this.limit}, function (res) {
                        console.log(res);
                        if (res.status) {
                            that.items = res.data.items;
                            that.page = res.data.page;
                            that.limit = res.data.limit;
                            that.total_pages = res.data.total_pages;
                        }
                    })
                }
            },
            mounted: function () {
                console.log('xxx');
                this.getLists();
            }, components: {
                'v-page': pageComponent
            }
        })
    });
</script>
</body>
</html>

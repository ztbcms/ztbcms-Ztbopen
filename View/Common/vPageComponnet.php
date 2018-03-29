<!-- 分页组件  -->
<script type="text/x-template" id="__vPage">
    <div class="col-sm-12">
        <div class="dataTables_paginate paging_simple_numbers">
            <button class="btn btn-primary" @click="preBtn">上一页</button>
            <div style="display: inline; font-size: 16px; margin-left: 10px; margin-right: 10px;">
                <span>{{page}}</span> / <span>{{page_count}}</span></div>
            <button class="btn btn-primary" @click="nextBtn">下一页</button>
            <input type="text" v-model="goPage" placeholder="跳转页码" class="form-control input-sm"
                   style="width: 70px; display: inline;">
            <button @click="goPageBtn" class="btn btn-primary">GO</button>
        </div>
    </div>
</script>

<script>
    var pageComponent = {
        props: ['page', 'page_count'],
        template: '#__vPage',
        data: function () {
            return {goPage: 1}
        },
        methods: {
            updateList: function () {
                var that = this;
                var load = layer.load(1);
                setTimeout(function () {
                    that.$emit('update');
                    layer.close(load);
                }, 300)
            },
            preBtn: function () {
                if (this.page > 1) {
                    this.$parent.page -= 1;
                    this.updateList();
                } else {
                    layer.msg('当前已经是第一页')
                }
            },
            nextBtn: function () {
                if (this.page < this.page_count) {
                    this.$parent.page = parseInt(this.page) + 1;
                    console.log(this.$parent.page);
                    this.updateList();
                } else {
                    layer.msg('当前已经是最后一页');
                }
            },
            goPageBtn: function () {
                if (this.goPage < 1 || this.goPage > this.page_count) {
                    layer.msg('超出页数范围');
                    this.goPage = 1;
                } else {
                    this.$parent.page = this.goPage;
                    this.updateList();
                }
            }
        }
    }
</script>
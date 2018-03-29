<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">

<div class="wrap J_check_wrap" id="app">
    <div class="h_a">发送模版消息</div>
    <form id="form" class="J_ajaxForm">
        <div class="table_full">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <th width="120px;"><strong>标题</strong></th>
                    <td>
                        {$data['title']}
                    </td>
                </tr>
                <tr>
                    <th  width="120px;"><strong>模板</strong></th>
                    <td>
                        <pre>{$data['description']}</pre>
                    </td>
                </tr>

                <tr>
                    <th><strong>发送参数</strong></th>
                    <td>
                        <div id="params"></div>
                    </td>
                </tr>
            </table>
            <div style="margin-top:1rem;">
                <a class="btn btn_submit mr10 J_ajax_submit_btn" href="javascript:;" onclick="doSend()">确认发送</a>
            </div>
        </div>
    </form>

</div>

<script>
    var description = '<?php echo str_replace(array("\r\n","\n","\r"),'',$data['description']);?>';
    console.log(description);
    var arr = description.match(/(?<={{)(.*?)(?=\.DATA}})/g);
    var html = '<table>';
    html += '<tr><td>openid</td><td><input type="text" class="input" name="openid" placeholder="openid"></td></tr>';
    for(var k in arr){
        html += '<tr><td>'+arr[k]+'</td><td>';
        html += '<input type="text" class="input" name="'+arr[k]+'" placeholder="'+arr[k]+'">';
        html += '</td></tr>';
    }
    html += '</table>';
    $('#params').append(html);

    function doSend(){
        var params = {};
        for(var k in arr){
            var tmp = arr[k];
            params[tmp] = $('[name="'+arr[k]+'"]').val()
        }
        var postData = {
            openid: $('[name="openid"]').val(),
            params: params,
            id: '{:I("id")}'
        };
        $.ajax({
            url: '{:U("Ztbopen/Ztbopen/doSend")}',
            data: postData,
            type: 'post',
            dataType: 'json',
            success: function(res){
                layer.msg(res.msg);
            }
        });
    }

</script>
</body>
</html>

 <?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/common.php';
$title = "Api接口";

include '../head.php';
?>
<div class="layui-fluid">
    <div class="layui-card">
    <div id="divLoading">
      <div class="layui-card-header"><?=$title;?></div>
<div class="layui-card-body layui-form">
    <form class="layui-form toolbar table-tool-mini">
        <div class="layui-form-item">
            <div class="layui-inline">
                <a class="layui-btn icon-layui-btn" id="staticBackdrop">
                    <i class="layui-icon layui-icon-add-1"></i>添加
                </a>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label w-auto">搜索:</label>
                <div class="layui-input-inline">
                    <input name="keywords" class="layui-input" type="text"  placeholder="输入搜索内容"/>
                </div>
            </div>
            <div class="layui-inline" style="padding-right: 110px;">
                <button class="layui-btn icon-layui-btn" lay-filter="roleTbSearch" lay-submit>
                    <i class="layui-icon">&#xe615;</i>搜索
                </button>
            </div>
        </div>
    </form>
</div>
<div id="add_form" style="display:none;">
<form class="layui-card-body layui-form" lay-filter="addjiekou">
<input type="hidden" name="id" id='id'>
<p>接口名称</p>
<input class="layui-input" type="text" id="name"  name="name" placeholder="不可为空">
<p>接口描述</p>
<input class="layui-input" type="text" id="desc"  name="desc" placeholder="不可为空">
<p>接口别名</p>
<input class="layui-input" type="text" id="alias"  name="alias"  placeholder="不可为空">
<p>fa图标</p>
<input class="layui-input" type="text" id="faimg"  name="faimg" placeholder="不可为空">
<p>接口地址</p>
<input class="layui-input" type="text" id="apiurl"  name="apiurl" placeholder="不可为空">
<p>请求实例</p>
<input class="layui-input" id="apirequest"  name="apirequest" placeholder="请输入内容" >
<p>接口价格</p>
<input class="layui-input" id="money"  name="money" placeholder="售卖价格" >
</textarea>
    <p>请求方式</p>
        <select class="form-select" id="request"  name="request">
              <option value="GET">GET</option>
              <option value="POST">POST</option>
        </select>
    <p>接口类型</p>
        <select class="form-select" id="apiformat"  name="apiformat">
              <option value="JSON">JSON</option>
              <option value="IMG">IMG</option>
              <option value="MUSIC">MUSIC</option>
              <option value="TXT">TXT</option>
        </select>
    <p>接口状态</p>
        <select class="form-select" id="status"  name="status">
              <option value="1">正常</option>
              <option value="0">停用</option>
        </select>
<div class="layui-form-item layui-form-text">
    
</div>
<div class="layui-form-item layui-form-text">
    <p>参数说明</p>
      <textarea id="explain"  name="explain" placeholder="请输入内容" class="layui-textarea"></textarea>
      <small class="help-block"><?=htmlspecialchars('<tr><td>名称</td><td>参数</td><td>是</td><td>无</td></tr>')?></small>
</div>  
<div class="layui-form-item layui-form-text">
    <p>返回数据</p>
      <textarea id="return"  name="return" placeholder="请输入内容" class="layui-textarea"></textarea>
</div>
<div class="layui-form-item layui-form-text">
    <p>调用实例</p>
      <textarea id="example"  name="example" placeholder="请输入内容" class="layui-textarea"></textarea>
</div>
<div class="layui-form-item layui-form-text">
    <p>调用演示</p>
      <textarea id="examples"  name="examples" placeholder="请输入内容" class="layui-textarea"></textarea>
</div>
<p>调用次数</p>
<input class="layui-input" type="text" id="views"  name="views" placeholder="默认为0" value="0">  
<div class="layui-form-item layui-form-text">
    <p>备注说明</p>
    <textarea id="remarks"  name="remarks" placeholder="请输入内容" rows="5" class="layui-textarea"></textarea>
</div>
</form>
</div>
    <table class="layui-hide" id="list" lay-filter="list"></table>

    <script id="table_button" type="text/html">
        <a lay-event="edit" class="layui-btn layui-btn-normal layui-btn-xs"><i class="layui-icon layui-icon-edit"></i>编辑</a>
        <a lay-event="del" class="layui-btn layui-btn-danger layui-btn-xs"><i class="layui-icon layui-icon-delete"></i>删除</a>
    </script>
<?php include '../foot.php';?>
<script>

     layui.use(['form', 'element', 'jquery', 'notice','layer'],
       function() {
           var form = layui.form;
           $ = layui.jquery,
           notice = layui.notice,
           layer = layui.layer;
           $("#staticBackdrop").click(function(){
               layer.open({
               type: 1,
               skin:'demo-class',
               btn: ['发布', '关闭'],
               closebtn:1,
               area:['50%','90%'],//宽度和高度 可以百分比 可以写死
               title:'增加API接口',
               content:$("#add_form") //这里content是一个普通的String
               ,yes: function(index, layero){
                //按钮【按钮一】的回调
                var data1 = form.val("addjiekou");
                $.ajax({
                url: '../ajax.php?act=ApiForm',
                type: 'POST',
                dataType: 'json',
                data: data1,
                success: function (data) {
                    if (data.code == 200) {
                        layer.msg(data.msg, {icon: 1, time: 2000, shade: 0.4}, function() {layer.closeAll();});
                    } else {
                        layer.msg(data.msg, {icon: 2, time: 2000, shade: 0.4});
                    }
                },
                error: function () {
                    layer.alert("网络连接错误,请稍后重试");
                }
            });
                return false;
                }
                ,btn2: function(index, layero){
                //按钮【按钮二】的回调
                layer.closeAll();
                //return false 开启该代码可禁止点击该按钮关闭
                }
               });
            })
       });

//获取数据
layui.use(['layer', 'notice','form','admin', 'table'],
function() {
	var $ = layui.jquery;
	var layer = layui.layer;
	var notice = layui.notice;
	var form = layui.form;
	var admin = layui.admin;
	var table = layui.table;
	var insTb = table.render({
        elem: "#list",
        url: "../ajax.php?act=ApiallInfo",
        page: true,
        limit: 10,
        text: {
			none: '哇哦没发现数据哟 T^T ！' //默认：无数据。注：该属性为 layui 2.2.5 开始新增
		},            		
		toolbar: ['<p>', '<button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del_table"><i class="layui-icon layui-icon-delete" style="font-size:20px;"></i>删除</button>&nbsp;', '</p>'].join(''),
        cellMinWidth: 100,
        cols: [
            [ //标题栏
        		{
        			type: 'checkbox'
        		},
                {
                    field: "id",
                    title: "ID",
                    sort: true
                },
                {
                    field: "name",
                    title: "接口名称",
                    sort: true
                },
                {
                    field: "faimg",
                    title: "图标",
                    sort: true
                },
                {
                    field: "money",
                    title: "价格",
                    sort: true
                },
                {
                    field: "request",
                    title: "接口类型",
                    sort: true
                },
                {
                    field: "views",
                    title: "调用次数",
                    sort: true
                },
                {
                    field: "times",
                    title: "更新时间",
                    sort: true
                },
				{
					field: 'status',
					title: '接口状态',
					templet: function(data) {
						if (data.status == 1) {
							return '<input type="checkbox" name="close" lay-skin="switch" value="' + data.id + '" lay-filter="ApiStatus" lay-text="正常|封禁" checked/>';
						} else {
							return '<input type="checkbox" name="close" lay-skin="switch" value="' + data.id + '" lay-filter="ApiStatus" lay-text="正常|封禁" >';
						}
					},
					sort: true
				},
               {
                    field: "action",
                    title: "其他操作",
                    toolbar: "#table_button",
                    width: 150
                }
            ]] 
	      });
	      //搜索
	      form.on('submit(roleTbSearch)',function(data) {
					var ii = layer.msg("正在查找数据……", {
						icon: 16
					});
					insTb.reload({
						where: data.field,
						page: {
							curr: 1
						}
					});
					layer.close(ii);
					return false;
				});
		  
     });
//其他操作
	layui.use(['layer', 'notice', 'form', 'table', 'index'], function() {
		var $ = layui.jquery;
		var layer = layui.layer;
		var notice = layui.notice;
		var form = layui.form;
		var table = layui.table;
		var index = layui.index;
		
    //修改接口状态
   form.on('switch(ApiStatus)', function(data){
        var st = data.elem.checked;
        if(st){
            st = 1;
        }else{
            st = 0;
        }
        var id = data.value;
        $.ajax({
            type:'POST',
            url:'../ajax.php?act=ApiStatus',
            data : {id:id,status:st},
            dataType:'json',
            success:function (data){
                if(data.code == 200){
                    setTimeout(function (){
                        //location.href = './addapi.php'
                    },1);
                    layer.msg(data.msg,{icon: 1,time: 2000, shade:0});
                }else{
                    layer.msg(data.msg,{icon: 2,time: 2000, shade:0});
                }
            }
        });
    });
	 /* 批量删除 */
    table.on('toolbar(list)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      var data = checkStatus.data;
      if(obj.event === "del_table"){
          if(data.length == 0){
          layer.msg('请选择数据');
      }else{
          layer.confirm('确定要删除吗？', {icon: 3,shade: 0,title: '提示'
		},
		function() {
        $.ajax({
            type:'POST',
            url:'../ajax.php?act=ApiDel',
            data : {data:data},
            dataType:'json',
            success:function (data){
                if(data.code == 200){
                    setTimeout(function (){
                        location.href = './addapi.php'
                      
                    },1000);
                    layer.msg(data.msg,{icon: 1,time: 2000, shade:0.3});
                }else{
                    layer.msg(data.msg,{icon: 2,time: 2000, shade:0.3});
                }
            }
        });			
	  });
    }
  }
 });
 //单个删除
     table.on("tool(list)", function(obj) {
         var data = obj.data;
         id = data["id"];
         if (obj.event === "del") {
             layer.confirm('你确实要删除此资源吗？', {
                 btn: ['确定', '取消'],
                 closeBtn: 0,
                 icon: 3
             },
             function() {
                var ii = layer.load(2, {
                shade: [0.1, '#fff']
             });
             $.ajax({
                 type: "POST",
                 url: "../ajax.php?act=ApiDel",
                 data: {
                    id: id
                 },
                dataType: "json",
                success: function(data) {
                    if (data.code == 1) {
                        layer.msg(data.msg);
                        window.location.reload();
                    } else {
                        layer.msg(data.msg);
                        window.location.reload();
                    }
                }
             });
             },function() {});
         } else if (obj.event === "edit") {
             $.ajax({
                 type: "POST",
                 url: "../ajax.php?act=ApiInfo",
                 data: {
                     id: id
                 },
                 dataType: "json",
                 success: function(res) {
            if (res.code == 200) {
                $("#id").val(res.data.id);
                $("#name").val(res.data.name);
                $("#desc").val(res.data.desc);
                $("#alias").val(res.data.alias);
                $("#faimg").val(res.data.faimg);
                $("#apiurl").val(res.data.apiurl);
                $("#apiformat").val(res.data.apiformat);
                $("#request").val(res.data.request);
                $("#apirequest").val(res.data.apirequest);
                $("#money").val(res.data.money); // 价格
                $("#explain").val(res.data.explain);
                $("#return").val(res.data.return);
                $("#example").val(res.data.example);
                $("#examples").val(res.data.examples);
                $("#views").val(res.data.views);
                $("#remarks").val(res.data.remarks);
                $("#status").val(res.data.status);
            layer.open({
               type: 1,
               skin:'demo-class',
               btn: ['编辑', '关闭'],
               closebtn:1,
               area:['50%','90%'],//宽度和高度 可以百分比 可以写死
               title:'编辑API接口',
               content:$("#add_form") //这里content是一个普通的String
               ,yes: function(index, layero){
                var data1 = form.val("addjiekou");
                $.ajax({
                url: '../ajax.php?act=ApiForm',
                type: 'POST',
                dataType: 'json',
                data: data1,
                success: function (data) {
                    if (data.code == 200) {
                        layer.msg(data.msg, {icon: 1, time: 2000, shade: 0.4}, function() {layer.closeAll();});
                    } else {
                        layer.msg(data.msg, {icon: 2, time: 2000, shade: 0.4});
                    }
                },
                error: function () {
                    layer.alert("网络连接错误,请稍后重试");
                }
            });
                return false;
                }
                ,btn2: function(index, layero){
                //按钮【按钮二】的回调
                layer.closeAll();
                //return false 开启该代码可禁止点击该按钮关闭
                }
                ,end:function(){
                    $("#id").val('');
                    $("#name").val('');
                    $("#desc").val('');
                    $("#alias").val('');
                    //$("#faimg").val('');
                    $("#apiurl").val('');
                    //$("#apiformat").val('');
                    //$("#request").val('');
                    $("#apirequest").val('');
                    $("#explain").val('');
                    $("#return").val('');
                    $("#example").val('');
                    $("#examples").val('');
                    $("#views").val('');
                    $("#remarks").val('');
                    //$("#status").val('');
                }
               });
                    } else {
                        layer.msg(res.msg);
                        window.location.reload();
                    }
                }
            });
		}
	});
});      

 //监听别名
  //初始化地址
        var apiUrl = "<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/api/';?>";
        $('#alias').bind('input propertychange', function () {
            if ($(this).val()) {
                $('#apirequest').val(apiUrl + $(this).val() + "/");
                $('#apiurl').val(apiUrl + $(this).val() + "/");
            } else {
                $('apirequest').val('');
                $('#apiurl').val('');
            }
        })	
</script>
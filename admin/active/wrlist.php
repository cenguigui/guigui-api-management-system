<?php
/**
 * 文章列表
**/
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/common.php';
$title='文章列表';
$isAdmin = isAdmin($_COOKIE["admin_token"]);
if (empty($isAdmin))exit("<script language='javascript'>window.location.href='./login.php';</script>");
$count=$DB->getColumn("SELECT count(*) from api_down WHERE 1");

include '../head.php';
?>
<div class="layui-fluid">
		<div class="layui-row layui-col-space15">
			<div class="layui-col-md12">
				<div class="layui-card">
					<div class="layui-card-header">资源表格共有 <b><?=$count?></b> 个资源</div>
					<div class="layui-card-body">				
						<!-- 表格工具栏 -->
						<form class="layui-form toolbar">
							<div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label w-auto">选择类型</label>
                                    <div class="layui-input-block">
                                        <select name="type">
                                            <option value="2">标题</option>
                                            <option value="1">ID</option>
                                            <option value="0">全部</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-inline">
									<label class="layui-form-label w-auto">搜索数据：</label>
									<div class="layui-input-inline mr0">
										<input type="text" name="kw" class="layui-input" placeholder="请输入你所要搜索的内容！" />
									</div>
								</div>
                                <div class="layui-inline">
                                    <label class="layui-form-label w-auto">搜索类别</label>
                                    <div class="layui-input-block">
                                        <select name="method">
                                            <option value="1">模糊搜索</option>
                                        </select>
                                    </div>
                                </div>
								<div class="layui-inline">
									<button class="layui-btn icon-btn" lay-filter="roleTbSearch" lay-submit>
										<i class="layui-icon">&#xe615;</i>搜索
									</button>
								</div>
							</div>
						</form>
						<!-- 数据表格 -->
						<table class="layui-hide" id="list_probe" lay-filter="list_probe"></table>
						<script id="table_button" type="text/html">
							<a lay-event="Modify" class="layui-btn layui-btn-normal layui-btn-xs"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                            <a lay-event="del" class="layui-btn layui-btn-danger layui-btn-xs"><i class="layui-icon layui-icon-delete"></i>删除</a>
						</script>
					</div>
				</div>
			</div>
		</div>
    <script type="text/javascript" src="/assets/iframe/libs/jquery/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/assets/iframe/libs/layui/layui.js"></script>
    <script type="text/javascript" src="/assets/iframe/js/common.js?v=318"></script>
    <script src="/assets/iframe/js/nprogress.js"></script>
    <script>
			layui.use(['layer', 'notice','form','admin', 'table'],function() {
				var $ = layui.jquery;
				var layer = layui.layer;
				var notice = layui.notice;
				var form = layui.form;
				var admin = layui.admin;
				var table = layui.table;
				var insTb = table.render({
                    elem: "#list_probe",
                    url: "./downdata.php?act=res_list",
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
                                field: "title",
                                title: "标题",
                                sort: true
                            },
                            {
                                field: "img",
                                title: "图片",
                                sort: true
                            },
                            {
                                field: "status",
                                title: "Top状态",
                                sort: true
                            },
                            {
                                field: "top",
                                title: "置顶",
                                sort: true
                            },
                            {
                                field: "date",
                                title: "发布时间",
                                sort: true
                            },
                           {
                                field: "action",
                                title: "其他操作",
                                toolbar: "#table_button",
                                width: 150
                            }
                        ]
                    ]
                });
                /* 表格搜索 */
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
     /* 批量删除 */
    table.on('toolbar(list_probe)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id);
      var data = checkStatus.data;
      var allid = [];
      for(var i=0;i<data.length;i++){
          if(data[i].id){
              allid[i] = data[i].id;
          }
      }
      
      if(obj.event === "del_table"){
          if(allid.length == 0){
          layer.msg('请选择数据');
      }else{
          layer.confirm('确定要删除吗？', {icon: 3,shade: 0,title: '提示'
		},
		function() {
        $.ajax({
            type:'POST',
            url:'./downdata.php?act=del_res',
            data : {data:allid},
            dataType:'json',
            success:function (data){
                if(data.code == 1){
                    setTimeout(function (){
                        location.href = './wrlist.php'
                    },1000);
                    notice.msg(data.msg,{icon: 1,time: 2000, shade:0.3});
                }else{
                    notice.msg(data.msg,{icon: 2,time: 2000, shade:0.3});
                }
            }
        });			
	  });
    }
  }
 });    
        //单个删除资源
        table.on("tool(list_probe)", function(obj) {
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
                            url: "./downdata.php?act=del_res",
                            data: {
                                id: id
                            },
                            dataType: "json",
                            success: function(data) {
                                layer.close(ii);
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
		} else if (obj.event === "Modify") {
			window.location.href = "write.php?my=edit&id=" + id;
		}
	});
});               
NProgress.start();
    function neeprog() {
   NProgress.done();
  }
 window.onload=neeprog;      
</script>
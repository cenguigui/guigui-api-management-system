<?php
/**
 * 添加资源
**/

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/common.php';
$title='添加资源';
$isAdmin = isAdmin($_COOKIE["admin_token"]);
if (empty($isAdmin))exit("<script language='javascript'>window.location.href='./login.php';</script>");
include '../head.php';
?>

<div class="layui-fluid">
  <div class="layui-card">
   <div id="divLoading">
<?php
$my=isset($_GET['my'])?$_GET['my']:null;
if(!$my=='edit') { 
?> 
<div class="layui-card-header">添加资源</div>
        <div class="layui-card-body">
     <form class="layui-form layui-form-pane" id="formBasForm" lay-filter="formBasForm">
    <div class="layui-form-item">
    <label class="layui-form-label">资源标题</label><div class="layui-input-block">
    <input type="text" class="layui-input" name="title" id="title" placeholder="请输入标题" required>
   </div></div>
    <div class="layui-form-item">
    <label class="layui-form-label">资源讲述</label><div class="layui-input-block">
    <input type="text" class="layui-input" name="title_site" id="title_site" placeholder="请输入你需要讲述的主要内容！" required>
   </div></div>
   <div class="layui-form-item">
   <label class="layui-form-label">程序截图</label><div class="layui-input-block">
   <input type="file" id="file" onchange="fileUpload()" style="display:none;"/>
   <input type="text" class="layui-input" id="img" name="img" value="" placeholder="填写图片URL，没有请留空" style="padding-right: 80px;">    
   <a href="javascript:fileView()" class="layui-btn layui-btn-warm" title="查看图片" style="position: absolute;top: 0;right: 0px;
    cursor: pointer;"><i class="layui-icon layui-icon-picture"></i></a>
   <a href="javascript:fileSelect()" class="layui-btn layui-btn-success" title="上传图片" style="position: absolute;top: 0;right: 57px;cursor: pointer;"><i class="layui-icon layui-icon-upload"></i></a>
    </div></div>
    <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">资源介绍</label><div class="layui-input-block">
    <textarea name="content" id="content"></textarea>
    </div></div>
    <div class="layui-form-item">
    <label class="layui-form-label">资源下架提示</label><div class="layui-input-block">
    <input type="text" class="layui-input" name="Maintain" id="Maintain" placeholder="请输入提示内容" required>
   </div></div>
    <div class="layui-form-item">
     <label class="layui-form-label">状态</label>
       <div class="layui-input-block">
         <select name="status" id="status" class="layui-input">
            <option value="1">显示</option>
             <option value="0">隐藏</option>
         </select>
        </div>
      </div> 
    <div class="layui-form-item">
     <label class="layui-form-label">资源置顶</label>
       <div class="layui-input-block">
         <select name="top" id="top" class="layui-input">
            <option value="1">默认</option>
             <option value="2">置顶</option>
         </select>
        </div>
      </div> 
    <div class="layui-form-item">
    <label class="layui-form-label">下载链接</label><div class="layui-input-block">
    <input type="text" class="layui-input" name="down" id="down" placeholder="请输入下载链接" required>
   </div></div>
    <div class="layui-form-item">
     <label class="layui-form-label">下载</label>
       <div class="layui-input-block">
         <select name="Yes" id="Yes" class="layui-input">
            <option value="1">开启</option>
             <option value="0">关闭</option>
         </select>
        </div>
      </div> 
      <div class="layui-form-item">
        <button type="button" class="layui-btn layui-btn-fluid" lay-submit lay-filter="noticeBtn">&emsp;添加资源</button>
    </div>
    <div class="layui-form-item">
         <button type="reset" id="formreset" class="layui-btn layui-btn-primary layui-btn-fluid">&emsp;重置表单</button>
    </div>
</div>
</form>
<?php
}
?>
<?php           
if($my=='edit') { 
$id = daddslashes($_GET['id']);
$row=$DB->getRow("SELECT * FROM api_down WHERE id='$id' limit 1");
?> 
<div class="layui-card-header">修改资源</div>
<div class="layui-card-body">
<form class="layui-form layui-form-pane" id="formBasForm" lay-filter="formBasForm">
    <div class="layui-form-item">
    <label class="layui-form-label">资源标题</label><div class="layui-input-block">
    <input type="text" class="layui-input" name="title" id="title" value="<?php echo $row['title']; ?>" required>
   </div></div>
    <div class="layui-form-item">
    <label class="layui-form-label">资源讲述</label><div class="layui-input-block">
    <input type="text" class="layui-input" name="title_site" id="title_site" value="<?php echo $row['title_site']; ?>" required>
   </div></div>
   <div class="layui-form-item">
   <label class="layui-form-label">程序截图</label><div class="layui-input-block">
   <input type="file" id="file" onchange="fileUpload()" style="display:none;"/>
   <input type="text" class="layui-input" id="img" name="img" value="<?php echo $row['img']; ?>" placeholder="填写图片URL，没有请留空" style="padding-right: 80px;">    
   <a href="javascript:fileView()" class="layui-btn layui-btn-warm" title="查看图片" style="position: absolute;top: 0;right: 0px;
    cursor: pointer;"><i class="layui-icon layui-icon-picture"></i></a>
   <a href="javascript:fileSelect()" class="layui-btn layui-btn-success" title="上传图片" style="position: absolute;top: 0;right: 57px;cursor: pointer;"><i class="layui-icon layui-icon-upload"></i></a>
    </div></div>
    <div class="layui-form-item layui-form-text">
<label class="layui-form-label">资源介绍</label><div class="layui-input-block">
<textarea name="content" id="content"><?php echo $row['content']; ?></textarea>
</div></div>
<div class="layui-form-item">
    <label class="layui-form-label">资源下架提示</label><div class="layui-input-block">
    <input type="text" class="layui-input" name="Maintain" id="Maintain" value="<?php echo $row['Maintain']; ?>" required>
   </div></div>
    <div class="layui-form-item">
     <label class="layui-form-label">状态</label>
       <div class="layui-input-block">
         <select name="status" id="status" class="layui-input">
                    <?php
                    if($row["status"]==0){
                        echo '<option value="0">资源下架( 下架 )</option><option value="1">资源正常</option>';
                    }elseif($row["status"]==1){
                        echo '<option value="1">资源正常</option><option value="0">资源下架( 下架 )</option>';
                    }
                    ?>
                </select>
        </div> </div>
        <div class="layui-form-item">
    <label class="layui-form-label">资源置顶</label>
    <div class="layui-input-block">
                <select name="top" id="top" class="layui-input">
                <?php
                if($row["top"]==1){
                    echo '<option value="1">正常显示</option><option value="2">置顶推荐</option>';
                }elseif($row["top"]==2){
                    echo '<option value="2">置顶推荐</option><option value="1">正常显示</option>';
                }
                ?>
            </select>
        </div> </div>
        <div class="layui-form-item">
    <label class="layui-form-label">下载链接</label><div class="layui-input-block">
    <input type="text" class="layui-input" name="down" id="down" value="<?=$row['down']?>" required>
   </div></div>
        <div class="layui-form-item">
    <label class="layui-form-label">下载</label>
    <div class="layui-input-block">
                <select name="Yes" id="Yes" class="layui-input">
                <?php
                if($row["Yes"]==1){
                    echo '<option value="1">开启下载</option><option value="0">关闭下载</option>';
                }elseif($row["Yes"]==0){
                    echo '<option value="0">关闭下载</option><option value="1">开启下载</option>';
                }
                ?>
            </select>
        </div>
       </div>
    <div class="layui-form-item">
        <button type="button" class="layui-btn layui-btn-fluid" lay-submit lay-filter="editBtn">&emsp;修改资源</button>
    </div>
    <div class="layui-form-item">
         <button type="reset" id="formreset" class="layui-btn layui-btn-primary layui-btn-fluid">&emsp;重置表单</button>
    </div>
</div>
<?php	
}
?>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="/assets/iframe/libs/layui/layui.js"></script>
<script type="text/javascript" src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--<script type="text/javascript" src="/assets/iframe/libs/jquery/jquery-3.2.1.min.js"></script>-->
<script type="text/javascript" src="/assets/iframe/js/common.js?v=318"></script>
<script type="text/javascript" src="/assets/iframe/libs/tinymce/tinymce.min.js"></script>
<script src="/assets/iframe/js/nprogress.js"></script>
<script>
layui.use(['form', 'element', 'jquery', 'admin', 'notice'], function () {
    var form = layui.form;
    var $ = layui.jquery;
    var admin = layui.admin;
    var notice = layui.notice;
    $('#formreset').click(function () {
        document.getElementById("formBasForm").reset();
        notice.destroy();
        layer.msg('重置表单成功！', {animateInside: true, icon: 1});
    });
    form.on('submit(noticeBtn)', function (data) {
       var title = $("#title").val();
	   var title_site = $("#title_site").val();
	   var content = tinymce.activeEditor.getContent();
	   var Maintain = $("#Maintain").val();
   	   var img = $("#img").val();
	   var down = $("#down").val();
	   var status = $("#status").val();
	   var top = $("#top").val();
	   var Yes = $("#Yes").val();
        admin.btnLoading('[lay-filter="noticeBtn"]',' 添加中');
        admin.showLoading('#divLoading', 2, '.8');
        notice.destroy();
        $.ajax({
            type: "POST",
            url: "./downdata.php?act=add_res",
		    data: {
			"title": title,
			"title_site": title_site,
			"content": content,
			"Maintain": Maintain,
			"img": img,
			"down": down,
			"status": status,
			"top": top,
			"Yes": Yes
		   },
            dataType: "json",
            success: function(data) {
                admin.removeLoading('#divLoading', true, true);
                admin.btnLoading('[lay-filter="noticeBtn"]', false);
                if (data.code == 1) {
                    layer.msg(data.msg, {animateInside: true, icon: 1});
                } else {
                    layer.msg(data.msg, {animateInside: true, icon: 2});
                }
            },
            error:function(data){
                layer.msg('服务器错误！', {animateInside: true, icon: 2});
                return false;
            }
        });
        return false;
    });
 });
   NProgress.start();
   function neeprog() {
   	NProgress.done();
   }
   window.onload=neeprog;
  </script>
<script>
layui.use(['form', 'element', 'jquery', 'admin', 'laydate', 'notice'], function () {
    var form = layui.form;
    var $ = layui.jquery;
    var laydate = layui.laydate;
    var admin = layui.admin;
    var notice = layui.notice;
    $('#formreset').click(function () {
        document.getElementById("formBasForm").reset();
        notice.destroy();
        layer.msg('重置表单成功！', {animateInside: true, icon: 1});
    });        
    form.on('submit(editBtn)', function (data) {
       var title = $("#title").val();
	   var title_site = $("#title_site").val();
	   var content = tinymce.activeEditor.getContent();
	   var Maintain = $("#Maintain").val();
   	   var img = $("#img").val();
	   var down = $("#down").val();
	   var status = $("#status").val();
	   var top = $("#top").val();
	   var Yes = $("#Yes").val();
        admin.btnLoading('[lay-filter="editBtn"]',' 修改中');
        admin.showLoading('#divLoading', 2, '.8');
        notice.destroy();
        $.ajax({
            type: "POST",
            url: "./downdata.php?act=edit_res",
		    data: {
		    "id": <?php echo isset($row['id']) ? intval($row['id']) : 0; ?>,
			"title": title,
			"title_site": title_site,
			"content": content,
			"Maintain": Maintain,
			"img": img,
			"down": down,
			"status": status,
			"top": top,
			"Yes": Yes
		   },
            dataType: "json",
            success: function(data) {
                admin.removeLoading('#divLoading', true, true);
                admin.btnLoading('[lay-filter="editBtn"]', false);
                if (data.code == 1) {
                    layer.msg(data.msg, {animateInside: true, icon: 1});
                } else {
                    layer.msg(data.msg, {animateInside: true, icon: 2});
                }
            },
            error:function(data){
                layer.msg('服务器错误！', {animateInside: true, icon: 2});
                return false;
            }
        });
        return false;
    });
 });
  </script>
<script>
function fileSelect(){
	$("#file").trigger("click");
}
function fileView(){
	var img = $("#img").val();
	if(img=='') {
		layer.msg("请先上传图片，才能预览",{icon:3});
		return;
	}
	if(img.indexOf('http') == -1)img = '../'+img;
	layer.open({
		type: 1,
		area: ['360px', '400px'],
		title: '图片查看',
		shade: 0.3,
		anim: 1,
		shadeClose: true,
		content: '<center><br><img width="300px" src="'+img+'"></center>'
	});
}
function fileUpload(){
	var fileObj = $("#file")[0].files[0];
	if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
		return;
	}
	var formData = new FormData();
	formData.append("do","upload");
	formData.append("type","shop");
	formData.append("file",fileObj);
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		url: "./downdata.php?act=upimg",
		data: formData,
		type: "POST",
		dataType: "json",
		cache: false,
		processData: false,
		contentType: false,
		success: function (data) {
			layer.close(ii);
			if(data.code == 0){
				layer.msg('上传图片成功！',{icon:1});
				$("#img").val(data.url);
			}else{
				layer.alert(data.msg);
			}
		},
		error:function(data){
			layer.msg('服务器错误');
			return false;
		}
	})
}
</script>
<script>
    layui.use(['layer', 'admin'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var admin = layui.admin;

        // 渲染富文本编辑器
        tinymce.init({
            selector: '#content',
            height: 525,
            branding: false,
            language: 'zh_CN',
            toolbar: [
            'fullscreen preview code | undo redo | link image media emoticons charmap anchor pagebreak codesample | ltr rtl',
            'bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | formatselect fontselect fontsizeselect'
            ],
            //指定需加载的插件
            plugins: 'code print preview fullscreen paste searchreplace save autosave link autolink image imagetools media table codesample lists advlist hr charmap emoticons anchor directionality pagebreak quickbars nonbreaking visualblocks visualchars wordcount',
            //codesample插件:
            codesample_languages: [
            {text: 'HTML/XML', value: 'markup'},
            {text: 'JavaScript', value: 'javascript'},
            {text: 'CSS', value: 'css'},
            {text: 'PHP', value: 'php'},
            {text: 'Ruby', value: 'ruby'},
            {text: 'Python', value: 'python'},
            {text: 'Java', value: 'java'},
            {text: 'C', value: 'c'},
            {text: 'C#', value: 'csharp'},
            {text: 'C++', value: 'cpp'}
            ],
            toolbar_drawer: 'sliding',
            images_upload_url: './downdata.php?act=upimg',
            images_upload_base_path: '',
            //textpattern插件: 快速排版(可实现markdown写法)
            textpattern_patterns: [
            {start: '*', end: '*', format: 'italic'},
            {start: '**', end: '**', format: 'bold'},
            {start: '#', format: 'h1'},
            {start: '##', format: 'h2'},
            {start: '###', format: 'h3'},
            {start: '####', format: 'h4'},
            {start: '#####', format: 'h5'},
            {start: '######', format: 'h6'},
            {start: '1. ', cmd: 'InsertOrderedList'},
            {start: '* ', cmd: 'InsertUnorderedList'},
            {start: '- ', cmd: 'InsertUnorderedList'}
            ],
            });
    });
</script>

  <script>
   NProgress.start();
   function neeprog() {
   	NProgress.done();
   }
   window.onload=neeprog;
  </script>
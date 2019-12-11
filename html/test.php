<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>管理系统</title>
    <link href="css/public.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="layui_v2.4.5/layui/css/layui.css">
    <script src="http://static.web.sdo.com/mir2/js/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="layui_v2.4.5/layui/layui.js"></script>
    <script type="text/javascript" src="js/handleLeftNav.js"></script>
    <script type="text/javascript">


        var layer = layui.layer, form = layui.form;


        layui.use('upload', function () {
            var upload = layui.upload;


            var uploadWorks = upload.render({
                elem: '#upload_works1' //绑定元素
                , url: 'getPhone.php' //上传接口
                , field: "decodes"//文件名
                , accept: 'file'
                , done: function (data) {
                    //上传完毕回调
                    if (data.IsSuccess) {
                        layer.msg('操作成功', {icon: 1});
                        // window.location.reload();//刷新父页面
                    } else {
                        layer.msg(data.Errormsg, {icon: 2});
                    }
                }
                , error: function () {
                    //请求异常回调
                }
            });
        });


        function deleteUser(phone_number) {

            //询问框
            layer.confirm('是否确认删除?' +
                '删除后会造成预约数据无法核实,请尽量不要再上线后使用', {
                btn: ['N', 'Y'] //按钮
            }, function (index) {
                layer.close(index);
            }, function (index) {
                $.ajax({
                    type: "GET",
                    url: "http://yii.com:80/index.php?r=country/index2",
                    // data: "api_type=delete_phone" + '&phone=' + phone_number,
                    dataType: "json",
                    success: function (data) {
                        if (data.IsSuccess) {
                            layer.msg('操作成功', {icon: 1});
                            window.location.reload();//刷新父页面
                        } else {
                            layer.msg('操作失败', {icon: 2});
                            layer.close(index);
                        }
                    }
                });


            });
        };
        $(function () {


        });
    </script>
</head>
<body>
<div id="dcWrap">
    <!-- dcMain begin -->
    <div id="dcMain">
        <div id="urHere">管理系统<b>&gt;</b><strong>加密文件</strong>
        </div>
         当前位置
                <div>
                    <button type="button" class="layui-btn" id="upload_works" onclick="deleteUser(138021223112)">
                        <i class="layui-icon">&#xe67c;</i>上传解密手机号文件
                    </button>
                </div>
<!---->
<!--        <form action="getPhone.php" method="post"-->
<!--              enctype="multipart/form-data">-->
<!--            <label for="file">Filename:</label>-->
<!--            <input type="file" name="decodes" id="decodes" />-->
<!--            <br />-->
<!--            <input type="submit" name="submit" value="Submit" />-->
<!--        </form>-->


    </div>
</body>
</html>
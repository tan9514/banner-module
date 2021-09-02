@extends('admin.public.header')
@section('title','轮播图列表')

@section('listsearch')
    <style>
    </style>
    <div class="layui-btn-container" >
        <button class="layui-btn layui-btn-sm layuimini-btn-primary" data-type="reload"><i class="layui-icon layui-icon-refresh-3"></i></button>
        <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn " data-type="add"><i class="layui-icon layui-icon-add-circle"></i>新增</button>
    </div>

    <div class="layui-row layui-col-space15" style="border-top: 1px solid #e6e6e6; margin-top: 5px;">
        @if($count > 0)
        @foreach($list as $item)
        <div class="layui-col-md3">
            <div class="layui-panel" style="border: 1px solid rgba(0,0,0,.125); border-radius: 4px;">
                <div style="width: 100%; height: 160px;">
                    <img style="width: 100%; height: 100%; border-radius: 4px 4px 0 0" src="{{$item->show_pic}}" alt=""></div>
                <div style="padding: 15px;">
                    <p style="margin-bottom: 15px;">标题：{{$item->title}}</p>
                    <div>链接：{{$item->route}}</div>
                </div>
                <div style="border-top: 1px solid rgba(0,0,0,.125); padding: 10px 17px; background: #f7f7f9;">
                    <a class="layui-btn layui-btn-xs" data-type="edit" data-name="{{$item->title}}" data-id="{{$item->id}}"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" data-type="del" data-name="{{$item->title}}" data-id="{{$item->id}}"><i class="layui-icon layui-icon-delete"></i>删除</a>
                </div>
            </div>
        </div>
        @endforeach
        {{$list->links("bannerview::admin.banner.new-pagination")}}
        @else
        <div class="layui-col-md12" style="line-height: 26px; padding: 15px; text-align: center; color: #999;">抱歉！暂无数据~</div>
        @endif
    </div>
@endsection

@section('listscript')
    <script type="text/javascript">
        layui.use(['form','table','laydate', 'treetable'], function(){
            var table = layui.table, $=layui.jquery, form = layui.form, treetable = layui.treetable, laydate = layui.laydate;

            // 新增 编辑 公共弹框
            function showFrame(title, id=0) {
                let content = '/admin/banner/edit';
                if(id > 0){
                    content += "?id=" + id;
                }
                var index = layer.open({
                    title: title,
                    type: 2,
                    shade: 0.2,
                    maxmin:true,
                    skin:'layui-layer-lan',
                    shadeClose: true,
                    area: ['80%', '80%'],
                    content: content,
                });
            }

            // 刷新页面 新增 编辑 删除点击事件
            $(document).on("click", ".layui-btn", function () {
                let type = $(this).data("type");
                let name = $(this).data("name");
                let id = $(this).data("id");
                switch (type){
                    case "reload":
                        window.location.href = "/admin/banner/list";
                        break;
                    case "add":
                        showFrame("新增轮播图");
                        break;
                    case "edit":
                        showFrame(name + ' - 编辑', id);
                        break;
                    case "del":  // 删除功能
                        layer.confirm('确定删除 ' + name + ' 轮播图吗？', {
                            title : "删除轮播图",
                            skin: 'layui-layer-lan'
                        },function(index){
                            $.ajax({
                                url:'/admin/banner/del',
                                type:'post',
                                data:{'id':id},
                                dataType:"JSON",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                success:function(data){
                                    if(data.code == 0){
                                        layer.msg(data.message,{icon: 1,time:1500},function(){
                                            window.location.reload();
                                        });
                                    }else{
                                        layer.msg(data.message,{icon: 2});
                                    }
                                },
                                error:function(e){
                                    layer.msg(data.message,{icon: 2});
                                },
                            });
                        });
                        break;
                }
            })
        });
    </script>
@endsection

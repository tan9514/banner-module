<?php
// @author liming
namespace Modules\Banner\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Banner\Http\Controllers\Controller;
use Modules\Banner\Http\Requests\Admin\BannerEditRequest;
use Modules\Banner\Entities\Applet;
use Modules\Banner\Entities\Banner;

class BannerController extends Controller
{
    /**
     * 分页列表
     */
    public function list(Request $request)
    {
        $pagesize = $request->input('limit', 8); // 每页条数
        $page = $request->input('page', 1);//当前页

        $where = [];

        $list = Banner::where($where)
            ->orderBy("sort")
            ->orderBy("id", "desc")
            ->paginate($pagesize);
        foreach ($list as &$item){
            $item['show_pic'] = $item->setPicUrl($item->pic);
        }
        $count = $list->count();
        return view('bannerview::admin.banner.list', compact('list', 'count'));
    }

    /**
     * 新增|编辑导航图标
     * @param $id
     */
    public function edit(BannerEditRequest $request)
    {
        if($request->isMethod('post')) {
            $request->check();
            $data = $request->post();

            if(isset($data["id"])){
                $info = Banner::where("id",$data["id"])->first();
                if(!$info) return $this->failed('数据不存在');
            }else{
                $info = new Banner();
            }

            $info->title = $data["title"];
            $info->route = $data["route"] ?? "";
            $info->open_type = $data["open_type"] ?? "";
            $info->pic = $data["pic"];
            if(!file_exists($info->pic)) return $this->failed('上传的轮播图不存在');
            $info->sort = $data["sort"];

            if(!$info->save()) return $this->failed('操作失败');
            return $this->success();
        } else {
            $id = $request->input('id') ?? 0;
            if($id > 0){
                $info = Banner::where('id',$id)->first();
                $info['show_pic'] = $info->setPicUrl($info->pic);
                $title = "编辑图标";
            }else{
                $info = new Banner();
                $title = "新增图标";
            }
            $domain = Banner::getDomain();
            if(Schema::hasTable("applet")){
                $applet = Applet::orderBy("id")->get()->toArray();
            }else{
                $applet = [];
            }
            foreach ($applet as &$item){
                $item["params"] = json_decode($item["params"], true);
            }
            return view('bannerview::admin.banner.edit', compact('info', 'title', 'domain', 'applet'));
        }
    }

    /**
     * 删除导航图标
     */
    public function del(Request $request)
    {
        if($request->isMethod('post')){
            $id = $request->input('id');
            $info = Banner::where('id', $id)->first();
            if (!$info) return $this->failed("数据不存在");
            if(!$info->delete()) return $this->failed("操作失败");
            return $this->success();
        }
        return $this->failed('请求出错.');
    }
}

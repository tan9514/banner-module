<?php
namespace Modules\Banner\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @author liming
 * @date 2021-08-25
 */
class BannerAuthMenuSeeder extends Seeder
{
    public function run()
    {
        if (Schema::hasTable('auth_menu')){
            $arr = $this->defaultInfo();
            if(!empty($arr) && is_array($arr)) {
                // 删除原来已存在的菜单
                $module = config('bannerconfig.module') ?? "";
                if($module != ""){
                    DB::table('auth_menu')->where("module", $module)->delete();
                }

                $this->addInfo($arr);
            }
        }
    }

    /**
     * 遍历新增菜单
     * @param array $data
     * @param int $pid
     */
    private function addInfo(array $data, $pid = 0)
    {
        foreach ($data as $item) {
            $newPid = DB::table('auth_menu')->insertGetId([
                'pid' => $item['pid'] ?? $pid,
                'href' => $item['href'],
                'title' => $item['title'],
                'icon' => $item['icon'],
                'type' => $item['type'],
                'status' => $item['status'],
                'sort' => $item['sort'] ?? 0,
                'remark' => $item['remark'],
                'target' => $item['target'],
                'createtime' => $item['createtime'],
                'module' => $item["module"],
                'menus' => $item["menus"],
            ]);
            if($newPid <= 0) break;
            if(isset($item["contents"]) && is_array($item["contents"]) && !empty($item["contents"])) $this->addInfo($item["contents"], $newPid);
        }
    }

    /**
     * 设置后台管理菜单路由信息
     * @pid 父级
     * @href 路由
     * @title 菜单标题
     * @icon 图标
     * @type int 类型 0 顶级目录 1 目录 2 菜单 3 按钮
     * @status 状态 1 正常 2 停用
     * @remark 备注
     * @target 跳转方式
     * @createtime 创建时间
     */
    private function defaultInfo()
    {
        $module = config('bannerconfig.module') ?? "";
        $time = time();
        return [
            [
                "pid" => 10002,
                "href" => "/admin/banner/list",
                "title" => "轮播图",
                "icon" => 'fa fa-image',
                "type" => 2,
                "status" => 1,
                "sort" => 97,
                "remark" => "轮播图",
                "target" => "_self",
                "createtime" => $time,
                'module' => $module,
                "menus" => $module == "" ? $module : $module . "-1",
                "contents" => [
                    [
                        "href" => "/admin/banner/list",
                        "title" => "查看轮播图",
                        "icon" => 'fa fa-window-maximize',
                        "type" => 3,
                        "status" => 1,
                        "remark" => "查看轮播图",
                        "target" => "_self",
                        "createtime" => $time,
                        'module' => $module,
                        "menus" => $module == "" ? $module : $module . "-2",
                    ],
                    [
                        "href" => "/admin/banner/edit",
                        "title" => "新增|编辑轮播图",
                        "icon" => 'fa fa-window-maximize',
                        "type" => 3,
                        "status" => 1,
                        "remark" => "新增|编辑轮播图",
                        "target" => "_self",
                        "createtime" => $time,
                        'module' => $module,
                        "menus" => $module == "" ? $module : $module . "-3",
                    ],
                    [
                        "href" => "/admin/banner/del",
                        "title" => "删除轮播图",
                        "icon" => 'fa fa-window-maximize',
                        "type" => 3,
                        "status" => 1,
                        "remark" => "删除轮播图",
                        "target" => "_self",
                        "createtime" => $time,
                        'module' => $module,
                        "menus" => $module == "" ? $module : $module . "-4",
                    ]
                ]
            ],
        ];
    }
}
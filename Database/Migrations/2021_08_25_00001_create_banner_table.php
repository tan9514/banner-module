<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBannerTable extends Migration
{
    public $tableName = "banner";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->tableName)) $this->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }

    /**
     * 执行创建表
     */
    private function create()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';      // 设置存储引擎
            $table->charset = 'utf8';       // 设置字符集
            $table->collation  = 'utf8_general_ci';       // 设置排序规则

            $table->id();
            $table->string('title', 100)->nullable(false)->default("")->comment("标题")->index("title_index");
            $table->string("route", 255)->nullable(false)->default("")->comment("跳转路由");
            $table->string("open_type", 255)->nullable(false)->default("")->comment("打开方式：跟 applet 表的打开方式一样");
            $table->string("pic", 255)->nullable(false)->default("")->comment("图片");
            $table->unsignedTinyInteger("sort")->nullable(false)->default(100)->comment("排序: 升序");
            $table->timestamps();
        });
        $prefix = DB::getConfig('prefix');
        $qu = "ALTER TABLE " . $prefix . $this->tableName . " comment '轮播图表'";
        DB::statement($qu);
    }
}

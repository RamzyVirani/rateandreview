<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use RamzyVirani\RateAndReview\Helper\Util;

class CreateReviewsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('instance_id')->unsigned();
            $table->string('instance_type');
            $table->integer('rating');
            $table->text('review');
            $table->timestamps();
            $table->softDeletes();
        });

        $module_id = \DB::table("modules")->insertGetId([
            'name'         => 'Review',
            'slug'         => 'reviews',
            'table_name'   => 'reviews',
            'icon'         => 'fa fa-comments',
            'status'       => 1,
            'is_module'    => 1,
            'config'       => '[{""name"":""id"",""primary"":true,""dbType"":""increments"",""fillable"":false,""inForm"":false,""htmlType"":false,""validations"":false,""inIndex"":false,""searchable"":false},{""name"":""user_id"",""primary"":false,""dbType"":""increments"",""fillable"":true,""inForm"":true,""htmlType"":""text"",""validations"":""required"",""inIndex"":true,""searchable"":true},{""name"":""game_id"",""primary"":false,""dbType"":""increments"",""fillable"":true,""inForm"":true,""htmlType"":""text"",""validations"":""required"",""inIndex"":true,""searchable"":true},{""name"":""rating"",""primary"":false,""dbType"":""increments"",""fillable"":true,""inForm"":true,""htmlType"":""text"",""validations"":""required"",""inIndex"":true,""searchable"":true},{""name"":""total_votes"",""primary"":false,""dbType"":""increments"",""fillable"":true,""inForm"":true,""htmlType"":""text"",""validations"":""required"",""inIndex"":true,""searchable"":true},{""name"":""review"",""primary"":false,""dbType"":""text,65535"",""fillable"":true,""inForm"":true,""htmlType"":""textarea"",""validations"":""required"",""inIndex"":true,""searchable"":true},{""name"":""created_at"",""primary"":false,""dbType"":""datetime"",""fillable"":false,""inForm"":false,""htmlType"":false,""validations"":false,""inIndex"":false,""searchable"":false},{""name"":""updated_at"",""primary"":false,""dbType"":""datetime"",""fillable"":false,""inForm"":false,""htmlType"":false,""validations"":false,""inIndex"":false,""searchable"":false},{""name"":""deleted_at"",""primary"":false,""dbType"":""datetime"",""fillable"":false,""inForm"":false,""htmlType"":false,""validations"":false,""inIndex"":false,""searchable"":false}]',
            'is_protected' => 0,
        ]);

        \DB::table("menus")->insert([
            'name'         => 'Reviews',
            'module_id'    => $module_id,
            'icon'         => 'fa fa-comments',
            'slug'         => 'reviews',
            'position'     => 1,
            'is_protected' => 0,
            'static'       => 0,
            'status'       => 1,
        ]);

        $seedingData = Util::seedWithCSV('permissions_seeder.csv');
        foreach ($seedingData as $key => $seed) {
            $seedingData[$key]['module_id'] = $module_id;
        }
        \DB::table('permissions')->insert($seedingData);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
        // TODO: Delete Rows from Module/ Permissions/ Menu
    }
}

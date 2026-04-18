<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExpandRecipesSchemaForFrontend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('id');
            $table->text('description')->nullable()->after('title');
            $table->string('image_url')->nullable()->after('description');
            $table->string('image_alt')->nullable()->after('image_url');
            $table->unsignedInteger('prep_mins')->default(0)->after('image_alt');
            $table->unsignedInteger('cook_mins')->default(0)->after('prep_mins');
            $table->string('difficulty')->nullable()->after('cook_mins');
            $table->decimal('rating', 3, 1)->default(0)->after('difficulty');
            $table->unsignedInteger('rating_count')->default(0)->after('rating');
            $table->string('region')->nullable()->after('rating_count');
            $table->string('course')->nullable()->after('region');
            $table->string('main_ingredient')->nullable()->after('course');
            $table->boolean('featured')->default(false)->after('main_ingredient');
            $table->json('ingredients')->nullable()->after('featured');
            $table->json('steps')->nullable()->after('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn([
                'external_id',
                'description',
                'image_url',
                'image_alt',
                'prep_mins',
                'cook_mins',
                'difficulty',
                'rating',
                'rating_count',
                'region',
                'course',
                'main_ingredient',
                'featured',
                'ingredients',
                'steps',
            ]);
        });
    }
}

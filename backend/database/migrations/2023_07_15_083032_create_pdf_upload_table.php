<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf_upload', function (Blueprint $table) {
            $table->id();
            $table->string('category_id')->comment("Store the category id");
            $table->string('sub_category_id')->nullable()->comment("Store the sub category, if not select store null");
            $table->string('pdf')->comment("Uploded PDF path");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdf_upload');
    }
}

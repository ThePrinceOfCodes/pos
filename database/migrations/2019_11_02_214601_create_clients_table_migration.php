<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('document_type', 1)->nullable()->default(null);
            $table->integer('document_id')->nullable()->default(null);
            $table->string('name');
            $table->string('email')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->timestamp('last_purchase')->nullable();
            $table->unsignedInteger('total_purchases')->default(0);
            $table->unsignedDecimal('total_paid')->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}

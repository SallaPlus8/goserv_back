<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialofferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialoffer', function (Blueprint $table) {
            $table->id();
            $table->string('offer_title');
            $table->string('offer_platform');
            $table->date('offer_start_date');
            $table->date('offer_end_date');
            $table->boolean('is_active')->default(true);

            $table->unsignedBigInteger('offer_type_id'); // for the relationship

            // Foreign key to offer_types
            $table->foreign('offer_type_id')->references('id')->on('offer_types')->onDelete('cascade');

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
        Schema::dropIfExists('specialoffer');
    }
}
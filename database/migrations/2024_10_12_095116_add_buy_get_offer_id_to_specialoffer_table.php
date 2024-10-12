<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyGetOfferIdToSpecialofferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('specialoffer', function (Blueprint $table) {
            // إضافة عمود buy_get_offer_id وربطه بجدول buy_get_offer
            $table->unsignedBigInteger('buy_get_offer_id')->nullable(); // عمود الربط
            $table->foreign('buy_get_offer_id')->references('id')->on('buy_get_offer')->onDelete('cascade'); // مفتاح أجنبي
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('specialoffer', function (Blueprint $table) {
            // حذف العمود والعلاقة
            $table->dropForeign(['buy_get_offer_id']);
            $table->dropColumn('buy_get_offer_id');
        });
    }
}

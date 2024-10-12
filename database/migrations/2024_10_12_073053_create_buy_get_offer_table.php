<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyGetOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_get_offer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_x_id'); // المنتج الذي يشتريه العميل
            $table->unsignedBigInteger('product_y_id'); // المنتج الذي يحصل عليه العميل
            $table->integer('quantity_x'); // الكمية المطلوبة من المنتج X
            $table->integer('quantity_y'); // الكمية المطلوبة من المنتج y

            $table->enum('discount_type', ['free', 'percentage'])->default('free'); // نوع الخصم (مجاني أو نسبة مئوية)
            $table->float('discount_value')->nullable(); // قيمة الخصم إذا كانت نسبة مئوية
            $table->text('offer_message'); // نص رسالة العرض

            // ربط المنتجات مع جدول المنتجات
            $table->foreign('product_x_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_y_id')->references('id')->on('products')->onDelete('cascade');

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
        Schema::dropIfExists('buy_get_offer');
    }
}

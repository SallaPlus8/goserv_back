<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedDiscountOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_discount_offer', function (Blueprint $table) {
            $table->id();
            $table->float('discount_value'); // قيمة التخفيض
            $table->enum('apply_to', ['all_products', 'selected_products', 'selected_categories', 'selected_payment_methods']); // نوع التطبيق
            $table->unsignedBigInteger('min_quantity')->nullable(); // الحد الأدنى للكمية لتطبيق العرض
            $table->float('min_purchase_amount')->nullable(); // الحد الأدنى لمبلغ الشراء لتطبيق العرض
            $table->boolean('apply_with_coupon')->default(false); // هل يمكن تطبيق العرض مع كوبون التخفيض
            $table->text('offer_message'); // نص رسالة العرض

            // العلاقات المحتملة:
            
            // 1. علاقة مع جدول المنتجات (إذا كان العرض على منتجات مختارة)
            $table->unsignedBigInteger('product_id')->nullable(); // في حالة منتجات مختارة
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // 2. علاقة مع جدول التصنيفات (إذا كان العرض على تصنيفات مختارة)
            $table->unsignedBigInteger('category_id')->nullable(); // في حالة تصنيفات مختارة
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            // 3. علاقة مع جدول طرق الدفع (إذا كان العرض على طرق دفع مختارة)
            $table->unsignedBigInteger('payment_method_id')->nullable(); // في حالة طرق دفع مختارة
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');

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
        Schema::dropIfExists('fixed_discount_offer');
    }
}

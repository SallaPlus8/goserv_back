<?php

namespace App\Http\Controllers\Api\Dashboard\SpecialOffers;

use App\Models\BuyGetOffer;
use App\Models\SpecialOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyGetOfferController extends Controller
{
   
   
   
      // دالة لعرض جميع العروض مع بيانات المنتجات المرتبطة
      public function index()
{
    // استرجاع جميع العروض مع المنتجات المرتبطة وبيانات جدول SpecialOffer
    $offers = BuyGetOffer::with(['productX', 'productY', 'specialOffer'])->get();

    // تنسيق البيانات كما هو مطلوب
    $formattedOffers = $offers->map(function ($offer) {
        return [
            'season_offer' => $offer->specialOffer->offer_title ?? 'عرض الموسم', // عنوان العرض من specialOffer إذا كانت موجودة
            'offer_message' => 'إذا اشترى العميل ' . $offer->productX->name . ' يحصل على ' . $offer->productY->name,
            'offer_platform' => $offer->specialOffer->offer_platform ?? 'منصة غير محددة', // المنصة إذا كانت موجودة
            'start_date' => $offer->specialOffer ? 'يبدأ بتاريخ: ' . $offer->specialOffer->offer_start_date : 'تاريخ غير متوفر', // استخدام التاريخ بدون format()
            'end_date' => $offer->specialOffer ? 'ينتهي بتاريخ: ' . $offer->specialOffer->offer_end_date : 'تاريخ غير متوفر',   // استخدام التاريخ بدون format()
            'is_active' => $offer->specialOffer ? ($offer->specialOffer->is_active ? 'مفعل' : 'غير مفعل') : 'غير معروف',  // حالة العرض إذا كانت موجودة
        ];
    });

    // إعادة النتيجة كاستجابة JSON
    return response()->json($formattedOffers);
}


   
    // دالة لتخزين العرض
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'product_x_id' => 'required|exists:products,id', // المنتج الذي يشتريه العميل
            'product_y_id' => 'required|exists:products,id', // المنتج الذي يحصل عليه العميل
            'quantity_y' => 'required|integer|min:1', // الكمية المطلوبة من المنتج y
            'quantity_x' => 'required|integer|min:1', // الكمية المطلوبة من المنتج X
            'discount_type' => 'required|in:free,percentage', // نوع الخصم (مجاني أو نسبة مئوية)
            'discount_value' => 'nullable|numeric', // قيمة الخصم في حالة النسبة المئوية
            'offer_message' => 'required|string', // نص رسالة العرض
            'offer_title' => 'required|string|max:255', // عنوان العرض
            'offer_platform' => 'required|string|max:255', // المنصة التي يُطبق عليها العرض
            'offer_start_date' => 'required|date', // تاريخ بدء العرض
            'offer_end_date' => 'required|date|after_or_equal:offer_start_date', // تاريخ نهاية العرض
            'is_active' => 'required|boolean', // حالة تفعيل العرض
            'offer_type_id' => 'required|exists:offer_types,id', // معرف نوع العرض
        ]);
    
        // إنشاء عرض Buy Get Offer وتخزينه في قاعدة البيانات
        $buyGetOffer = BuyGetOffer::create([
            'product_x_id' => $validatedData['product_x_id'],
            'product_y_id' => $validatedData['product_y_id'],
            'quantity_x' => $validatedData['quantity_x'],
            'quantity_y' => $validatedData['quantity_x'],
            'discount_type' => $validatedData['discount_type'],
            'discount_value' => $validatedData['discount_value'],
            'offer_message' => $validatedData['offer_message'],
        ]);
    
        // إنشاء عرض SpecialOffer وتخزينه في قاعدة البيانات
        $specialOffer = SpecialOffer::create([
            'offer_title' => $validatedData['offer_title'],
            'offer_platform' => $validatedData['offer_platform'],
            'offer_start_date' => $validatedData['offer_start_date'],
            'offer_end_date' => $validatedData['offer_end_date'],
            'is_active' => $validatedData['is_active'],
            'offer_type_id' => $validatedData['offer_type_id'],
        ]);
    
        // إعادة التوجيه أو إرجاع رسالة نجاح
        return response()->json([
            'message' => 'Buy Get Offer and Special Offer created successfully!',
            'buy_get_offer' => $buyGetOffer,
            'special_offer' => $specialOffer
        ], 201);
    }
    
}

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => 'ข้อมูล :attribute ต้องผ่านการยอมรับก่อน',
    'uploaded'             => 'ข้อมูล :attribute ต้องถูกต้อง',
    'active_url'           => 'ข้อมูล :attribute ต้องเป็น URL เท่านั้น',
    'after'                => 'ข้อมูล :attribute ต้องเป็นวันที่หลังจาก :date.',
    'alpha'                => 'ข้อมูล :attribute ต้องเป็นตัวอักษรภาษาอังกฤษเท่านั้น',
    'alpha_dash'           => 'ข้อมูล :attribute ต้องเป็นตัวอักษรภาษาอังกฤษ ตัวเลข และ _ เท่านั้น',
    'alpha_num'            => 'ข้อมูล :attribute ต้องเป็นตัวอักษรภาษาอังกฤษ ตัวเลข เท่านั้น',
    'array'                => 'ข้อมูล :attribute ต้องเป็น array เท่านั้น',
    'before'               => 'ข้อมูล :attribute ต้องเป็นวันที่ก่อน :date.',
    'between'              => [
        'numeric' => 'ข้อมูล :attribute ต้องอยู่ในช่วงระหว่าง :min - :max.',
        'file'    => 'ข้อมูล :attribute ต้องอยู่ในช่วงระหว่าง :min - :max กิโลไบต์',
        'string'  => 'ข้อมูล :attribute ต้องอยู่ในช่วงระหว่าง :min - :max ตัวอักษร',
        'array'   => 'ข้อมูล :attribute ต้องอยู่ในช่วงระหว่าง :min - :max ค่า',
    ],
    'boolean'              => 'ข้อมูล :attribute ต้องเป็นจริง หรือเท็จ เท่านั้น',
    'confirmed'            => 'ข้อมูล :attribute ไม่ตรงกัน',
    'date'                 => 'ข้อมูล :attribute ต้องเป็นวันที่',
    'date_format'          => 'ข้อมูล :attribute ไม่ตรงกับข้อมูลกำหนด :format.',
    'different'            => 'ข้อมูล :attribute และ :other ต้องไม่เท่ากัน',
    'digits'               => 'ข้อมูล :attribute ต้องเป็น :digits',
    'digits_between'       => 'ข้อมูล :attribute ต้องอยู่ในช่วงระหว่าง :min ถึง :max',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'ข้อมูล :attribute มีค่าที่ซ้ำกัน',
    'email'                => 'ข้อมูล :attribute ต้องเป็นอีเมล์',
    'exists'               => 'ข้อมูล ที่ถูกเลือกจาก :attribute ไม่ถูกต้อง',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'ข้อมูล :attribute จำเป็นต้องกรอก',
    'hash'                 => 'ข้อมูล :attribute ไม่ตรงกับรหัสผ่านปัจจุบันที่ใช้อยู่',
    'image'                => 'ข้อมูล :attribute ต้องเป็นรูปภาพ',
    'in'                   => 'ข้อมูล ที่ถูกเลือกใน :attribute ไม่ถูกต้อง',
    'in_array'             => 'ข้อมูล :attribute ไม่มีอยู่ภายในค่าของ :other',
    'integer'              => 'ข้อมูล :attribute ต้องเป็นตัวเลข',
    'ip'                   => 'ข้อมูล :attribute ต้องเป็น IP',
    'json'                 => 'ข้อมูล :attribute ต้องเป็นอักขระ JSON ที่สมบูรณ์',
    'max'                  => [
        'numeric' => 'ข้อมูล :attribute ต้องมีจำนวนไม่เกิน :max.',
        'file'    => 'ข้อมูล :attribute ต้องมีจำนวนไม่เกิน :max กิโลไบต์',
        'string'  => 'ข้อมูล :attribute ต้องมีจำนวนไม่เกิน :max ตัวอักษร',
        'array'   => 'ข้อมูล :attribute ต้องมีจำนวนไม่เกิน :max ค่า',
    ],
    'mimes'                => 'ข้อมูล :attribute ต้องเป็นชนิดไฟล์: :values.',
    'min'                  => [
        'numeric' => 'ข้อมูล :attribute ต้องมีจำนวนอย่างน้อย :min.',
        'file'    => 'ข้อมูล :attribute ต้องมีจำนวนอย่างน้อย :min กิโลไบต์',
        'string'  => 'ข้อมูล :attribute ต้องมีจำนวนอย่างน้อย :min ตัวอักษร',
        'array'   => 'ข้อมูล :attribute ต้องมีจำนวนอย่างน้อย :min ค่า',
    ],
    'not_in'               => 'ข้อมูล ที่เลือกจาก :attribute ไม่ถูกต้อง',
    'numeric'              => 'ข้อมูล :attribute ต้องเป็นตัวเลข',
    'present'              => 'ข้อมูล :attribute ต้องเป็นปัจจุบัน',
    'regex'                => 'ข้อมูล :attribute มีรูปแบบไม่ถูกต้อง',
    'required'             => 'ข้อมูล :attribute จำเป็นต้องกรอก',
    'required_if'          => 'ข้อมูล :attribute จำเป็นต้องกรอกเมื่อ :other เป็น :value.',
    'required_unless'      => 'ข้อมูล :attribute จำเป็นต้องกรอกเว้นแต่ :other เป็น :values.',
    'required_with'        => 'ข้อมูล :attribute จำเป็นต้องกรอกเมื่อ :values มีค่า',
    'required_with_all'    => 'ข้อมูล :attribute จำเป็นต้องกรอกเมื่อ :values มีค่าทั้งหมด',
    'required_without'     => 'ข้อมูล :attribute จำเป็นต้องกรอกเมื่อ :values ไม่มีค่า',
    'required_without_all' => 'ข้อมูล :attribute จำเป็นต้องกรอกเมื่อ :values ไม่มีค่าทั้งหมด',
    'same'                 => 'ข้อมูล :attribute และ :other ต้องถูกต้อง',
    'size'                 => [
        'numeric' => 'ข้อมูล :attribute ต้องเท่ากับ :size',
        'file'    => 'ข้อมูล :attribute ต้องเท่ากับ :size กิโลไบต์',
        'string'  => 'ข้อมูล :attribute ต้องเท่ากับ :size ตัวอักษร',
        'array'   => 'ข้อมูล :attribute ต้องเท่ากับ :size ค่า',
    ],
    'string'               => 'ข้อมูล :attribute ต้องเป็นอักขระ',
    'timezone'             => 'ข้อมูล :attribute ต้องเป็นข้อมูลเขตเวลาที่ถูกต้อง',
    'unique'               => 'ข้อมูล :attribute ไม่สามารถใช้ได้',
    'url'                  => 'ข้อมูล :attribute ไม่ถูกต้อง',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'productcategory_title_en' => 'กลุ่มสินค้า(อังกฤษ)',
        'productcategory_title_th' => 'กลุ่มสินค้า(ไทย)',
        'productcategory_description_en' => 'รายละเอียดกลุ่มสินค้า(อังกฤษ)',
        'productcategory_description_th' => 'รายละเอียดกลุ่มสินค้า(ไทย)',
        'sequence' => 'การเรียงลำดับข้อมูล',
        'email' => 'อีเมล์',
        'password' => 'รหัสผ่าน',
        'rememberme' => 'จำฉันไว้ในระบบ',
        'btnLogin' => 'เข้าสู่ระบบ',
        'slideimage_name' => 'รูปภาพ',
        'slideimage_file' => 'ไฟล์รูป',
        'slideimage_type' => 'ประเภทสไลด์',
        'slideimage_urllink' => 'การเชื่อมโยง',
        'downloaddocument_title_en' => 'ดาวน์โหลดเอกสาร(อังกฤษ)',
        'downloaddocument_title_th' => 'ดาวน์โหลดเอกสาร(ไทย)',
        'downloaddocument_description_en' => 'รายละเอียดดาวน์โหลด(อังกฤษ)',
        'downloaddocument_description_th' => 'รายละเอียดดาวน์โหลด(ไทย)',
        'downloaddocument_file' => 'ไฟล์เอกสาร',
        'aboutus_description_th' => 'เกี่ยวกับเรา(ไทย)',
        'aboutus_description_en' => 'เกี่ยวกับเรา(อังกฤษ)',
        'contactus_address_th' => 'ที่อยู่(ไทย)',
        'contactus_address_en' => 'ที่อยู่(อังกฤษ)',
        'contactus_latitude' => 'ละติจูด',
        'contactus_longitude' => 'ลองจิจูด',
        'created_at' => 'วันที่ทำรายการ',
        'contactusform_subject' => 'หัวเรื่อง',
        'contactusform_messagebox' => 'รายละเอียด',
        'contactusform_name' => 'ชื่อ',
        'contactusform_surname' => 'นามสกุล',
        'contactusform_email' => 'อีเมล์',
        'contactusform_phone' => 'เบอร์โทร',
        'contactusform_file' => 'ไฟล์เอกสารแนบ',
        'faqcategory_title_en' => 'ประเภทคำถามที่พบบ่อย(อังกฤษ)',
        'faqcategory_title_th' => 'ประเภทคำถามที่พบบ่อย(ไทย)',
        'faqcategory_description_en' => 'รายละเอียดกลุ่มสินค้า(อังกฤษ)',
        'faqcategory_description_th' => 'รายละเอียดกลุ่มสินค้า(ไทย)',
        'faq_question_en' => 'คำถามที่พบบ่อย(อังกฤษ)',
        'faq_question_th' => 'คำถามที่พบบ่อย(ไทย)',
        'faq_answer_en' => 'คำตอบ(อังกฤษ)',
        'faq_answer_th' => 'คำตอบ(ไทย)',
        'media_name_th' => 'ชื่อมีเดีย(ไทย)',
        'media_name_en' => 'ชื่อมีเดีย(อังกฤษ)',
        'media_urllink' => 'ที่อยู่ของมีเดีย',
        'now_password' => 'รหัสผ่านเดิม',
        'new_password' => 'รหัสผ่านใหม่',
        'password_confirmation' => 'ยืนยันรหัสผ่าน',
        'users_firstname_th' => 'ชื่อ(ไทย)',
        'users_lastname_th' => 'นามสกุล(ไทย)',
        'users_firstname_en' => 'ชื่อ(อังกฤษ)',
        'users_lastname_en' => 'นามสกุล(อังกฤษ)',
        'users_mobilephone' => 'เบอร์มือถือ',
        'users_phone' => 'เบอร์โทร',
        'users_fax' => 'โทรสาร',
        'iwantto' => 'ต้องการขาย/ซื้อ',
        'users_idcard' => 'รหัสบัตรประชาชน/พาสปอร์ต',
        'users_dateofbirth' => 'วันเกิด',
        'users_gender' => 'เพศ',
        'users_addressname' => 'ที่อยู่',
        'users_street' => 'ถนน',
        'users_district' => 'ตำบล',
        'users_city' => 'อำเภอ',
        'users_province' => 'จังหวัด',
        'users_postcode' => 'รหัสไปรษณีย์',
        'users_qrcode' => 'รหัสผู้ประกอบการระบบ QR Trace ของ มกอช',
        'users_taxcode' => 'เลขประจำตัวผู้เสียภาษี',
        'users_company_th' => 'ชื่อบริษัท(ไทย)',
        'users_company_en' => 'ชื่อบริษัท(อังกฤษ)',
        'users_latitude' => 'ละติจูด',
        'users_longitude' => 'ลองจิจูด',
        'users_imageprofile' => 'รูปภาพส่วนตัว',
        'is_active' => 'เปิดใช้งาน',
        'market_title_th' => 'ตลาด(ไทย)',
        'market_title_en' => 'ตลาด(อังกฤษ)',
        'market_description_th' =>  'รายละเอียดตลาด(ไทย)',
        'market_description_en' =>  'รายละเอียดตลาด(อังกฤษ)',
        'marketimage_file' => 'ไฟล์รูปภาพ',
        'name' => 'ชื่อ - นามสกุล',
        'product_name_th'=> 'สินค้า(ไทย)',
        'product_name_en'=> 'สินค้า(อังกฤษ)',
        'news_title_th'=> 'หัวข้อข่าว(ไทย)',
        'news_title_en'=> 'หัวข้อข่าว(อังกฤษ)',
        'news_created_at'=> 'วันที่',
        'news_description_th'=> 'เนื้อหาข่าว(ไทย)',
        'news_description_en'=> 'เนื้อหาข่าว(อังกฤษ)',
        'news_place'=> 'สถานที่จัด',
        'news_tags'=> 'ประเภทข่าว',
        'news_sponsor'=> 'ผู้จัด',
        'news_document_file'=> 'ไฟล์เอกสาร',
        'product_title'=> 'ยี่ห้อ',
        'product_description'=> 'รายละเอียดสินค้า',
        'guarantee'=> 'มาตรฐานสินค้า(เพิ่มเติม)',
        'price'=> 'ราคาต่อหน่วย(บาท)',
        'discount'=> 'ส่วนลด(บาท)',
        'is_showprice'=> 'แสดงราคา',
        'volumn'=> 'ปริมาณ',
        'product1_file'=> 'รูปภาพสินค้า 1',
        'product2_file'=> 'รูปภาพสินค้า 2',
        'product3_file'=> 'รูปภาพสินค้า 3',
        'productstatus'=> 'สถานะรายการสินค้า',
        'pricerange_start'=> 'ราคาเริ่มต้น',
        'pricerange_end'=> 'ราคาสิ้นสุด',
        'volumnrange_start'=> 'ปริมาณเริ่มต้น',
        'volumnrange_end'=> 'ปริมาณสิ้นสุด',
        'units'=> 'หน่วยนับ',
        'city'=> 'อำเภอ',
        'province'=> 'จังหวัด',
        'productcategorys_id'=> 'กลุ่มสินค้า',
        'products_id'=> 'สินค้า',
        'users_id'=> 'ผู้ใช้งาน',
        'shop_title'=> 'หัวเรื่อง',
        'shop_subtitle'=> 'หัวเรื่องย่อย',
        'shop_description'=> 'รายละเอียด',
        'shop_theme_image' => 'รูปภาพธีมที่',
        'shop_name' => 'URL ร้านค้า',
        'promotion_title' => 'โปรโมรชั่น',
        'promotion_description' => 'รายละเอียดโปรโมรชั่น',
        'promotion_start_date' => 'วันเริ่มต้นโปรโมรชั่น',
        'promotion_end_date' => 'วันสิ้นสุดโปรโมรชั่น',
        'promotion_image' => 'รูปภาพโปรโมรชั่น',
        'product_package_size' => 'ขนาดบรรจุ',
        'product_grade' => 'เกรด',
        'product_province_source' => 'แหล่งผลิด(จังหวัด)',
        'selling_period' => 'ช่วงเวลาจำหน่าย',
        'product_province_selling' => 'สถานที่จำหน่าย(จังหวัด)',
        'product_selling_start_date' => 'วันเริ่มต้นจำหน่าย',
        'product_selling_end_date' => 'วันสิ้นสุดจำหน่าย',
    ],

];

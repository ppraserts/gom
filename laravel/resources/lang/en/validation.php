<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'uploaded'             => 'The :attribute must be correct.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field is required.',
    'hash'                 => 'The :attribute doesn\'t match current password.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',

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

    'custom' => [
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
        'productcategory_title_en' => 'Product Category(EN)',
        'productcategory_title_th' => 'Product Category(TH)',
        'productcategory_description_en' => 'Description(EN)',
        'productcategory_description_th' => 'Description(TH)',
        'sequence' => 'Sequence',
        'email' => 'E-mail',
        'password' => 'Password',
        'rememberme' => 'Remember Me',
        'btnLogin' => 'Login',
        'slideimage_name' => 'Image Name',
        'slideimage_file' => 'Image File',
        'slideimage_type' => 'Slide Type',
        'slideimage_urllink' => 'External Link',
        'downloaddocument_title_en' => 'Download Document(EN)',
        'downloaddocument_title_th' => 'Download Document(TH)',
        'downloaddocument_description_en' => 'Description(EN)',
        'downloaddocument_description_th' => 'Description(TH)',
        'downloaddocument_file' => 'Document File',
        'aboutus_description_th' => 'Description(EN)',
        'aboutus_description_en' => 'Description(TH)',
        'contactus_address_th' => 'Address(TH)',
        'contactus_address_en' => 'Address(EN)',
        'contactus_latitude' => 'Latitude',
        'contactus_longitude' => 'Longitude',
        'created_at' => 'Create At',
        'contactusform_subject' => 'Subject',
        'contactusform_messagebox' => 'Message',
        'contactusform_name' => 'Name',
        'contactusform_surname' => 'Surname',
        'contactusform_email' => 'Email',
        'contactusform_phone' => 'Phone',
        'contactusform_file' => 'Attached File',
        'faqcategory_title_en' => 'FAQ Category(EN)',
        'faqcategory_title_th' => 'FAQ Category(TH)',
        'faqcategory_description_en' => 'Description(EN)',
        'faqcategory_description_th' => 'Description(TH)',
        'faq_question_en' => 'FAQ Question(EN)',
        'faq_question_th' => 'FAQ Question(TH)',
        'faq_answer_en' => 'FAQ Answer(EN)',
        'faq_answer_th' => 'FAQ Answer(TH)',
        'media_name_th' => 'Media Name(TH)',
        'media_name_en' => 'Media Name(EN)',
        'media_urllink' => 'Media Url',
        'now_password' => 'Current Password',
        'new_password' => 'New Password',
        'password_confirmation' => 'Confirm Password',
        'users_firstname_th' => 'Firstname(TH)',
        'users_lastname_th' => 'Lastname(TH)',
        'users_firstname_en' => 'Firstname(EN)',
        'users_lastname_en' => 'Lastname(EN)',
        'users_mobilephone' => 'Mobile Phone',
        'users_phone' => 'Phone',
        'users_fax' => 'Fax',
        'iwantto' => 'I want to',
        'users_idcard' => 'ID Card/Passport',
        'users_dateofbirth' => 'Date of birth',
        'users_gender' => 'Gender',
        'users_addressname' => 'Address',
        'users_street' => 'Street',
        'users_district' => 'District',
        'users_city' => 'City',
        'users_province' => 'Province',
        'users_postcode' => 'Postcode',
        'users_qrcode' => 'QR Code',
        'users_taxcode' => 'Tax Code',
        'users_company_th' => 'Company Name(TH)',
        'users_company_en' => 'Company Name(EN)',
        'users_latitude' => 'Latitude',
        'users_longitude' => 'Longitude',
        'users_imageprofile' => 'Image Profile',
        'is_active' => 'Active',
        'market_title_th' => 'Market(TH)',
        'market_title_en' => 'Market(EN)',
        'market_description_th' =>  'Description(TH)',
        'market_description_en' =>  'Description(EN)',
        'marketimage_file' => 'Image File',
        'name' => 'Fullname',
        'product_name_th'=> 'Product Name(TH)',
        'product_name_en'=> 'Product Name(EN)',
        'news_title_th'=> 'News Title(TH)',
        'news_title_en'=> 'News Title(EN)',
        'news_created_at'=> 'Date',
        'news_description_th'=> 'Description(TH)',
        'news_description_en'=> 'Description(EN)',
        'news_place'=> 'Place',
        'news_tags'=> 'Tags',
        'news_sponsor'=> 'Sponsor',
        'news_document_file'=> 'File',
        'product_title'=> 'Product Title',
        'product_description'=> 'Description',
        'guarantee'=> 'Guarantee',
        'price'=> 'Price',
        'is_showprice'=> 'Show Price',
        'volumn'=> 'Volume',
        'product1_file'=> 'Image File1',
        'product2_file'=> 'Image File2',
        'product3_file'=> 'Image File3',
        'productstatus'=> 'Product Status',
        'pricerange_start'=> 'Price Start',
        'pricerange_end'=> 'Price End',
        'volumnrange_start'=> 'Volume Start',
        'volumnrange_end'=> 'Volume End',
        'units'=> 'Unit',
        'city'=> 'City',
        'province'=> 'Province',
        'productcategorys_id'=> 'Product Category',
        'products_id'=> 'Product',
        'shop_title'=> 'Title',
        'shop_subtitle'=> 'Sub Title',
        'shop_description'=> 'Description',
        'shop_slide_image' => 'Shop Image',
    ],

];

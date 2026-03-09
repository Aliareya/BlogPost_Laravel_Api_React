<?php

return [
    'paths' => ['api/*'],                   // مسیرهایی که CORS روی آن‌ها فعال شود
    'allowed_methods' => ['*'],             // اجازه تمام متدها: GET, POST, PUT...
    'allowed_origins' => ['http://localhost:5173'], // آدرس فرانت‌اند React
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],             // همه هدرها اجازه دارند
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,         // ضروری برای ارسال کوکی‌ها
];
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Review Mode
    |--------------------------------------------------------------------------
    |
    | Bu ayar, uygulama inceleme modundayken ödeme seçeneklerinin
    | gösterilip gösterilmeyeceğini belirler.
    | true: İnceleme modu aktif, ödeme seçenekleri gizlenir
    | false: Normal mod, ödeme seçenekleri gösterilir
    |
    */

    'enabled' => env('REVIEW_MODE', false),
]; 
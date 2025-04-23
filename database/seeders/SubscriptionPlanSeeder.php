<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Temel Paket',
                'slug' => 'temel-paket',
                'description' => 'Mobil uygulamanızın temel özellikleriyle başlayın.',
                'price' => 99.90,
                'currency' => 'TRY',
                'billing_period' => 'monthly',
                'trial_days' => 7,
                'iyzico_plan_reference' => '',
                'features' => json_encode([
                    'Sınırsız istek',
                    'Temel analizler',
                    'E-posta desteği',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Profesyonel Paket',
                'slug' => 'profesyonel-paket',
                'description' => 'İşletmenizi büyütmek için profesyonel özellikler.',
                'price' => 199.90,
                'currency' => 'TRY',
                'billing_period' => 'monthly',
                'trial_days' => 7,
                'iyzico_plan_reference' => '',
                'features' => json_encode([
                    'Sınırsız istek',
                    'Gelişmiş analizler',
                    'Öncelikli e-posta desteği',
                    'API erişimi',
                    'Özel entegrasyonlar',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Kurumsal Paket',
                'slug' => 'kurumsal-paket',
                'description' => 'Büyük işletmeler için tam kapsamlı çözüm.',
                'price' => 499.90,
                'currency' => 'TRY',
                'billing_period' => 'monthly',
                'trial_days' => 7,
                'iyzico_plan_reference' => '',
                'features' => json_encode([
                    'Sınırsız istek',
                    'Tam analitik dashboard',
                    '7/24 Destek',
                    'Tam API erişimi',
                    'Özel entegrasyonlar',
                    'Özel geliştirmeler',
                    'Ayrılmış kaynaklar',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Temel Paket (Yıllık)',
                'slug' => 'temel-paket-yillik',
                'description' => 'Mobil uygulamanızın temel özellikleriyle başlayın. Yıllık ödeyin, 2 ay ücretsiz kullanın!',
                'price' => 999.00,
                'currency' => 'TRY',
                'billing_period' => 'yearly',
                'trial_days' => 7,
                'iyzico_plan_reference' => '',
                'features' => json_encode([
                    'Sınırsız istek',
                    'Temel analizler',
                    'E-posta desteği',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Profesyonel Paket (Yıllık)',
                'slug' => 'profesyonel-paket-yillik',
                'description' => 'İşletmenizi büyütmek için profesyonel özellikler. Yıllık ödeyin, 2 ay ücretsiz kullanın!',
                'price' => 1999.00,
                'currency' => 'TRY',
                'billing_period' => 'yearly',
                'trial_days' => 7,
                'iyzico_plan_reference' => '',
                'features' => json_encode([
                    'Sınırsız istek',
                    'Gelişmiş analizler',
                    'Öncelikli e-posta desteği',
                    'API erişimi',
                    'Özel entegrasyonlar',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Kurumsal Paket (Yıllık)',
                'slug' => 'kurumsal-paket-yillik',
                'description' => 'Büyük işletmeler için tam kapsamlı çözüm. Yıllık ödeyin, 2 ay ücretsiz kullanın!',
                'price' => 4999.00,
                'currency' => 'TRY',
                'billing_period' => 'yearly',
                'trial_days' => 7,
                'iyzico_plan_reference' => '',
                'features' => json_encode([
                    'Sınırsız istek',
                    'Tam analitik dashboard',
                    '7/24 Destek',
                    'Tam API erişimi',
                    'Özel entegrasyonlar',
                    'Özel geliştirmeler',
                    'Ayrılmış kaynaklar',
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('supabase_user_id');
            $table->foreignId('subscription_plan_id')->constrained();
            $table->string('iyzico_subscription_reference')->nullable();
            $table->string('status'); // active, canceled, expired, pending, trial
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('current_period_starts_at');
            $table->timestamp('current_period_ends_at');
            $table->timestamp('canceled_at')->nullable();
            $table->boolean('cancel_at_period_end')->default(false);
            $table->timestamps();
            
            $table->index('supabase_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

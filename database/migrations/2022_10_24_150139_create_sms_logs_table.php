<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->date('send_date');
            $table->string('number', 20);
            $table->string('sender', 20);
            $table->text('message');
            $table->string('campaign', 50);
            $table->string('client_ip', 50);
            $table->string('credits', 5);
            $table->string('status', 10);
            $table->text('full_status');
            $table->string('provider', 20);
            $table->string('sms_type', 20);
            $table->string('contract_type', 20);
            $table->string('company', 20);
            $table->string('sms_sender_user', 20);
            $table->string('port', 3);
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
        Schema::dropIfExists('sms_logs');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityGuardsTable extends Migration
{
    public function up()
    {
        Schema::create('security_guards', function (Blueprint $table) {
            $table->id('securityId');
            $table->string('securityName', 100);
            $table->string('guard_username', 50)->unique(); // Make the 'guard_username' column unique
            $table->string('api_token', 80)->nullable();
            $table->string('guard_password', 255); // Consider using Hash::make for passwords and not storing them as plain text

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('security_guards');
    }
}

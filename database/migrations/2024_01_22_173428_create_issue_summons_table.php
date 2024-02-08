<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueSummonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_summons', function (Blueprint $table) {
            $table->id('summonId');
            $table->string('violation', 255);
            $table->decimal('fineAmount', 8, 2); // Precision and scale for the decimal
            $table->date('dueDate')->nullable();
            $table->string('issuedBy', 100)->nullable();
            $table->string('status', 5)->nullable();
            $table->string('QRCodeId', 100); // Foreign key to students table
            $table->foreignID('securityId'); // Foreign key to security_guards table

            // Define foreign keys
            $table->foreign('QRCodeId')->references('QRCodeId')->on('students')
                ->onDelete('cascade');
            $table->foreign('securityId')->references('securityId')->on('security_guards')
                ->onDelete('cascade');

            $table->timestamps(); // Optional, if you want timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_summons');
    }
}

<?php

use App\Models\File;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Office;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->longText('contents');
            $table->foreignIdFor(Office::class)->references('id')->on('offices');
            $table->string('title');
            $table->string('description')->comment('description');
            $table->string('slug')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['slug', 'office_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};

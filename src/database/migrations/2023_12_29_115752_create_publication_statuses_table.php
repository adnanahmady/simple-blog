<?php

use App\Models\PublicationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create(
            PublicationStatus::TABLE,
            function (Blueprint $table): void {
                $table->id(PublicationStatus::ID);
                $table->string(PublicationStatus::TITLE);
                $table->timestamps();
            }
        );
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists(PublicationStatus::TABLE);
    }
};

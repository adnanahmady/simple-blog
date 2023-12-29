<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create(User::TABLE, function (Blueprint $table): void {
            $table->id(User::ID);
            $table->string(User::NAME);
            $table->string(User::EMAIL)->unique();
            $table->timestamp(User::EMAIL_VERIFIED_AT)->nullable();
            $table->string(User::PASSWORD);
            $table->boolean(User::IS_ADMIN)->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists(User::TABLE);
    }
};

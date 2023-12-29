<?php

use App\Models\Article;
use App\Models\PublicationStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create(Article::TABLE, function (Blueprint $table): void {
            $table->id(Article::ID);
            $table->string(Article::TITLE);
            $table->text(Article::CONTENT);
            $table->unsignedBigInteger(Article::AUTHOR);
            $table->unsignedBigInteger(Article::STATUS);
            $table->timestamp(Article::PUBLICATION_DATE)->nullable();
            $table->timestamps();

            $table->foreign(Article::AUTHOR)
                ->on(User::TABLE)
                ->references(User::ID)
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign(Article::STATUS)
                ->on(PublicationStatus::TABLE)
                ->references(PublicationStatus::ID)
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::table(Article::TABLE, function (Blueprint $table): void {
            $table->dropForeign([Article::AUTHOR]);
            $table->dropForeign([Article::STATUS]);
        });
        Schema::dropIfExists(Article::TABLE);
    }
};

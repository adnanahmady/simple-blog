<?php

namespace App\Models;

use App\Traits\HasConstantAsFieldTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method int       id()
 * @method string    title()
 * @method string    content()
 * @method \DateTime publicationDate()
 */
class Article extends Model
{
    use HasFactory;
    use HasConstantAsFieldTrait;

    public const TABLE = 'articles';
    public const ID = 'id';
    public const TITLE = 'title';
    public const CONTENT = 'content';
    public const AUTHOR = 'author_id';
    public const STATUS = 'status_id';
    public const PUBLICATION_DATE = 'publication_date';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    protected $fillable = [
        self::TITLE,
        self::CONTENT,
        self::AUTHOR,
        self::STATUS,
        self::PUBLICATION_DATE,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            self::AUTHOR,
            User::ID
        );
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(
            PublicationStatus::class,
            self::STATUS,
            PublicationStatus::ID
        );
    }
}

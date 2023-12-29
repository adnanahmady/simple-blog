<?php

namespace App\Models;

use App\Traits\HasConstantAsFieldTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method int    id()
 * @method string title()
 */
class PublicationStatus extends Model
{
    use HasFactory;
    use HasConstantAsFieldTrait;

    public const TABLE = 'publication_statuses';
    public const ID = 'id';
    public const TITLE = 'title';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    protected $fillable = [
        self::TITLE,
    ];
}

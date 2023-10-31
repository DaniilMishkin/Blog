<?php

namespace App\Models;

use App\Enums\AttachmentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'type',
    ];

    protected $casts = [
        'type' => AttachmentTypeEnum::class,
    ];
}

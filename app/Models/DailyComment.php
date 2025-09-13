<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyComment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'daily_note_id',
        'commenter_id',
        'comment',
        'is_partner_of_the_day',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_partner_of_the_day' => 'boolean',
    ];

    /**
     * コメントした看護師
     */
    public function commenter()
    {
        return $this->belongsTo(User::class, 'commenter_id');
    }

    /**
     * コメント先の日々の振り返り
     */
    public function dailyNote()
    {
        return $this->belongsTo(DailyNote::class);
    }
}

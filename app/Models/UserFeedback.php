<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserFeedback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'target_id',
        'content',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'source_id' => 'integer',
        'target_id' => 'integer',
    ];

    public static function getFeedbackFromUser($source_id, $target_id)
    {
        $feedback = 
            DB::table('user_feedback')
            ->select('source_id', 'target_id', 'content', 'value')
            ->where('source_id', '=', $source_id)
            ->where('target_id', '=', $target_id)
            ->get()
            ->first();

        return $feedback;
    }

    public static function getFeedbackList($target_id)
    {
        $feedback = 
            DB::table('user_feedback')
            ->select('source_id', 'target_id', 'user_feedback.content', 'user_feedback.value', 'user_feedback.updated_at',
            'users.name'
            )
            ->where('target_id', '=', $target_id)
            ->leftJoin('users', 'users.id', '=', 'source_id')
            ->get()
            ->all();

        return $feedback;
    }
}

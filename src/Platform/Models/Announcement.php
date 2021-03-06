<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Parsedown;
use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Announcement extends Model
{
    use LogsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'announcements';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'content',
        'active',
    ];

    /**
     * @var string
     */
    protected static $logAttributes = ['*'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['parsed_content'];

    /**
     * Get the user that created the announcement.
     */
    public function author()
    {
        return $this->belongsTo(Dashboard::model(User::class), 'user_id');
    }

    /**
     * Get the parsed body of the announcement.
     *
     * @return string
     */
    public function getParsedContentAttribute()
    {
        return (new Parsedown)->text(htmlspecialchars($this->attributes['content']));
    }

    /**
     * Scope a query to only include active announcements.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Turns off all announcements.
     *
     * @return int
     */
    public static function disableAll()
    {
        return DB::table('announcements')->update(['active' => 0]);
    }

    /**
     * @return mixed
     */
    public static function getActive()
    {
        return self::active()->first();
    }
}

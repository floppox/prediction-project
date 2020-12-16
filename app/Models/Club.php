<?php

namespace App\Models;

use App\Enums\MeetStatus;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Club
 *
 * @property int $id
 * @property string $name
 * @property int $notional_strength
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Meet[] $meets
 * @property-read int|null $meets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TournamentTableEntry[] $tournamentTableEntries
 * @property-read int|null $tournament_table_entries_count
 * @method static \Illuminate\Database\Eloquent\Builder|Club newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Club newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Club query()
 * @method static \Illuminate\Database\Eloquent\Builder|Club search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Club searchLatestPaginated(string $search, string $paginationQuantity = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereNotionalStrength($value)
 * @mixin \Eloquent
 */
class Club extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'notional_strength'];

    protected $searchableFields = ['*'];

    public $timestamps = false;

    public function tournamentTableEntry(): HasOne
    {
        return $this->hasOne(TournamentTableEntry::class);
    }

    public function meets()
    {
        return $this->belongsToMany(Meet::class)->withPivot(
            'host_or_guest',
            'score',
            'missed_score',
            'points',
            'result'
        );
    }

    public function meetsToPlay()
    {
        return $this->meets()->where('status', MeetStatus::FIXTURE);
    }
}

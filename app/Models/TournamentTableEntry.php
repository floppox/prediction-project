<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TournamentTableEntry
 *
 * @property int $id
 * @property int $club_id
 * @property int $position
 * @property int $played
 * @property int $won
 * @property int $drawn
 * @property int $lost
 * @property int $gf
 * @property int $ga
 * @property int $gd
 * @property int $points
 * @property-read \App\Models\Club $club
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry searchLatestPaginated(string $search, string $paginationQuantity = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry whereDrawn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry whereGa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry whereGd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry whereGf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry whereLost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry wherePlayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentTableEntry whereWon($value)
 * @mixin \Eloquent
 */
class TournamentTableEntry extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'club_id',
        'played',
        'won',
        'drawn',
        'lost',
        'gf',
        'ga',
        'gd',
        'points',
        'position'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'tournament_table_entries';

    public $timestamps = false;

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function setPosition(int $value): self
    {
        $this->position = $value;

        return $this;
    }
}

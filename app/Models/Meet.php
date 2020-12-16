<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Meet
 *
 * @property int $id
 * @property int $tour_number
 * @property string $city
 * @property string $venue
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Club[] $clubs
 * @property-read int|null $clubs_count
 * @property-read \App\Models\Club $guest_club
 * @property-read \App\Models\Club $host_club
 * @method static \Illuminate\Database\Eloquent\Builder|Meet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Meet search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Meet searchLatestPaginated(string $search, string $paginationQuantity = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|Meet whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meet whereTourNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Meet whereVenue($value)
 * @mixin \Eloquent
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|Meet whereStatus($value)
 */
class Meet extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [];

    protected $searchableFields = ['*'];

    public $timestamps = false;


    public static function createMeetForClubs(Club $hostClub, Club $guestClub, $tourNumber): self
    {
        $meet = self::factory(self::class)->create(['tour_number' => $tourNumber]);

        $meet->clubs()->attach($hostClub, [
            'host_or_guest' => 'host',
            'score' => 0,
            'points' => 0,
            'missed_score' => 0,
            'result' => '',
            ]);

        $meet->clubs()->attach($guestClub, [
            'host_or_guest' => 'guest',
            'score' => 0,
            'points' => 0,
            'missed_score' => 0,
            'result' => '',
        ]);

        return $meet;
    }

    public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class)->withPivot([
            'host_or_guest',
            'score',
            'points',
            'result'
            ]);
    }

    public function getHostClubAttribute(): ?Club
    {
        return $this->clubs()->wherePivot('host_or_guest', 'host')->first();
    }

    public function getGuestClubAttribute(): ?Club
    {
        return $this->clubs()->wherePivot('host_or_guest', 'guest')->first();
    }

    public function setHostClubResult(string $result)
    {
        $this->clubs()->updateExistingPivot($this->hostClub, ['result' => $result]);
    }

    public function setHostClubScore(int $score)
    {
        $this->clubs()->updateExistingPivot($this->hostClub, ['score' => $score]);
    }

    public function setHostClubMissedScore(int $missedScore)
    {
        $this->clubs()->updateExistingPivot($this->hostClub, ['missed_score' => $missedScore]);
    }

    public function setHostClubPoints(int $points)
    {
        $this->clubs()->updateExistingPivot($this->hostClub, ['points' => $points]);
    }

    public function setGuestClubResult(string $result)
    {
        $this->clubs()->updateExistingPivot($this->guestClub, ['result' => $result]);
    }

    public function setGuestClubScore(int $score)
    {
        $this->clubs()->updateExistingPivot($this->guestClub, ['score' => $score]);
    }

    public function setGuestClubMissedScore(int $missedScore)
    {
        $this->clubs()->updateExistingPivot($this->guestClub, ['missed_score' => $missedScore]);
    }

    public function setGuestClubPoints(int $points)
    {
        $this->clubs()->updateExistingPivot($this->guestClub, ['points' => $points]);
    }
}

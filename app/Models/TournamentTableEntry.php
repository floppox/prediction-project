<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

    protected $searchableFields = ['*'];

    protected $table = 'tournament_table_entries';

    public $timestamps = false;

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}

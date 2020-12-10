<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    use HasFactory;
    use Searchable;


    protected $fillable = ['name', 'notional_strength'];

    protected $searchableFields = ['*'];

    public $timestamps = false;

    public function tournamentTableEntries()
    {
        return $this->hasMany(TournamentTableEntry::class);
    }

    public function meets()
    {
        return $this->belongsToMany(Meet::class);
    }
}

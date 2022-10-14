<?php

namespace App\Models;

use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\TeamInvitation as JetstreamTeamInvitation;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class TeamInvitation extends JetstreamTeamInvitation
{
    use Loggable; // Uso
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Get the team that the invitation belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Jetstream::teamModel());
    }
}

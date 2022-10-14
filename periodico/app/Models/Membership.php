<?php

namespace App\Models;

use Laravel\Jetstream\Membership as JetstreamMembership;
use Haruncpi\LaravelUserActivity\Traits\Loggable; // Importacion

class Membership extends JetstreamMembership
{
    use Loggable; // Uso
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}

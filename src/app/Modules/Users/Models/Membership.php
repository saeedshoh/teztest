<?php namespace App\Modules\Users\Models;

use Laravel\Jetstream\Membership as JetStreamMembership;

class Membership extends JetStreamMembership
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}

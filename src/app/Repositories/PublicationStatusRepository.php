<?php

namespace App\Repositories;

use App\Models\PublicationStatus;

class PublicationStatusRepository
{
    public function draft(): PublicationStatus
    {
        return PublicationStatus::firstOrCreate([
            PublicationStatus::TITLE => 'draft',
        ]);
    }

    public function publish(): PublicationStatus
    {
        return PublicationStatus::firstOrCreate([
            PublicationStatus::TITLE => 'publish',
        ]);
    }
}

<?php

namespace App\Repositories\Eloquent;


use App\Models\Confirmation;

class ConfirmationRepository extends RepositoryBase
{
    public function __construct(Confirmation $confirmation)
    {
        parent::__construct($confirmation);
    }
}

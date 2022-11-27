<?php

namespace App\Mrt\Smsc\Domain\Services;

use App\Domain\Payloads\SuccessPayload;
use App\Mrt\Smsc\Domain\Repositories\SmscMessageRepository as Repository;

class WebhookService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        $this->repository->create($data);
        return new SuccessPayload(__("Log success added"), $data);
    }

}

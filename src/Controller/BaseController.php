<?php

declare(strict_types=1);

namespace PinterestApi\Controller;

use \PDO;

class BaseController
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}

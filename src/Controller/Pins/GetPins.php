<?php

declare(strict_types=1);

namespace PinterestApi\Controller\Pins;

use \PDO;

class GetPins
{
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function __invoke($request, $response)
    {
        $stmt = $this->db->prepare('select * from pins');
        $stmt->execute();
        $response->getBody()->write(json_encode($stmt->fetchAll()));
        return $response;
    }
}

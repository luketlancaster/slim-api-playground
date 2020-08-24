<?php

declare(strict_types=1);

namespace PinterestApi\Controller\Pins;

use \PDO;

class GetPins
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function __invoke($request, $response)
    {
        $queryParams = $request->getQueryParams();

        if ($queryParams && $queryParams['boardId']) {
            $stmt = $this->db->prepare('select * from pins where board_id = ?');
            $stmt->execute([$queryParams['boardId']]);
            $response->getBody()->write(json_encode($stmt->fetchAll()));
            return $response;
        }

        $stmt = $this->db->prepare('select * from pins');
        $stmt->execute();
        return $response;
    }
}

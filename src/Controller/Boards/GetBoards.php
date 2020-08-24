<?php

declare(strict_types=1);

namespace PinterestApi\Controller\Boards;

use \PDO;

class GetBoards
{

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function __invoke($request, $response)
    {
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['uid'])) {
            $response->getBody()->write(json_encode(['message' => 'uid required for get boards']));
            return $response;
        }

        $stmt = $this->db->prepare('select * from boards where uid = ?');
        $stmt->execute([$queryParams['uid']]);
        $response->getBody()->write(json_encode($stmt->fetchAll()));
        return $response;

    }
}

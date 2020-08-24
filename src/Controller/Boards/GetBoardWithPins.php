<?php

declare(strict_types=1);

namespace PinterestApi\Controller\Boards;

use \PDO;

class GetBoardWithPins
{

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function __invoke($request, $response, $args)
    {
        $queryParams = $request->getQueryParams();
        $boardId = $args['id'];

        if (!isset($queryParams['uid'])) {
            $response->getBody()->write(json_encode(['message' => 'uid required for get boards']));
            return $response;
        }

        $boardStmt = $this->db->prepare('SELECT * FROM boards WHERE uid = ? AND id = ?');
        $boardStmt->execute([$queryParams['uid'], $boardId]);
        $board = $boardStmt->fetch();


        $pinStmt = $this->db->prepare('SELECT * FROM pins WHERE board_id = ?');
        $pinStmt->execute([$boardId]);
        $pins = $pinStmt->fetchAll();

        $board['pins'] = $pins;

        $response->getBody()->write(json_encode($board));

        return $response;

    }
}

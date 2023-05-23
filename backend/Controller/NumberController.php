<?php
declare(strict_types=1);

final class NumberController implements ControllerInterface
{
    public function __construct(private readonly PDO $client, private readonly VisitorConfig $visitorConfig)
    {
    }

    public function getContent(): string
    {
        $imageId = (int)$_GET['imageId'];

        $client = $this->client;
        $query = '
        SELECT views_count
        FROM logs
        WHERE ip_address = :ip_address AND user_agent = :user_agent AND image_id = :image_id
';
        $visitorConfig = $this->visitorConfig;
        $preparedStatement = (new QueryExecutor($client))->execute($query, [
            'ip_address' => ip2long($visitorConfig->getIp()),
            'user_agent' => $visitorConfig->getUserAgent(),
            'image_id' => $imageId
        ]);
        $row = $preparedStatement->fetch();

        return (string)$row['views_count'];
    }
}
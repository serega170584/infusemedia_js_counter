<?php

class IncreaseController implements ControllerInterface
{
    public function __construct(private readonly PDO $client, private readonly VisitorConfig $visitorConfig)
    {
    }

    public function getContent(): string
    {
        try {
            $imageId = (int)$_POST['imageId'];

            $client = $this->client;
            $client->beginTransaction();

            $query = '
            SELECT *
            FROM logs
            WHERE ip_address = :ip_address AND user_agent = :user_agent AND image_id = :image_id
            FOR UPDATE
    ';
            $visitorConfig = $this->visitorConfig;
            (new QueryExecutor($client))->execute($query, [
                'ip_address' => ip2long($visitorConfig->getIp()),
                'user_agent' => $visitorConfig->getUserAgent(),
                'image_id' => $imageId
            ]);

            $query = '
        INSERT INTO logs(ip_address, user_agent, image_id, view_date, views_count)
        VALUE(:ip, :user_agent, :image_id, NOW(), 1)
        ON DUPLICATE KEY UPDATE view_date = NOW(), views_count = views_count + 1;
        ';
            (new QueryExecutor($client))->execute($query, [
                'ip' => ip2long($visitorConfig->getIp()),
                'user_agent' => $visitorConfig->getUserAgent(),
                'image_id' => $imageId
            ]);

            $client->commit();
        } catch (\Exception $e) {
            $client->rollBack();
        }
        return '';
    }
}
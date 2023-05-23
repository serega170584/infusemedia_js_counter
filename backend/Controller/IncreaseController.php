<?php

class IncreaseController implements ControllerInterface
{
    public function __construct(private readonly PDO $client, private readonly VisitorConfig $visitorConfig)
    {
    }

    public function getContent(): string
    {
        try {
            $imagePath = htmlspecialchars($_GET['imagePath']);

            $client = $this->client;
            $client->beginTransaction();

            $query = '
            SELECT *
            FROM visit
            WHERE ip = :ip AND user_agent = :user_agent AND page_url = :page_url
            FOR UPDATE
    ';
            $visitorConfig = $this->visitorConfig;
            (new QueryExecutor($client))->execute($query, [
                'ip' => ip2long($visitorConfig->getIp()),
                'user_agent' => $visitorConfig->getUserAgent(),
                'image_path' => $imagePath
            ]);

            $query = '
        INSERT INTO visit(ip, user_agent, image_path, view_date, views_count)
        VALUE(:ip, :user_agent, :image_path, NOW(), 1)
        ON DUPLICATE KEY UPDATE view_date = NOW(), views_count = views_count + 1;
        ';
            (new QueryExecutor($client))->execute($query, [
                'ip' => ip2long($visitorConfig->getIp()),
                'user_agent' => $visitorConfig->getUserAgent(),
                'image_path' => $imagePath
            ]);

            $client->commit();
        } catch (\Exception $e) {
            $client->rollBack();
        }
        return '';
    }
}
<?php
declare(strict_types=1);

final class NumberController implements ControllerInterface
{
    public function __construct(private readonly PDO $client, private readonly VisitorConfig $visitorConfig)
    {
    }

    public function getContent(): string
    {
        $imagePath = htmlspecialchars($_GET['imagePath']);

        $client = $this->client;

        $query = '
        SELECT *
        FROM visit
        WHERE ip = :ip AND user_agent = :user_agent AND page_url = :page_url
';
        $visitorConfig = $this->visitorConfig;
        $preparedStatement = (new QueryExecutor($client))->execute($query, [
            'ip' => ip2long($visitorConfig->getIp()),
            'user_agent' => $visitorConfig->getUserAgent(),
            'image_path' => $imagePath
        ]);
        $row = $preparedStatement->fetch();
        return $row['views_count'];
    }
}
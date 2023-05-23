<?php
declare(strict_types=1);

final class VisitorConfig
{
    public function __construct(private readonly string $ip, private readonly string $userAgent)
    {
    }

    public static function createFromEnv(): VisitorConfig
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        if (null === $ip) {
            throw new \Exception('Ip is empty');
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        if (null === $userAgent) {
            throw new \Exception('User agent is empty');
        }

        return new VisitorConfig($ip, $userAgent);
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }
}
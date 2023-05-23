<?php
declare(strict_types=1);

final class ImageIdController implements ControllerInterface
{
    public function getContent(): string
    {
        return (string)rand(1, 4);
    }
}
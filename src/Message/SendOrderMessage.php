<?php

namespace App\Message;

class SendOrderMessage
{
    private int $id;
    private int $volume;
    private int $weigth;

    /**
     * @param int $id
     * @param int $volume
     * @param int $weigth
     */
    public function __construct(int $id, int $volume, int $weigth)
    {
        $this->id = $id;
        $this->volume = $volume;
        $this->weigth = $weigth;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getVolume(): int
    {
        return $this->volume;
    }

    /**
     * @param int $volume
     */
    public function setVolume(int $volume): void
    {
        $this->volume = $volume;
    }

    /**
     * @return int
     */
    public function getWeigth(): int
    {
        return $this->weigth;
    }

    /**
     * @param int $weigth
     */
    public function setWeigth(int $weigth): void
    {
        $this->weigth = $weigth;
    }

}
<?php
/**
 * User: Raphael Pelissier
 * Date: 08-07-20
 * Time: 12:13
 */

namespace Discord;


class Embed
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var integer
     */
    private $color;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Embed
     */
    public function setTitle(string $title): Embed
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Embed
     */
    public function setDescription(string $description): Embed
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getColor(): ?string
    {
        if ($this->color === null) return null;
        return '#'.str_pad(dechex($this->color), 6, 0, STR_PAD_LEFT);
    }

    /**
     * @param int $color
     * @return Embed
     */
    public function setColor(string $color): Embed
    {
        if (preg_match('/(^|)(#|)([0-9A-Fa-f]{6})($|)/', $color, $matches)) {
            $this->color = hexdec($matches[3]);
            return $this;
        }
        throw new \InvalidArgumentException('argument 1 should be a valid hexadecimal color');
    }

    public function toArray()
    {
        $data = [];
        if ($this->getTitle()) $data['title'] = $this->title;
        if ($this->getDescription()) $data['description'] = $this->description;
        if ($this->getColor()) $data['color'] = $this->color;
        return $data;
    }
}

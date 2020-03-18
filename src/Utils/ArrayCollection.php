<?php


namespace App\Utils;

class ArrayCollection implements \Iterator, \Countable
{
    private $data = [];
    private $index = 0;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function add($item)
    {
        $this->data[] = $item;
        return $this;
    }

    public function get(int $index)
    {
        return $this->data[$index];
    }

    public function remove(int $index)
    {
        unset($this->data[$index]);
        //$this->data = array_values($this->data);
        return $this;
    }

    public function indexOf($value): int
    {
        return array_search($value, $this->data, true);
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->data[$this->index];
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->index += 1;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        if ($this->index <= array_key_last($this->data)) {
            while ($this->index != array_key_last($this->data) && !isset($this->data[$this->index])) {
                $this->next();
            }
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->data);
    }
}
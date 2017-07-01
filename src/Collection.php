<?php

namespace Jimenezmaximiliano\Collection;

use ArrayAccess;
use Iterator;
use Jimenezmaximiliano\Collection\Traits\ArrayAccesible;
use Jimenezmaximiliano\Collection\Traits\Iterative;

class Collection implements ArrayAccess, Iterator
{
    use ArrayAccesible;
    use Iterative;

    /** @var  array */
    private $items;

    /**
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function each(callable $callable)
    {
        foreach ($this->items as $key => $item) {
            $callable($item, $key);
        }

        return $this;
    }

    /**
     * @param mixed $item
     */
    public function push($item)
    {
        $this->items[] = $item;
    }

    /**
     * @param callable $callable
     * @return Collection
     */
    public function map(callable $callable)
    {
        $keys = array_keys($this->items);
        $items = array_map($callable, $this->items, $keys);

        return new self(
            array_combine($keys, $items)
        );
    }

    /**
     * @param array $items
     * @return Collection
     */
    public function merge($items)
    {
        return new self(
            array_merge($this->items, $items)
        );
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function put($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->all();
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasKey($key)
    {
        return in_array($key, array_keys($this->items), true);
    }

    /**
     * @param $value
     * @return bool
     */
    public function hasValue($value)
    {
        return in_array($value, array_values($this->items), true);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @param callable $callable
     * @return Collection
     */
    public function filter(callable $callable)
    {
        return new self(
            array_filter(
                $this->items,
                $callable,
                ARRAY_FILTER_USE_BOTH
            )
        );
    }

    /**
     * @param callable $callable
     * @return Collection
     */
    public function reject(callable $callable)
    {
        if ($this->isAssociative()) {
            return $this->rejectAssociative($callable);
        }

        return $this->rejectIndexed($callable);
    }

    /**
     * @return bool
     */
    private function isAssociative()
    {
        $keys = array_keys($this->items);

        return array_keys($keys) !== $keys;
    }

    /**
     * @param callable $callable
     * @return Collection
     */
    private function rejectIndexed(callable $callable)
    {
        $filtered = new self();
        foreach ($this->items as $key => $value) {
            if (!$callable($value, $key)) {
                $filtered->push($value);
            }
        }

        return $filtered;
    }

    /**
     * @param callable $callable
     * @return Collection
     */
    private function rejectAssociative(callable $callable)
    {
        $filtered = new self();
        foreach ($this->items as $key => $value) {
            if (!$callable($value, $key)) {
                $filtered->put($key, $value);
            }
        }

        return $filtered;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        reset($this->items);

        return current($this->items);
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->items[$key];
    }

    /**
     * @param string $glue
     * @return string
     */
    public function implode($glue = '')
    {
        return implode($glue, $this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @return bool
     */
    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    /**
     * @return Collection
     */
    public function keys()
    {
        return new self(array_keys($this->items));
    }

    /**
     * @return Collection
     */
    public function values()
    {
        return new self(array_values($this->items));
    }

    /**
     * @param callable $callable
     * @param null|mixed $initial
     * @return mixed
     */
    public function reduce(callable $callable, $initial = null)
    {
        return array_reduce($this->items, $callable, $initial);
    }
}

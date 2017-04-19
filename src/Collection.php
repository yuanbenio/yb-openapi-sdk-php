<?php
namespace Yuanben;

use Yuanben\Contracts\Arrayable;
use Yuanben\Contracts\Operable;
use Yuanben\Exceptions\InvalidInstanceException;
use Yuanben\Exceptions\PropertyNotExistException;

class Collection implements Arrayable, \Iterator, \Countable, Operable
{
    protected $items = array();
    protected $position = 0;
    protected $class;

    public function __construct()
    {
    }


    public function canAdd(Operable $item)
    {
        if (! $this->class || $this->count() == 0) {
            $this->class = get_class($item);

            return true;
        }

        if (! $item instanceof $this->class) {
            throw new InvalidInstanceException('Can not add different class in one collection.');
        }
    }

    public function push(Operable $item)
    {
        $this->canAdd($item);
        array_push($this->items, $item);

        return $this;
    }

    public function pop()
    {
        array_pop($this->items);

        return $this;
    }

    public function shift()
    {
        array_shift($this->items);

        return $this;
    }

    public function unShift(Operable $item)
    {
        $this->canAdd($item);
        array_unshift($this->items, $item);

        return $this;
    }

    public function first()
    {
        if ($this->isEmpty()) {
            return null;
        }

        return $this->items[0];
    }

    public function isEmpty()
    {
        return !$this->count();
    }

    public function getClass()
    {
        return $this->class;
    }

    public function toArray()
    {
        $array = array();
        foreach ($this->items as $k => $v) {
            array_push($array, $v->toArray());
        }
        return $array;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->items[$this->position];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->position += 1;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }

    public function getField()
    {
        if ($this->isEmpty()) {
            throw new PropertyNotExistException('The collection is empty.');
        }

        return call_user_func(array($this->first(), 'getField'));
    }
}

<?php declare(strict_types=1);

namespace Beethoven\Framework\Struct;

class ArrayStruct extends Struct
{
	/**
	 * @var array
	 */
	protected $data;

	public function __construct(array $data = [])
	{
		$this->data = $data;
	}

	public function has(string $property): bool
	{
		return array_key_exists($property, $this->data);
	}

	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->data);
	}

	public function offsetGet($offset)
	{
		return $this->data[$offset] ?? null;
	}

	public function offsetSet($offset, $value): void
	{
		$this->data[$offset] = $value;
	}

	public function offsetUnset($offset): void
	{
		unset($this->data[$offset]);
	}

	public function get(string $key)
	{
		return $this->offsetGet($key);
	}

	public function set($key, $value)
	{
		return $this->data[$key] = $value;
	}

	public function assign(array $options)
	{
		$this->data = array_replace_recursive($this->data, $options);

		return $this;
	}

	public function all(): array
	{
		return $this->data;
	}

	public function getData(): array
	{
		return $this->data;
	}
}

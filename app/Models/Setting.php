<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['group', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    private array $reserved = ['id', 'group', 'data', 'created_at', 'updated_at'];

    public static function getGroup(string $group): self
    {
        return static::firstOrCreate(['group' => $group], ['data' => []]);
    }

    public function getValue(string $key, mixed $default = null): mixed
    {
        return data_get($this->data, $key, $default);
    }

    // Позволяет MoonShine читать поля из data как прямые атрибуты модели
    public function getAttribute($key): mixed
    {
        if (!in_array($key, $this->reserved, true)) {
            $data = parent::getAttribute('data') ?? [];
            if (array_key_exists($key, $data)) {
                return $data[$key];
            }
        }
        return parent::getAttribute($key);
    }

    // Позволяет MoonShine писать поля (в т.ч. Image path) напрямую в data
    public function setAttribute($key, $value): mixed
    {
        if (!in_array($key, $this->reserved, true)) {
            $data = parent::getAttribute('data') ?? [];
            $data[$key] = $value;
            return parent::setAttribute('data', $data);
        }
        return parent::setAttribute($key, $value);
    }
}

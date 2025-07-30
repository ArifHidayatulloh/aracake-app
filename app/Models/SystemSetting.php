<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'setting_key',
        'setting_value',
        'description',
        'type', // Mengganti 'value_type' menjadi 'type' sesuai migrasi baru
        'is_active',
    ];

    /**
     * Dynamically retrieve attributes on the model.
     * This allows us to cast the setting_value based on the 'type' column.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($key === 'value') {
            return $this->getCastValue('setting_value');
        }
        return parent::__get($key);
    }

    /**
     * Dynamically set attributes on the model.
     * This allows us to cast the setting_value based on the 'type' column.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        if ($key === 'value') {
            $this->setCastValue('setting_value', $value);
        } else {
            parent::__set($key, $value);
        }
    }

    /**
     * Get the casted value of the setting_value attribute.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function getCastValue(string $key): mixed
    {
        $value = $this->getAttributeFromArray($key);
        switch ($this->type) { // Menggunakan kolom 'type'
            case 'int':
                return (int) $value;
            case 'decimal':
                return (float) $value;
            case 'boolean':
                return (bool) $value;
            case 'json':
                return json_decode($value, true);
            default: // 'string'
                return $value;
        }
    }

    /**
     * Set the casted value of the setting_value attribute.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    protected function setCastValue(string $key, mixed $value): void
    {
        switch ($this->type) { // Menggunakan kolom 'type'
            case 'json':
                $this->attributes[$key] = json_encode($value);
                break;
            default:
                $this->attributes[$key] = (string) $value;
        }
    }

    // Helper method to easily get a setting by key
    public static function getSetting(string $key, $default = null)
    {
        $setting = static::where('setting_key', $key)->first();
        if ($setting) {
            return $setting->value; // Menggunakan getter dinamis
        }
        return $default;
    }

    // Helper method to easily set a setting by key
    public static function setSetting(string $key, $value, string $description = null, string $type = null)
    {
        $setting = static::firstOrNew(['setting_key' => $key]);
        $setting->type = $type ?? static::detectType($value); // Deteksi tipe data jika tidak diberikan
        $setting->value = $value; // Menggunakan setter dinamis
        $setting->description = $description ?? $setting->description;
        $setting->save();
        return $setting;
    }

    /**
     * Detect the type of a given value.
     *
     * @param mixed $value
     * @return string
     */
    protected static function detectType(mixed $value): string
    {
        if (is_int($value)) {
            return 'int';
        }
        if (is_float($value) || is_double($value)) {
            return 'decimal';
        }
        if (is_bool($value)) {
            return 'boolean';
        }
        if (is_array($value) || is_object($value)) {
            return 'json';
        }
        return 'string';
    }
}

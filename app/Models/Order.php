<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'no',
        'kode',
        'kategori',
        'nama',
        'barang',
        'status',
        'taken_at',
        'delivery_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'taken_at' => 'datetime',
        'delivery_at' => 'datetime',
    ];

    /**
     * Generate the next order number
     * Returns formatted number like "0001", "0002", etc.
     */
    public static function generateNextNo(): string
    {
        $lastOrder = self::withTrashed()->latest('id')->first();
        $nextNumber = ($lastOrder ? intval($lastOrder->no) : 0) + 1;
        return str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate kode based on kategori and order number
     * plat-tipis → "pt-0001"
     * plat-tebal → "pb-0001"
     * pipa → "p-0001"
     */
    public static function generateKode(string $kategori, string $no): string
    {
        $prefix = match($kategori) {
            'plat-tipis' => 'pt',
            'plat-tebal' => 'pb',
            'pipa' => 'p',
            default => 'unknown',
        };

        return "{$prefix}-{$no}";
    }

    /**
     * Get the formatted time (HH:MM)
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at->format('H:i');
    }

    /**
     * Get kategori display name
     */
    public function getKategoriDisplayAttribute(): string
    {
        return match($this->kategori) {
            'plat-tipis' => 'Plat Tipis',
            'plat-tebal' => 'Plat Tebal',
            'pipa' => 'Pipa',
            default => $this->kategori,
        };
    }
}

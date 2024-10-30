<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentType;
use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shopper\Core\Models\Order;

/**
 * @property-read string $id
 * @property TransactionStatus $status
 * @property int $amount
 * @property int $fees
 * @property PaymentType | null $provider
 * @property Order $order
 */
final class Transaction extends Model
{
    use HasFactory;
    use HasUlids;

    protected $guarded = [];

    public $casts = [
        'metadata' => 'array',
        'status' => TransactionStatus::class,
        'provider' => PaymentType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function scopeComplete(Builder $query): Builder
    {
        return $query->where('status', TransactionStatus::Complete());
    }

    public function getMetadata(string $name, string $default = ''): mixed
    {
        if ($this->metadata && array_key_exists($name, $this->metadata)) {
            return $this->metadata[$name];
        }

        return $default;
    }

    public function setMetadata(array $revisions, bool $save = true): self
    {
        $this->metadata = array_merge($this->metadata ?? [], $revisions);

        if ($save) {
            $this->save();
        }

        return $this;
    }
}

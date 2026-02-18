<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentType;
use App\Enums\TransactionStatus;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shopper\Core\Models\Order;

/**
 * @property-read string $id
 * @property-read TransactionStatus $status
 * @property-read int $amount
 * @property-read int $fees
 * @property-read ?PaymentType $provider
 * @property-read Order $order
 * @property-read array<string, mixed> $metadata
 */
final class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory;

    use HasUlids;

    public $casts = [
        'metadata' => 'array',
        'status' => TransactionStatus::class,
        'provider' => PaymentType::class,
    ];

    protected $guarded = [];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Order, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getMetadata(string $name, string $default = ''): mixed
    {
        if ($this->metadata && array_key_exists($name, $this->metadata)) {
            return $this->metadata[$name];
        }

        return $default;
    }

    /**
     * @param  array<string, mixed>  $revisions
     * @return $this
     */
    public function setMetadata(array $revisions, bool $save = true): self
    {
        $this->fill(['metadata' => array_merge($this->metadata ?? [], $revisions)]);

        if ($save) {
            $this->save();
        }

        return $this;
    }

    /** @param  Builder<Transaction>  $query */
    #[Scope]
    protected function complete(Builder $query): Builder
    {
        return $query->where('status', TransactionStatus::Complete());
    }
}

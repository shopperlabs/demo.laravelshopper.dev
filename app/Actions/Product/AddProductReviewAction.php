<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Shopper\Core\Models\Review;

final class AddProductReviewAction
{
    // @phpstan-ignore-next-line
    public function execute(Model $reviewrateable, array $data, User $author): Review
    {
        // @phpstan-ignore-next-line
        return $reviewrateable->rating($data, $author);
    }
}

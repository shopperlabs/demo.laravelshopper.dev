<?php

declare(strict_types=1);

namespace App\Actions\Product;

use Illuminate\Database\Eloquent\Model;

final class AddReview
{
    public function execute(Model $reviewrateable, array $data, Model $author): \Shopper\Core\Models\Review
    {
        return $reviewrateable->rating($data, $author);
    }
}

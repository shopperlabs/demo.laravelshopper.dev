<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Form;

final class ProductReviewsForm extends Form
{
    public ?Product $product = null;

    #[Validate('required|integer|min:1|max:5')]
    public int $rating = 1;

    #[Validate('nullable|string|max:255')]
    public ?string $title = null;

    #[Validate('nullable|string|max:255')]
    public ?string $content = null;
}

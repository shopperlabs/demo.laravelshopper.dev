<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Shopper\Core\Models\Legal;

final class LegalController extends Controller
{
    public function __invoke(string $slug): View
    {
        $legal = Legal::enabled()->where('slug', $slug)->first();

        abort_if( ! $legal, 404);

        return view('pages.legal', [
            'legal' => $legal,
        ]);
    }
}

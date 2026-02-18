@unless ($breadcrumbs->isEmpty())
    <flux:breadcrumbs>
        @if ($breadcrumbs->count() <= 4)
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($loop->first)
                    <flux:breadcrumbs.item :href="$breadcrumb->url" icon="home" />
                @elseif ($breadcrumb->url && ! $loop->last)
                    <flux:breadcrumbs.item :href="$breadcrumb->url">{{ $breadcrumb->title }}</flux:breadcrumbs.item>
                @else
                    <flux:breadcrumbs.item>{{ $breadcrumb->title }}</flux:breadcrumbs.item>
                @endif
            @endforeach
        @else
            <flux:breadcrumbs.item :href="$breadcrumbs->first()->url" icon="home" />

            @php
                $middle = $breadcrumbs->slice(1, $breadcrumbs->count() - 3);
                $last = $breadcrumbs->slice(-2);
            @endphp

            <flux:breadcrumbs.item>
                <flux:dropdown>
                    <flux:button icon="ellipsis-horizontal" variant="ghost" size="sm" />
                    <flux:navmenu>
                        @foreach ($middle as $breadcrumb)
                            <flux:navmenu.item :href="$breadcrumb->url">{{ $breadcrumb->title }}</flux:navmenu.item>
                        @endforeach
                    </flux:navmenu>
                </flux:dropdown>
            </flux:breadcrumbs.item>

            @foreach ($last as $breadcrumb)
                @if ($breadcrumb->url && ! $loop->last)
                    <flux:breadcrumbs.item :href="$breadcrumb->url">{{ $breadcrumb->title }}</flux:breadcrumbs.item>
                @else
                    <flux:breadcrumbs.item>{{ $breadcrumb->title }}</flux:breadcrumbs.item>
                @endif
            @endforeach
        @endif
    </flux:breadcrumbs>
@endunless

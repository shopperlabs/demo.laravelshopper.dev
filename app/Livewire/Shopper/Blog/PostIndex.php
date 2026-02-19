<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Blog;

use App\Models\BlogPost;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Livewire\Pages\AbstractPageComponent;

final class PostIndex extends AbstractPageComponent implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(BlogPost::query()->with(['category', 'author'])->latest())
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('category.name')
                    ->label(__('Category'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('author.first_name')
                    ->label(__('Author'))
                    ->formatStateUsing(fn (BlogPost $record): string => $record->author->full_name)
                    ->searchable(),
                IconColumn::make('is_published')
                    ->label(__('Published'))
                    ->boolean()
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label(__('Published at'))
                    ->date()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('edit')
                    ->icon(Untitledui::Edit03)
                    ->iconButton()
                    ->action(fn (BlogPost $record) => $this->redirectRoute(
                        name: 'shopper.blog.posts.edit',
                        parameters: ['post' => $record],
                        navigate: true,
                    )),
                DeleteAction::make()
                    ->icon(Untitledui::Trash03)
                    ->iconButton(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.shopper.blog.post-index')
            ->title(__('Blog Posts'));
    }
}

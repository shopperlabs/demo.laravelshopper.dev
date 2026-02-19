<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Blog;

use App\Models\BlogCategory;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Livewire\Pages\AbstractPageComponent;

final class CategoryIndex extends AbstractPageComponent implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public function createAction(): Action
    {
        return Action::make('create')
            ->label(__('Create category'))
            ->schema($this->categoryFormSchema())
            ->modalWidth(Width::Large)
            ->action(function (array $data): void {
                BlogCategory::query()->create($data);

                Notification::make()
                    ->title(__('Blog category created successfully.'))
                    ->success()
                    ->send();
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(BlogCategory::query()->withCount('posts')->latest())
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->searchable(),
                TextColumn::make('posts_count')
                    ->label(__('Posts'))
                    ->counts('posts')
                    ->sortable(),
                IconColumn::make('is_enabled')
                    ->label(__('Enabled'))
                    ->boolean()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('edit')
                    ->icon(Untitledui::Edit03)
                    ->iconButton()
                    ->fillForm(fn (BlogCategory $record): array => $record->attributesToArray())
                    ->modalWidth(Width::Large)
                    ->schema($this->categoryFormSchema(isEdit: true))
                    ->action(function (BlogCategory $record, array $data): void {
                        $record->update($data);

                        Notification::make()
                            ->title(__('Blog category updated successfully.'))
                            ->success()
                            ->send();
                    }),
                DeleteAction::make()
                    ->icon(Untitledui::Trash03)
                    ->iconButton(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.shopper.blog.category-index')
            ->title(__('Blog Categories'));
    }

    /** @return array<int, Field> */
    private function categoryFormSchema(bool $isEdit = false): array
    {
        return [
            TextInput::make('name')
                ->label(__('Name'))
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (string $state, Set $set) use ($isEdit): void {
                    if (! $isEdit) {
                        $set('slug', Str::slug($state));
                    }
                }),
            TextInput::make('slug')
                ->label(__('Slug'))
                ->required()
                ->maxLength(255),
            Textarea::make('description')
                ->label(__('Description'))
                ->rows(3),
            Toggle::make('is_enabled')
                ->label(__('Enabled'))
                ->default(true),
        ];
    }
}

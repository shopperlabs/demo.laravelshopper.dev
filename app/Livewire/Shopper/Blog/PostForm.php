<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Blog;

use App\Models\BlogPost;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Shopper\Livewire\Pages\AbstractPageComponent;

/**
 * @property-read Schema $form
 */
final class PostForm extends AbstractPageComponent implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public BlogPost $post;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(?BlogPost $post = null): void
    {
        $this->post = $post ?? new BlogPost;

        $this->form->fill($this->post->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Section::make(__('Post details'))
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $state, Set $set): void {
                                        if (! $this->post->exists) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                Hidden::make('slug'),
                                Textarea::make('excerpt')
                                    ->label(__('Excerpt'))
                                    ->rows(3)
                                    ->columnSpanFull(),
                                RichEditor::make('content')
                                    ->label(__('Content'))
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make(__('Featured image'))
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('image')
                                    ->label(__('Image'))
                                    ->collection('image')
                                    ->image()
                                    ->imageEditor(),
                            ]),
                        Section::make(__('Publishing'))
                            ->schema([
                                Toggle::make('is_published')
                                    ->label(__('Published'))
                                    ->onColor('success'),
                                DateTimePicker::make('published_at')
                                    ->label(__('Published at'))
                                    ->native(false),
                            ]),
                        Section::make(__('Organization'))
                            ->schema([
                                Select::make('blog_category_id')
                                    ->label(__('Category'))
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3)
            ->statePath('data')
            ->model($this->post);
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $state['user_id'] = $this->post->exists
            ? $this->post->user_id
            : shopper()->auth()->id();

        if ($this->post->exists) {
            $this->post->update($state);
        } else {
            $this->post = BlogPost::query()->create($state);
        }

        $this->form->model($this->post)->saveRelationships();

        Notification::make()
            ->title(__('Blog post saved successfully.'))
            ->success()
            ->send();

        $this->redirectRoute('shopper.blog.posts.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.shopper.blog.post-form')
            ->title($this->post->exists ? __('Edit post') : __('Create post'));
    }
}

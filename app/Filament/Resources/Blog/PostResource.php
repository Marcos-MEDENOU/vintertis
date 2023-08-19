<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\PostResource\Pages;
use App\Filament\Resources\Blog\PostResource\RelationManagers;
use App\Models\Blog\Post;
use Filament\Forms;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Z3d0X\FilamentFabricator\Models\Contracts\Page as PageContract;
use Z3d0X\FilamentFabricator\Facades\FilamentFabricator;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;



class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $slug = 'blog/posts';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Blog';

    protected ?string $maxContentWidth = 'full';

    protected static ?string $navigationLabel = 'Articles';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->lazy()
                                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->unique(Post::class, 'slug', ignoreRecord: true),

                                TinyEditor::make('content')
                                    ->required()
                                    ->columnSpan('full')
                                    ->language('fr')
                                    ->showMenuBar()
                                    ->toolbarSticky(true)
                                    ->fileAttachmentsDisk('local')
                                    ->fileAttachmentsVisibility('public')
                                    ->fileAttachmentsDirectory('uploads'),

                                // TiptapEditor::make('content')
                                // ->profile('default')
                                // ->disk('local') // optional, defaults to config setting
                                // ->directory('uploads') // optional, defaults to config setting
                                // ->output('html') // optional, change the output format. defaults is html
                                // ->maxContentWidth('full')
                                // ->required(),

                                Forms\Components\Select::make('blog_category_id')
                                    ->label('Catégorie')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->columnSpan('full')
                                    ->required()
                                    ->searchable(),


                                Forms\Components\DatePicker::make('published_at')
                                    ->columnSpan('full')
                                    ->label('Published Date'),
                                // SpatieTagsInput::make('tags'),
                            ]),



                    ])
                    ->columnSpan(['lg' => fn (?Post $record) => $record === null ? 2 : 2]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Card::make()
                        ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Post $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Post $record): ?string => $record->updated_at?->diffForHumans()),

                        ])->hidden(fn (?Post $record) => $record === null),
                        Forms\Components\Section::make('Image principale')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->disk('local')
                                    ->label('Image')
                                    ->image()
                                    ->visibility('public')

                            ])
                            ->columnSpan(['lg' => 1])
                            ->collapsible(),
                        Forms\Components\Section::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('meta_description')

                                    ->required(),
                                Forms\Components\TextInput::make('meta_keywords')

                                    ->required(),
                                Forms\Components\TextInput::make('seo_title')

                                    ->required()

                            ])
                            ->collapsible()
                            ->columnSpan(['lg' => 1]),

                    ])
                    ->columnSpan(['lg' => 1])
                    

            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('local')
                    ->label('Image')
                    ->visibility('public'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Tables\Columns\TextColumn::make('author.name')
                //     ->searchable()
                //     ->sortable()
                //     ->toggleable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->getStateUsing(fn (Post $record): string => $record->published_at?->isPast() ? 'Published' : 'Draft')
                    ->colors([
                        'success' => 'Published',
                    ]),

                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published Date')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                        Forms\Components\DatePicker::make('published_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['published_from'] ?? null) {
                            $indicators['published_from'] = 'Published from ' . Carbon::parse($data['published_from'])->toFormattedDateString();
                        }
                        if ($data['published_until'] ?? null) {
                            $indicators['published_until'] = 'Published until ' . Carbon::parse($data['published_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

                Action::make('visit')
                    ->label('Preview')
                    ->url(fn ($record): string => '/view/' . $record->slug)
                    // ->url(route('display', ['invoice' => 'dofi']))
                    ->icon('heroicon-o-external-link')
                    ->openUrlInNewTab()
                    ->color('success'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function () {
                        Notification::make()
                            ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                            ->warning()
                            ->send();
                    }),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with('category');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'category.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Post $record */
        $details = [];

        // if ($record->author) {
        //     $details['Author'] = $record->author->name;
        // }

        if ($record->category) {
            $details['Category'] = $record->category->name;
        }

        return $details;
    }
}

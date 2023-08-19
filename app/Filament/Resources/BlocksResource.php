<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlocksResource\Pages;
use App\Filament\Resources\BlocksResource\RelationManagers;
use Filament\Tables\Actions\Action;
use App\Models\Blocks;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use msuhels\editorjs\Forms\Components\EditorJs;
use JKHarley\FilamentTrumbowyg\Trumbowyg;



class BlocksResource extends Resource
{

    //Attribution du model auquel sera lié cette ressource => ici, il s'agit du model Blocks
    protected static ?string $model = Blocks::class;

    //Définir la largeur maximale pour la zone d'étendu de la ressource
    protected ?string $maxContentWidth = 'full'; 

    //Choix d'une icone pour la barre de navigation verticale
    protected static ?string $navigationIcon = 'heroicon-s-view-boards';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->lazy()
                    ->label('Nom du block'),

                Forms\Components\TextInput::make('order')
                    ->required(),
                // ->unique(), => a ajuster pour bloquer la soumission
                Forms\Components\Select::make('page_id')
                    ->label('Page')
                    ->required()
                    ->relationship('Pages', 'title'),

                // Forms\Components\TextInput::make('content')
                //     ->required()
                //     ->columnSpan('full'),

                // TiptapEditor::make('content')
                //     ->profile('default')
                //     ->disk('public') // optional, defaults to config setting
                //     ->directory('uploads') // optional, defaults to config setting
                //     ->columnSpan('full')
                //     ->output('html') // optional, change the output format. defaults is html
                //     ->maxContentWidth('full')
                //     ->required(),

                TinyEditor::make('content')
                    ->required()
                    ->columnSpan('full')
                    ->language('fr')
                    ->showMenuBar()
                    ->fileAttachmentsDisk('local')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads'),
                // Trumbowyg::make('content')->columnSpan("full")
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')->sortable()->label('Nom'),
                // Tables\Columns\TextColumn::make('content')->sortable()->label('Contenu'),
                Tables\Columns\TextColumn::make('order')->sortable()->label('Position'),
                Tables\Columns\TextColumn::make('pages.title')->sortable()->label('Page'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Action::make('visit')
                    ->label('Voir la page')
                    ->url(fn ($record) => '/'. $record->page_id)
                    // ->url(fn ($record) => $record->name)
                    // ->url(route('display', ['invoice' => 'dofi']))
                    ->icon('heroicon-o-external-link')
                    ->openUrlInNewTab()
                    ->color('success'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
              
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlocks::route('/'),
            'create' => Pages\CreateBlocks::route('/create'),
            'edit' => Pages\EditBlocks::route('/{record}/edit'),
        ];
    }
}

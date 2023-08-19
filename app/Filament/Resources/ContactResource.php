<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\FrontModels\Contact;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
      
                    Forms\Components\TextInput::make('contact_firstname')->label('Prénom'),
                    Forms\Components\TextInput::make('contact_lastname')->label('Nom'),
                    Forms\Components\TextInput::make('contact_function')->label('Fonction'),
                    Forms\Components\TextInput::make('contact_entreprise')->label('Entreprise'),
                    Forms\Components\TextInput::make('contact_phonenumber')->label('Télephone'),
                    Forms\Components\TextInput::make('contact_email')->label('Email'),
                    Forms\Components\TextInput::make('contact_message')->label('Message'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contact_firstname')->sortable()->label('Prénom'),
                Tables\Columns\TextColumn::make('contact_lastname')->sortable()->label('Nom'),
                Tables\Columns\TextColumn::make('contact_function')->sortable()->label('Fonction'),
                Tables\Columns\TextColumn::make('contact_entreprise')->sortable()->label('Entreprise'),
                Tables\Columns\TextColumn::make('contact_phonenumber')->sortable()->label('Télephone'),
                Tables\Columns\TextColumn::make('contact_email')->sortable()->label('Email'),
                Tables\Columns\TextColumn::make('contact_message')->sortable()->label('Message')->limit(10),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListContacts::route('/'),
            // 'create' => Pages\CreateContact::route('/create'),
            // 'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}

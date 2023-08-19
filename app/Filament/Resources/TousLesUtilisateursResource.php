<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TousLesUtilisateursResource\Pages;
use App\Filament\Resources\TousLesUtilisateursResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Actions\Modal\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;  


class TousLesUtilisateursResource extends Resource
{

    protected static ?string $slug = 'utilisateurs/touslesutilisateurs';
    

    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Tous les admins';
    
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = '';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')->columnSpan('full')->label('Nom de l\'admin')->required(),
            TextInput::make('email')->columnSpan('full')->label('E-mail')->required(),
            TextInput::make('password')->columnSpan('full')->label('Mot de passe')
                ->password()
                ->required()
                ->hiddenOn('edit')
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ,
            // Hash::make('password'),
            // TextInput::make('status')->columnSpan('full'),
            // Select::make('role')
            //     ->extraInputAttributes(['multiple' => false])
            //     ->label('Status')
            //     ->columnSpan('full')
            //     ->options([
            //         'admin' => 'Admin',
            //         'Super Admin' => 'Super Admin',
            //     ])
                // ->relationship('role', 'name')
                
                Select::make('roles')->multiple()->relationship('roles', 'name')->columnSpan('full')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->label('Nom de l\'admin'),
            Tables\Columns\TextColumn::make('email')->sortable()->label('E-mail'),
           	Tables\Columns\TextColumn::make('roles.name')->sortable(),
        ])
        ->filters([
            Tables\Filters\Filter::make('verified')
            ->query(fn (Builder $query): Builder => $query->whereNotNull('password')),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTousLesUtilisateurs::route('/'),
            'create' => Pages\CreateTousLesUtilisateurs::route('/create'),
            'edit' => Pages\EditTousLesUtilisateurs::route('/{record}/edit'),
        ];
    }    
}
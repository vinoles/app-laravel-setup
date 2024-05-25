<?php

namespace App\Filament\Resources;

use App\Constants\UserRole;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'icon-users';

    public static function getNavigationGroup(): string
    {
        return __('admin.globals.social');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.users.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->label(__('admin.globals.first_name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label(__('admin.globals.last_name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('admin.globals.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label(__('admin.globals.phone'))
                    ->tel()
                    ->maxLength(50),

                TextInput::make('address')
                    ->label(__('admin.globals.address'))
                    ->required()
                    ->maxLength(150),

                Select::make('role')
                    ->label(__('admin.users.role'))
                    ->options(UserRole::asAdminDropdownOptions('users', 'roles'))
                    ->required(),

                TextInput::make('city')
                    ->label(__('admin.globals.city'))
                    ->maxLength(50),

                TextInput::make('country')
                    ->label(__('admin.globals.country'))
                    ->maxLength(50),

                TextInput::make('postal_code')
                    ->label(__('admin.globals.postal_code')),

                TextInput::make('password')
                    ->label(__('admin.globals.password'))
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label(__('admin.globals.first_name'))
                    ->searchable(),

                TextColumn::make('last_name')
                    ->label(__('admin.globals.last_name'))
                    ->searchable(),

                TextColumn::make('email')
                    ->label(__('admin.globals.first_name'))
                    ->searchable(),

                TextColumn::make('role')
                    ->label(__('admin.users.role'))
                    ->view('tables.columns.filament.role'),

                TextColumn::make('phone')
                    ->label(__('admin.globals.phone'))
                    ->searchable(),

                TextColumn::make('address')
                    ->label(__('admin.globals.address'))
                    ->searchable(),

                TextColumn::make('city')
                    ->label(__('admin.globals.city'))
                    ->searchable(),

                TextColumn::make('email_verified_at')
                    ->label(__('admin.users.email_verified_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
                SelectFilter::make('role')
                    ->label(__('admin.users.role'))
                    ->options(UserRole::asAdminDropdownOptions('users', 'roles')),
            ]);
    }
}

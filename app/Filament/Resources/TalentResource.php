<?php

namespace App\Filament\Resources;

use App\Constants\HandPreference;
use App\Filament\Resources\TalentResource\Pages\CreateTalent;
use App\Filament\Resources\TalentResource\Pages\EditTalent;
use App\Filament\Resources\TalentResource\Pages\ListTalent;
use App\Filament\Resources\TalentResource\Pages\ViewTalent;
use App\Filament\Resources\TalentResource\RelationManagers\PostsRelationManager;
use App\Models\Talent;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TalentResource extends Resource
{
    protected static ?string $model = Talent::class;

    protected static ?string $navigationIcon = 'icon-talents';

    public static function getNavigationGroup(): string
    {
        return __('admin.globals.social');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.talents.talents');
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

                TextInput::make('phone')
                    ->label(__('admin.globals.phone'))
                    ->tel()
                    ->maxLength(50),

                TextInput::make('address')
                    ->label(__('admin.globals.address'))
                    ->required()
                    ->maxLength(150),

                TextInput::make('city')
                    ->label(__('admin.globals.city'))
                    ->maxLength(50),

                TextInput::make('province')
                    ->label(__('admin.globals.province'))
                    ->maxLength(50),

                TextInput::make('postal_code')
                    ->label(__('admin.globals.postal_code'))
                    ->maxLength(25),

                Select::make('hand_preference')
                    ->label(__('admin.talents.hand_preference'))
                    ->options(
                        HandPreference::asAdminDropdownOptions(
                            'talents',
                            'hand_preferences'
                        )
                    )
                    ->required(),

                DatePicker::make('birthdate')
                    ->label(__('admin.globals.birthdate'))
                    ->required(),
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

                TextColumn::make('phone')
                    ->label(__('admin.globals.phone'))
                    ->searchable(),

                TextColumn::make('address')
                    ->label(__('admin.globals.address'))
                    ->searchable(),

                TextColumn::make('city')
                    ->label(__('admin.globals.city'))
                    ->searchable(),

                TextColumn::make('hand_preference')
                    ->label(__('admin.talents.hand_preference'))
                    ->view('tables.columns.filament.hand-preference'),

                TextColumn::make('birthdate')
                    ->label(__('admin.globals.birthdate'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('admin.globals.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('admin.globals.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label(__('admin.globals.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('hand_preference')
                    ->label(__('admin.talents.hand_preference'))
                    ->options(
                        HandPreference::asAdminDropdownOptions(
                            'talents',
                            'hand_preferences'
                        )
                    ),
            ])
            ->actions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTalent::route('/'),
            'create' => CreateTalent::route('/create'),
            'view' => ViewTalent::route('/{record}'),
            'edit' => EditTalent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

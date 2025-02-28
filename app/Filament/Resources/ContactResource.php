<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationLabel = 'Contactos';
    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('organization')
                    ->label('Organización')
                    ->required(),
                Forms\Components\TextInput::make('position')
                    ->label('Cargo')
                    ->required(),
                Forms\Components\Select::make('categories')
                    ->label('Categoría')
                    ->placeholder('Selecciona una categoría')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $icon = 'heroicon-o-tag';
        return $table
            ->columns([
                /*Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('organization')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categories')
                    ->searchable()
                    ->formatStateUsing(fn(Contact $record) => $record->categories->pluck('name')->join(' - ')),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), */
                    Split::make([
                        TextColumn::make('name')
                            ->weight(FontWeight::Bold)
                            ->searchable()
                            ->sortable(),
                    Stack::make([
                        TextColumn::make('organization', 'Organización')
                            ->icon('heroicon-o-home-modern')
                            ->searchable()
                            ->sortable()
                            ->wrap(),
                            TextColumn::make('position', 'Cargo')
                            ->icon('heroicon-o-user-circle')
                            ->searchable()
                            ->sortable()
                            ->wrap(),
                    ]),
                    
                            
                        Stack::make([
                            TextColumn::make('phone')
                                ->icon('heroicon-m-phone')
                                ->searchable(),
                            TextColumn::make('email')
                                ->icon('heroicon-m-envelope')
                                ->searchable(),
                        ]),
                        TextColumn::make('categories')
                                ->icon('heroicon-o-tag')
                                ->searchable()
                                ->formatStateUsing(fn(Contact $record) => $record->categories->pluck('name')->join(' - ')),
                    ])
            ])
            ->filters([
                SelectFilter::make('categories')
                ->relationship('categories', 'name')
                ->label('Categoría')
                ->multiple()
                ->preload()
                ->searchable()
                ->placeholder('Selecciona una categoría')
                
                
                ->options(fn (Builder $query) => $query->pluck('name', 'id')->all())
            ], layout: FiltersLayout::AboveContent)
            
            ->actions([
                Action::make('delete')->requiresConfirmation()
                ->action(fn (Contact $record) => $record->delete()),
                Tables\Actions\EditAction::make(),
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
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}

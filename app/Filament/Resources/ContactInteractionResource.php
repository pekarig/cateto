<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactInteractionResource\Pages;
use App\Models\ContactInteraction;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactInteractionResource extends Resource
{
    protected static ?string $model = ContactInteraction::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Kapcsolat Analytics';

    protected static ?string $modelLabel = 'Interakció';

    protected static ?string $pluralModelLabel = 'Interakciók';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('action')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ip_address')
                    ->maxLength(45),
                Forms\Components\Textarea::make('user_agent')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('session_id')
                    ->maxLength(100),
                Forms\Components\TextInput::make('referrer')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('action')
                    ->label('Művelet')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'checkbox_checked' => 'info',
                        'accept_button_clicked' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'checkbox_checked' => 'Checkbox bepipálva',
                        'accept_button_clicked' => 'Elfogadom kattintás',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP cím')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('IP cím vágólapra másolva'),
                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(50)
                    ->tooltip(fn (ContactInteraction $record): string => $record->user_agent ?? '')
                    ->searchable(),
                Tables\Columns\TextColumn::make('session_id')
                    ->label('Session ID')
                    ->limit(20)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dátum')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->label('Művelet')
                    ->options([
                        'checkbox_checked' => 'Checkbox bepipálva',
                        'accept_button_clicked' => 'Elfogadom kattintás',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Ettől'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Eddig'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                // Analytics csak olvasható, nincs szerkesztés
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContactInteractions::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ContactInteractionResource\Widgets\ContactStatsWidget::class,
        ];
    }
}

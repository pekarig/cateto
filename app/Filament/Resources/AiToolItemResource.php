<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiToolItemResource\Pages;
use App\Models\AiToolItem;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AiToolItemResource extends Resource
{
    protected static ?string $model = AiToolItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationLabel = 'AI Tool Dobozok';

    protected static ?string $modelLabel = 'AI tool doboz';

    protected static ?string $pluralModelLabel = 'AI tool dobozok';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('page_id')
                    ->label('Oldal')
                    ->relationship('page', 'title')
                    ->required()
                    ->default(fn () => \App\Models\Page::where('slug', 'ai-jovo')->first()?->id)
                    ->searchable()
                    ->preload(),

                Forms\Components\FileUpload::make('icon_path')
                    ->label('Icon')
                    ->disk('public')
                    ->directory('ai-icons')
                    ->acceptedFileTypes(['image/svg+xml', 'image/png'])
                    ->maxSize(2048)
                    ->helperText('SVG vagy PNG ikon (max 2MB)')
                    ->previewable(false)
                    ->downloadable(false)
                    ->deletable(true),

                Forms\Components\TextInput::make('name')
                    ->label('AI Tool neve')
                    ->required()
                    ->maxLength(255)
                    ->helperText('pl: OpenAI, Anthropic, Gemini'),

                Forms\Components\RichEditor::make('description')
                    ->label('Leírás')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                    ])
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('button_text')
                    ->label('Gomb szöveg')
                    ->default('Megnyitás')
                    ->maxLength(255)
                    ->helperText('pl: Megnyitás, Részletek, Tovább'),

                Forms\Components\TextInput::make('button_url')
                    ->label('Gomb URL')
                    ->required()
                    ->url()
                    ->maxLength(255)
                    ->helperText('Teljes URL (pl: https://chatgpt.com/)'),

                Forms\Components\Checkbox::make('button_target_blank')
                    ->label('Új ablakban nyíljon meg (_blank)')
                    ->helperText('Pipáld be, ha új böngésző ablakban szeretnéd megnyitni')
                    ->default(false),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0)
                    ->helperText('0-tól kezdve, balról jobbra, fentről le'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page.title')
                    ->label('Oldal')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('AI Tool neve')
                    ->searchable(),

                Tables\Columns\TextColumn::make('icon_path')
                    ->label('Icon')
                    ->formatStateUsing(fn (string $state = null): string => $state
                        ? '<img src="' . asset('storage/' . $state) . '" style="width: 40px; height: 40px; object-fit: contain;" alt="Icon">'
                        : '-'
                    )
                    ->html(),

                Tables\Columns\TextColumn::make('button_text')
                    ->label('Gomb szöveg')
                    ->searchable(),

                Tables\Columns\IconColumn::make('button_target_blank')
                    ->label('Új ablak')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sorrend')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('page')
                    ->relationship('page', 'title'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAiToolItems::route('/'),
            'create' => Pages\CreateAiToolItem::route('/create'),
            'edit' => Pages\EditAiToolItem::route('/{record}/edit'),
        ];
    }
}

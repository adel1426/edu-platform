<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'الدروس';

    protected static ?string $pluralModelLabel = 'الدروس';

    protected static ?string $modelLabel = 'درس';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('محتوى الدرس')
                    ->schema([
                        Forms\Components\Select::make('subject_id')
                            ->label('المادة الدراسية')
                            ->relationship('subject', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (callable $set) => $set('unit_id', null)),

                        Forms\Components\Select::make('unit_id')
                            ->label('الوحدة')
                            ->relationship('unit', 'title', fn ($query, callable $get) => $query->where('subject_id', $get('subject_id')))
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Forms\Components\TextInput::make('title')
                            ->label('عنوان الدرس')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('رابط الدرس (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique('lessons', 'slug', ignoreRecord: true),

                        Forms\Components\TextInput::make('video_url')
                            ->label('رابط الفيديو (YouTube)')
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('content')
                            ->label('شرح الدرس')
                            ->helperText('لكتابة رموز رياضية بصيغة LaTeX: \( \frac{2}{5} \) للكسر ← \frac{2}{5} | \( \sqrt{9} \) للجذر ← \sqrt{9} | \( x^{2} \) للأس ← x^{2} | ضعها بين \( ... \) داخل السطر أو \[ ... \] لسطر مستقل.')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('lesson-attachments')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('النقاط والحالة')
                    ->schema([
                        Forms\Components\TextInput::make('points_reward')
                            ->label('نقاط المكافأة')
                            ->numeric()
                            ->default(10)
                            ->minValue(0)
                            ->prefix('🏆'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('نشر الدرس')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject.name')
                    ->label('المادة')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit.title')
                    ->label('الوحدة')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان الدرس')
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('public_url')
                    ->label('الرابط العام')
                    ->state(fn (Lesson $record): string => route('lessons.show', $record->slug))
                    ->limit(40)
                    ->tooltip(fn (Lesson $record): string => route('lessons.show', $record->slug))
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('points_reward')
                    ->label('النقاط')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject_id')
                    ->label('المادة')
                    ->relationship('subject', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('الحالة'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('عرض الدرس')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Lesson $record): string => route('lessons.show', $record->slug))
                    ->openUrlInNewTab()
                    ->color('gray')
                    ->visible(fn (Lesson $record): bool => (bool) $record->is_published),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view')
                ->label('عرض الدرس')
                ->icon('heroicon-o-eye')
                ->url(fn (): string => route('lessons.show', $this->getRecord()->slug))
                ->openUrlInNewTab()
                ->color('gray')
                ->visible(fn (): bool => (bool) $this->getRecord()->is_published),
            Actions\Action::make('publicUrl')
                ->label('الرابط العام')
                ->icon('heroicon-o-link')
                ->url(fn (): string => route('lessons.show', $this->getRecord()->slug))
                ->openUrlInNewTab()
                ->color('gray')
                ->visible(fn (): bool => (bool) $this->getRecord()->is_published),
            Actions\DeleteAction::make(),
        ];
    }
}

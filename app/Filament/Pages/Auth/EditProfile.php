<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('الاسم الكامل')
                    ->required()
                    ->maxLength(255),

                TextInput::make('username')
                    ->label('اسم المستخدم')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Select::make('grade_level')
                    ->label('المرحلة الدراسية')
                    ->options([
                        'first' => 'الأول متوسط',
                        'second' => 'الثاني متوسط',
                    ])
                    ->placeholder('اختيار المرحلة'),

                TextInput::make('password')
                    ->label('كلمة المرور الجديدة')
                    ->password()
                    ->revealable()
                    ->nullable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)),

                TextInput::make('passwordConfirmation')
                    ->label('تأكيد كلمة المرور')
                    ->password()
                    ->revealable()
                    ->nullable()
                    ->same('password')
                    ->requiredWith('password')
                    ->dehydrated(false),
            ]);
    }
}

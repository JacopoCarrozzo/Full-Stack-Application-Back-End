<?php

namespace App\Models;

use Tapp\FilamentFormBuilder\Models\FilamentForm as BaseFilamentForm;
use Tapp\FilamentFormBuilder\Models\FilamentFormField;

class FilamentForm extends BaseFilamentForm
{
    protected $guarded = [];

    protected $casts = [
        'notification_emails' => 'json',
    ];

    
    public function fieldsRelation()
    {
        return $this->hasMany(FilamentFormField::class, 'filament_form_id')
                    ->orderBy('sort_order');
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FilamentForm;
use App\Models\FormSubmission;

class FormController extends Controller
{
    public function show($id)
    {
        $form = FilamentForm::with('filamentFormFields')->findOrFail($id);

        return response()->json([
            'id' => $form->id,
            'name' => $form->name,
            'fields' => $form->filamentFormFields->map(function ($field) {
                return [
                    'name' => $field->name,
                    'type' => $field->type->name,
                    'label' => $field->label ?? $field->name,
                    'required' => $field->required ?? false,
                    'placeholder' => $field->placeholder ?? '',
                    'hint' => $field->hint ?? '',
                    'options' => $field->options,
                ];
            })->values(),
        ]);
    }

    public function submit(Request $request, $id)
    {
        $form = FilamentForm::with('filamentFormFields')->findOrFail($id);
        
        $rules = $form->filamentFormFields->pluck('required', 'name')
            ->filter()
            ->map(fn ($required) => 'required')
            ->toArray();

        foreach ($form->filamentFormFields as $field) {
            $validationType = match ($field->type->name) {
                'Email' => 'email',
                'Number' => 'numeric',
                default => 'string',
            };
            
            if (isset($rules[$field->name])) {
                $rules[$field->name] .= '|' . $validationType;
            } elseif ($validationType !== 'string') {
                $rules[$field->name] = $validationType;
            }
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        FormSubmission::create([
            'filament_form_id' => $id,
            'data' => $request->except('_token'),
        ]);

        return response()->json([
            'message' => 'Thank you! Your message has been sent successfully.',
        ], 200);
    }
}
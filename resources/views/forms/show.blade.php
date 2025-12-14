<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $form->name }}</title>
    @livewireStyles
</head>
<body>
    <livewire:tapp.filament-form-builder.livewire.filament-form.show :form-id="$form->id" />
    @livewireScripts
</body>
</html>
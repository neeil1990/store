<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Общее') }}</h3>
    </div>

    <div class="card-body">

        <x-forms.text-group label="{{ __('Поставщик') }}" name="shipper" value="{{ $shipper->name ?? $shipper->origin_name }}"/>

        <x-forms.text-group label="{{ __('Email поставщика') }}" name="email" value="{{ $shipper->email }}"/>

        <x-forms.select-group label="{{ __('Привязанный сотрудник') }}" name="users[]" multiple="">
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @if ($user->isSelected($shipper->users)) selected @endif>{{ $user->name }}</option>
            @endforeach
        </x-forms.select-group>

        <x-forms.text-group label="{{ __('Email задачи в Планфикс') }}" name="plan_fix_email" value="{{ $shipper->plan_fix_email }}"/>

        <x-forms.text-group label="{{ __('Ссылка на задачу в Планфиксе') }}" name="plan_fix_link" value="{{ $shipper->plan_fix_link }}"/>

        <x-forms.textarea-group label="{{ __('Комментарий к поставщику') }}" name="comment" value="{{ $shipper->comment }}"/>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

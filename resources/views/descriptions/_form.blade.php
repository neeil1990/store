@csrf

<div class="form-group">
    <label for="key">Ключ</label>
    <input type="text" name="key" id="key" class="form-control" value="{{ old('key', $description->key ?? '') }}" required maxlength="255">
    @error('key')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="content">Содержание</label>
    <textarea name="content" id="content" class="form-control" rows="6">{{ old('content', $description->content ?? '') }}</textarea>
    @error('content')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<button type="submit" class="btn btn-primary">Сохранить</button>
<a href="{{ route('descriptions.index') }}" class="btn btn-secondary">Отмена</a>

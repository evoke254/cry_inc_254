@if(isset($fields) && count($fields) > 0)
    @foreach ($kyc_fields as $item)
        @if ($item->type == "select")
            <div class="col-lg-12 form-group">
                <label for="{{ $item->name }}">{{ $item->label }}</label>
                <select name="{{ $item->name }}" id="{{ $item->name }}" class="form-control nice-select">
                    <option selected disabled>Choose One</option>
                    @foreach ($item->validation->options as $innerItem)
                        <option value="{{ $innerItem }}">{{ $innerItem }}</option>
                    @endforeach
                </select>
            </div>
        @elseif ($item->type == "file")
            <div class="col-lg-12 form-group">
                <label for="{{ $item->name }}" class="form-label">{{ $item->label }} @if ($item->required == true) <span class="text-danger">*</span> @endif </label>
                <input type="file" class="form-control" name="{{ $item->name }}" id="{{ $item->name }}" value="{{ old($item->name) }}">
            </div>
        @elseif ($item->type == "text")
            <div class="col-lg-12 form-group">
                <label for="{{ $item->name }}" class="form-label">{{ $item->label }} @if ($item->required == true) <span class="text-danger">*</span> @endif</label>
                <input type="text" class="form-control" name="{{ $item->name }}" id="{{ $item->name }}" value="{{ old($item->name) }}">
            </div>
        @elseif ($item->type == "textarea")
            <div class="col-lg-12 form-group">
                <label for="{{ $item->name }}" class="form-label">{{ $item->label }} @if ($item->required == true) <span class="text-danger">*</span> @endif</label>
                <textarea name="{{ $item->name }}" class="form-control" id="{{ $item->name }}" rows="5">{{ old($item->name) }}</textarea>
            </div>
        @endif
    @endforeach
@endisset
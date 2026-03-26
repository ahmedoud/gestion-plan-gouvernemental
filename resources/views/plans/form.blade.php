<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $plan->title ?? '') }}">
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $plan->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="start_date">Start Date</label>
    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $plan->start_date->format('Y-m-d') ?? '') }}">
</div>

<div class="form-group">
    <label for="end_date">End Date</label>
    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $plan->end_date->format('Y-m-d') ?? '') }}">
</div>

<div class="form-group">
    <label for="is_active">Status</label>
    <select name="is_active" class="form-control">
        <option value="1" {{ (old('is_active', $plan->is_active ?? 1) == 1) ? 'selected' : '' }}>Active</option>
        <option value="0" {{ (old('is_active', $plan->is_active ?? 0) == 0) ? 'selected' : '' }}>Archive</option>
    </select>
</div>

<button type="submit" class="btn btn-primary">Enregistrer</button>

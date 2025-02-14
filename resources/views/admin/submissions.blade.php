{{-- @foreach ($events as $event)
    <div class="card mb-3">
        <div class="card-body">
            <h5>{{ $event->title }}</h5>
            <p>Status: <strong>{{ $event->status }}</strong></p>

            <form action="{{ route('admin.updateStatus', $event->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()">
                    <option value="Pending" {{ $event->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ $event->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ $event->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </form>
        </div>
    </div>
@endforeach
          --}}
